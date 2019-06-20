<?php
declare(strict_types = 1);

return [
    /**
     * Resulting JavaScript object
     */
    'constants'     => [],

    /**
     * Path to generated JavaScript file
     */
    'target_path'   => assets_path('js/constants.js'),
//    'target_path'   => public_path('js/constants.js'),

    /**
     * Format of generated JavasCript file Es6Generator or UmdGenerator
     */
    'generator' => \Crazybooot\ConstantsToJs\Generators\Es6Generator::class,
//    'generator' => \Crazybooot\ConstantsToJs\Generators\UmdGenerator::class,
];