<?php


namespace Becho;


class Becho 
{
    private static $instance = null;

    private $driver;

    private $echoers = [];

    private $options = [];

    private $ctx;

    private $defaultEchoer = StandardEchoer::class;
    

    function getEchoer(): Echoer 
    {
        $globals = $this->getGlobals();
        // Make it super easy to override an echoer 
        if (isset($globals['BECHO_ECHOER']) && is_object($globals['BECHO_ECHOER'])) {
            $interfaces = class_implements($globals['BECHO_ECHOER']);

            // Verify the BECHO_ECHOER implements the interface
            if($interfaces && in_array(Echoer::class, $interfaces)) {
                return $globals['BECHO_ECHOER'];
            }
        }
        $driver = $this->getDriver();
        return $this->echoers[$driver] ?? new $this->defaultEchoer;
    }

    /**
     * Get name of echoer being used
     */ 
    function getDriver(): string 
    {
        $globals = $this->getGlobals();
        return isset($globals['BECHO_DRIVER']) ? $globals['BECHO_DRIVER'] : $this->driver;
    }

    function getGlobals()
    {
        return $GLOBALS;
    }

    /**
     * Switch to using a different driver
     * @param  string $name
     */
    function useEchoer(string $name): Becho
    {
        $this->driver = $name;
        return $this;
    }
    

    /**
     * Add an Echoer with a given name
     * @param  string $name
     * @param  Echoer $echoer
     */
    function addEchoer(string $name, Echoer $echoer): Becho
    {
        $this->echoers[$name] = $echoer;
        return this;
    }

    function useDefaultOptions(array $options=[]): Becho
    {
        $this->options = $options;
        return $this;   
    }

    function useDefaultContext($ctx)
    {
        $this->ctx = $ctx;
    }

    function echo($text, $ctx=null, $options=[]) 
    {
        $options = is_array($ctx) ? $ctx : $options;
        $options = array_merge($this->options, $options);
        $ctx = is_array($ctx) ? $this->ctx : $ctx;
        $ctx = php_sapi_name() === 'cli' && is_null($ctx) ? \BECHO_CLI : $ctx;
        $ctx = is_null($ctx) ? $this->ctx : $ctx;

        $options['$ctx'] = $ctx;

        $echoer = $this->getEchoer();
        if ($ctx === \BECHO_ESC_ATTR) {
            $text = $echoer->escapeAttribute($text);
        } elseif ($ctx === \BECHO_ESC_HTML) {
            $text = $echoer->escapeHtml($text);
        }


        if ($ctx === \BECHO_CLI) {
            $text = $echoer->inCliContext($text, $options);
        }

        $echoer->echo($text, $options);
    }


    public static function getInstance()
    {
      if (self::$instance == null)
      {
        self::$instance = new static();
      }
      return self::$instance;
    }
}