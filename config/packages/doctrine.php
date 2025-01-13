<?php

use Symfony\Config\DoctrineConfig;

return static function (DoctrineConfig $doctrineConfig): void {
    $em = $doctrineConfig->orm()->entityManager('default');

    $em->mapping('AcMarcheEnquetePublique')
        ->isBundle(false)
        ->type('attribute')
        ->dir('%kernel.project_dir%/src/AcMarche/EnquetePublique/src/Entity')
        ->prefix('AcMarche\EnquetePublique')
        ->alias('AcMarcheEnquetePublique');
};
