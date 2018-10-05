<?php
declare(strict_types = 1);

namespace Crazybooot\ConstantsToJs\Generators;

/**
 * Class Es6Generator
 *
 * @package Crazybooot\ConstantsToJs\Generators
 */
class Es6Generator implements GeneratorContract
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function generate(string $data): string
    {
        return "export default {$data}";
    }
}