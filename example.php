<?php

require "src/function.php";

\Becho\Becho::getInstance()
    ->useDefaultOptions(['color' => BECHO_YELLOW]);


$GLOBALS['BECHO_ECHOER'] = new class extends \Becho\StandardEchoer
{
    function echo($text, $options=[])
    {
        echo $text;
    }
};

// Basic example
becho("What color do you think the text will be?\n", ['color' => BECHO_GREEN]);

// Override the echoer with a global
$GLOBALS['BECHO_ECHOER'] = new class extends \Becho\StandardEchoer
{
    function echo($text, $options=[])
    {
        parent::echo(__FILE__ . $text, $options);
    }
};

?>
<input type="text" value="<?php becho('">\'Trying to break out"', BECHO_ESC_ATTR); ?>" />


