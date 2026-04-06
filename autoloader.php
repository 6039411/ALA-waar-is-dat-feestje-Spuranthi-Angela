<?php

spl_autoload_register(function($classname) {
    $mappen = [
        __DIR__ . '/Interfaces/',
        __DIR__ . '/Includes/',
        __DIR__ . '/Models/',
        __DIR__ . '/Actions/',
    ];

    foreach ($mappen as $map) {
        $bestand = $map . $classname . '.php';
        if (file_exists($bestand)) {
            require_once $bestand;
            return;
        }
    }
});

?>