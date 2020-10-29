<?php

namespace Becho;

interface Echoer
{
    function echo($text, $options=[]);
    function escapeAttribute($text, $options=[]): string;
    function escapeHtml($text, $options=[]): string;
    function inCliContext($text, $options): string;
}