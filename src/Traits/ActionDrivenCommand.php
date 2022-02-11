<?php

namespace Avastechnology\LaravelConsole\Traits;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Trait ActionDrivenCommand
 *
 * Used to handle a dynamic console command that automatically processes to the "Action" method
 *
 * Override the ActionDrivenCommand::getModel() command to automatically find and pass the model instead of the raw target value
 *
 * Example:
 *  `php artisan action-driven-command update 1`
 *  Runs: ActionDrivenCommand::updateAction(1)
 *
 * @package App\Console\Traits
 */
trait ActionDrivenCommand
{
    /**
     * @return array Array of "action" => requires target (bool or Model class)
     */
    abstract protected function getAvailableActions(): array;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $availableActions = $this->getAvailableActions();
        $action = strtolower($this->argument('action'));
        $method = sprintf(
            '%sAction',
            Str::camel($action)
        );

        if (!isset($availableActions[$action])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Action "%s" is not available.',
                    $action
                )
            );
        }

        if (!method_exists($this, $method)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unknown action "%s". Verify method %s::%s() exists.',
                    $action,
                    class_basename(static::class),
                    $method
                )
            );
        }

        if (!$availableActions[$action]) {
            return $this->$method();
        }

        if (!$this->argument('target')) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Action "%s" requires a target, though no "target" argument was provided.',
                    $action
                )
            );
        }

        $modelClass = $availableActions[$action];
        if (is_string($modelClass) && method_exists($modelClass, 'findOrFail')) {
            return $this->$method($modelClass::findOrFail($this->argument('target')));
        }

        return $this->$method($this->argument('target'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        $arguments = [
            [
                'name' => 'action',
                'mode' => InputArgument::REQUIRED,
                'description' => sprintf(
                    'Action to perform ("%s")',
                    implode(
                        '","',
                        array_keys($this->getAvailableActions())
                    )
                ),
            ]
        ];

        $targetActions = array_filter($this->getAvailableActions());

        if (!empty($targetActions)) {
            $arguments[] =             [
                'name' => 'target',
                'mode' => InputArgument::OPTIONAL,
                'description' => sprintf(
                    'Target hash of the given %s action',
                    implode('/', array_keys($targetActions))
                ),
            ];
        }

        return array_merge(
            parent::getArguments(),
            $arguments
        );
    }
}
