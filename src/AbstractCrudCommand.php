<?php

namespace Avastechnology\LaravelConsole;

use Avastechnology\LaravelConsole\Traits\ActionDrivenCommand;
use Avastechnology\LaravelConsole\Traits\CollectionChoice;
use Avastechnology\LaravelConsole\Traits\ConsoleDisplays;
use Avastechnology\LaravelConsole\Traits\FormattedOutput;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractCrudCommand
 *
 * @package Avastechnology\LaravelConsole
 */
abstract class AbstractCrudCommand extends Command
{
    use ActionDrivenCommand;
    use CollectionChoice;
    use ConsoleDisplays;
    use FormattedOutput;

    /**
     * @var array $actions
     */
    protected static array $actions = [
        'create'    => false,
        'view'      => true,
        'update'    => true,
        'delete'    => true,
    ];

    /**
     * @return string Model class name to use Model::find('target') to automatically pass model to action method
     */
    abstract protected function getModel(): string;

    /**
     * @return void
     */
    protected function createAction()
    {
        throw new \RuntimeException(
            sprintf(
                'The create action is not implemented for command "%s"',
                $this->getName()
            )
        );
    }

    /**
     * @return void
     */
    protected function viewAction(Model $model)
    {
        throw new \RuntimeException(
            sprintf(
                'The view action is not implemented for command "%s"',
                $this->getName()
            )
        );
    }

    /**
     * @return void
     */
    protected function updateAction(Model $model)
    {
        throw new \RuntimeException(
            sprintf(
                'The update action is not implemented for command "%s"',
                $this->getName()
            )
        );
    }

    /**
     * @return void
     */
    protected function deleteAction(Model $model)
    {
        throw new \RuntimeException(
            sprintf(
                'The delete action is not implemented for command "%s"',
                $this->getName()
            )
        );
    }
}
