<?php

function setLocalization($code) {
    $langCodes = array(
        "en" => "en_US",
        "fr" => "fr_FR"
    );
    if (!isset($langCodes[strtolower($code)])) {
        return;
    }
    $baseLangDir = Config::path('app') . '/locale';
    $appName = "messages";
    $lang = $langCodes[strtolower($code)];
    // Set language
    putenv('LC_ALL=' . $lang);
    setlocale(LC_ALL, $lang);

    // Specify the location of the translation tables
    bindtextdomain($appName, realpath($baseLangDir));
    bind_textdomain_codeset($appName, 'UTF-8');
    // Choose domain
    textdomain($appName);
}
