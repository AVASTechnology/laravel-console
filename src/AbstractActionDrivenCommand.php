<?php

namespace Avastechnology\LaravelConsole;

use Avastechnology\LaravelConsole\Traits\ActionDrivenCommand;
use Avastechnology\LaravelConsole\Traits\CollectionChoice;
use Avastechnology\LaravelConsole\Traits\ConsoleDisplays;
use Avastechnology\LaravelConsole\Traits\FormattedOutput;
use Illuminate\Console\Command;

/**
 * Class AbstractActionDrivenCommand
 *
 * @package Avastechnology\LaravelConsole
 */
abstract class AbstractActionDrivenCommand extends Command
{
    use ActionDrivenCommand;
    use CollectionChoice;
    use ConsoleDisplays;
    use FormattedOutput;
}
