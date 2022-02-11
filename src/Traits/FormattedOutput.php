<?php

namespace Avastechnology\LaravelConsole\Traits;

/**
 * Class FormattedOutput
 *
 * Helper functions to assist in formatting console output
 *
 * @package Avastechnology\LaravelConsole\Traits
 */
trait FormattedOutput
{
    /**
     * Write a string as information output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @return void
     */
    public function infof(string $format, ...$parameters): void
    {
        $this->info(sprintf($format, ...$parameters));
    }

    /**
     * Write a string as standard output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @param  string|null  $style
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function linef(string $format, array $parameters = [], string $style = null, null|int|string $verbosity = null): void
    {
        $this->line(sprintf($format, ...$parameters), $verbosity);
    }

    /**
     * Write a formatted string as comment output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @return void
     */
    public function commentf(string $format, ...$parameters): void
    {
        $this->comment(sprintf($format, ...$parameters));
    }

    /**
     * Write a formatted string as question output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @return void
     */
    public function questionf(string $format, ...$parameters): void
    {
        $this->question(sprintf($format, ...$parameters));
    }

    /**
     * Write a formatted string as error output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @return void
     */
    public function errorf(string $format, ...$parameters): void
    {
        $this->error(sprintf($format, ...$parameters));
    }

    /**
     * Write a formatted string as warning output.
     *
     * @param  string  $format
     * @param  array  $parameters
     * @return void
     */
    public function warnf(string $format, ...$parameters): void
    {
        $this->warn(sprintf($format, ...$parameters));
    }
}
