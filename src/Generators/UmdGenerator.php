<?php
declare(strict_types = 1);

namespace Crazybooot\ConstantsToJs\Generators;

/**
 * Class UmdGenerator
 *
 * @package Crazybooot\ConstantsToJs\Generators
 */
class UmdGenerator implements GeneratorContract
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function generate(string $data): string
    {
        $js = <<<HEREDOC
(function (global, factory) {
    typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() :
        typeof define === 'function' && define.amd ? define(factory) :
            (global.constants = factory());
}(this, (function () { 'use strict';
    return {$body}
})));
HEREDOC;

        return $js;
    }
}