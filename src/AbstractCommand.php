<?php

namespace Avastechnology\LaravelConsole;

use Avastechnology\LaravelConsole\Traits\CollectionChoice;
use Avastechnology\LaravelConsole\Traits\ConsoleDisplays;
use Avastechnology\LaravelConsole\Traits\FormattedOutput;
use Illuminate\Console\Command;

/**
 * Class AbstractCommand
 *
 * @package Avastechnology\LaravelConsole
 */
abstract class AbstractCommand extends Command
{
    use CollectionChoice;
    use ConsoleDisplays;
    use FormattedOutput;
}
