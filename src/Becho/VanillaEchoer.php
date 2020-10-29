<?php

namespace Becho;

class VanillaEchoer implements Echoer
{
    function echo($text, $options=[])
    {
        echo $text;
    }

    function escapeAttribute($text, $options=[]): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    }

    function escapeHtml($text, $options=[]): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    }

    function escapeUrl($text, $options=[]): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    }

    function escapeJs($text, $options=[]): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false);
    }

    function inCliContext($text, $options): string
    {
        if (isset($options['color'])) {
            $color = intval($options['color']);
            return "\e[{$color}m{$text}\e[0m";
        }

        return $text;
    }
}