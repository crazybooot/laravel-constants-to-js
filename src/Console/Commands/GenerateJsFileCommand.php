<?php
declare(strict_types = 1);

namespace Crazybooot\ConstantsToJs\Console\Commands;

use function call_user_func;
use Crazybooot\ConstantsToJs\Generators\GeneratorContract;
use Illuminate\Console\Command;
use function array_key_exists;
use function config;
use function file_put_contents;
use function get_class_constants_start_with;
use function is_callable;
use function json_encode;
use function json_last_error;
use function public_path;

/**
 * Class GenerateJsFileCommand
 *
 * @package Crazybooot\ConstantsToJs\Console\Commands
 */
class GenerateJsFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'constants:js';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate js file with constants';

    /**
     * Execute the console command.
     *
     * @param GeneratorContract $generator
     *
     * @return void
     * @throws \Exception
     */
    public function handle(GeneratorContract $generator): void
    {
        $config = config('constants-to-js');

        $constants = $this->buildTree($config['constants']);

        $json = $this->encode($constants);

        $targetPath = $config['target_path'];

        $js = $generator->generate($json);

        file_put_contents($targetPath, $js);

        $this->info($json);
    }

    /**
     * @param array $node
     *
     * @return array
     */
    protected function buildTree(array $node): array
    {
        $result = [];

        foreach ($node as $const => $value) {
            if (array_key_exists('class', $value)) {
                $result[$const] = $this->prepareConstants($value);
                continue;
            }

            if (array_key_exists('config', $value)) {
                $result[$const] = $this->prepareConfig($value);
                continue;
            }

            $result[$const] = $this->buildTree($value);
        }

        return $result;
    }

    /**
     * @param array $config
     *
     * @return array
     */
    protected function prepareConfig(array $config): array
    {
            $result = [];

            foreach (config($config['config']) as $key => $value) {
                [$key, $value] = $this->transform($config, $key, $value);
                $result[$key] = $value;
            }

            return $result;
    }


    /**
     * @param $class
     *
     * @return array
     */
    protected function prepareConstants(array $class): array
    {
            $result = [];

            foreach (get_class_constants_start_with($class['class'], $class['starts_with'] ?? '') as $key => $value) {

                [$key, $value] = $this->transform($class, $key, $value);
                $result[$key] = $value;
            }

            return $result;
    }

    /**
     * @param array $constants
     *
     * @return string
     * @throws \Exception
     */
    protected function encode(array $constants): string
    {
        $js = json_encode($constants, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).PHP_EOL;

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Could not generate JSON, error code '.json_last_error());
        }

        return $js;
    }

    /**
     * @param       $result
     * @param       $key
     * @param array $class
     * @param       $value
     *
     * @return mixed
     */
    protected function transform(array $class, $key, $value)
    {
        foreach ($class['transform_key'] ?? [] as $func => $params) {
            $key = call_user_func($func, $key, ...$params);
        }

        foreach ($class['transform_value'] ?? [] as $func => $params) {
            $value = call_user_func($func, $value, ...$params);
        }

        return [$key, $value];
    }
}