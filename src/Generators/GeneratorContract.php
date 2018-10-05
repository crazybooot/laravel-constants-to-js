<?php
declare(strict_types = 1);

namespace Crazybooot\ConstantsToJs\Generators;

/**
 * Interface GeneratorContract
 *
 * @package Crazybooot\ConstantsToJs\Generators
 */
interface GeneratorContract
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function generate(string $data): string;
}