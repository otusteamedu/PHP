<?php


namespace Repetitor202\Proxy;


class MegaSuperPuperNewsHtmlService
{
    public function build(string $message): string
    {
        $resp = '<div style="border-color: blueviolet;border-style: solid">';
        $resp .= '<h4 style="background-color: yellow">MegaSuperPuperNewsHtmlService</h4>';
        $resp .= $message;
        $resp .= '</div>';

        return $resp;
    }
}