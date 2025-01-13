<?php

use Symfony\Config\TwigConfig;

return static function (TwigConfig $twigConfig): void {
    $twigConfig
        ->path('%kernel.project_dir%/src/AcMarche/EnquetePublique/templates', 'AcMarcheEnquetePublique')
        ->formThemes(['bootstrap_5_layout.html.twig']);
};
