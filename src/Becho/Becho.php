<?php


namespace Becho;


class Becho 
{
    private static $instance = null;

    private $driver = "vanilla";

    private $echoers = [];

    private $defaultEchoer = VanillaEchoer::class;
    
    function getEchoer(): Echoer 
    {
        $globals = $this->getGlobals();
        // Make it super easy to override an echoer
        if (isset($globals['BECHO_ECHOER'])) {
            return $globals['BECHO_ECHOER'];
        }
        $driver = $this->getDriver();
        return $this->echoers[$driver] ?? new $this->defaultEchoer;
    }

    function getDriver(): string 
    {
        return isset($globals['BECHO_DRIVER']) ? $globals['BECHO_DRIVER'] : $this->driver;
    }

    function getGlobals()
    {
        return $GLOBALS;
    }

    function useDriver(string $name): Becho
    {
        $this->driver = $name;
        return $this;
    }

    function addEchoer(string $name, Echoer $echoer): Becho
    {
        $this->echoers[$name] = $echoer;
        return this;
    }

    function echo($text, $ctx=\BECHO_RAW, $options=[]) 
    {
        $options = is_array($ctx) ? $ctx : $options;
        $ctx = is_array($ctx) ? \BECHO_RAW : $ctx;
        $ctx = php_sapi_name() === 'cli' && $ctx === \BECHO_RAW ? \BECHO_CLI : $ctx;

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