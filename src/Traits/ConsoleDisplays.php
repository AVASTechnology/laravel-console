<?php

namespace Avastechnology\LaravelConsole\Traits;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\Table;

/**
 *
 */
trait ConsoleDisplays
{
    /**
     * @param  Collection  $collection
     * @param  array|null  $fields
     */
    protected function displayCollection(Collection $collection, array $fields = null)
    {
        if (is_null($fields)) {
            $fields = array_keys($collection->first()->toArray());
        }

        $fieldFilter = array_flip($fields);
        $blankRow = array_fill_keys($fields, null);

        $table = new Table($this->output);
        $table->setHeaders($fields);

        foreach ($collection as $item) {
            $row = [];
            if (is_array($item)) {
                $row = $item;
            } elseif ($item instanceof Arrayable) {
                $row = array_map(
                    function ($value) {
                        if (is_null($value)) {
                            return '[NULL]';
                        }

                        if (is_bool($value)) {
                            return ($value ? '[TRUE]' : '[FALSE]');
                        }

                        if (is_scalar($value)) {
                            return $value;
                        }

                        if (is_array($value)) {
                            return json_encode($value);
                        }

                        if ($value instanceof \DateTime) {
                            return $value->format('r');
                        }

                        return '[UNKNOWN]';
                    },
                    $item->toArray()
                );
            }

            $table->addRow(
                array_merge(
                    $blankRow,
                    array_intersect_key(
                        $row,
                        $fieldFilter
                    )
                )
            );
        }

        $table->render();
    }

    /**
     * @param  array|\Iterator|Arrayable  $keyValuePairs
     * @param  array|null  $fields
     * @param  string  $indent
     * @param  bool  $verbose
     */
    protected function displayKeyValuePairs($keyValuePairs, array $fields = null, string $indent = '  ', bool $verbose = false)
    {
        if ($keyValuePairs instanceof Arrayable) {
            $keyValuePairs = $keyValuePairs->toArray();
        }

        $valueFormatter = function($value, $indention, $verbose) use (&$valueFormatter, $indent) {
            if (is_null($value)) {
                $value = '[NULL]';
            }

            if (is_bool($value)) {
                $value = ($value ? '[TRUE]' : '[FALSE]');
            }

            if ($value instanceof \DateTime) {
                $value = $value->format('r');
            }

            if ($verbose && (is_array($value) || is_object($value))) {
                if (is_array($value) && empty($value)) {
                    $value = '[]';
                } else {
                    if (is_object($value)) {
                        $data = ($value instanceof Arrayable ? $value->toArray() : get_object_vars($value));
                        $verboseString = sprintf(
                            "%s {\n",
                            get_class($value)
                        );
                    } else {
                        $data = $value;
                        $verboseString = "[\n";
                    }

                    foreach ($data as $key => $val) {
                        $val = $valueFormatter($val, $indention . $indent, $verbose);

                        $verboseString .= sprintf(
                            "%s%s => %s\n",
                            $indention . $indent,
                            $key,
                            (is_scalar($val) ? $val : '[UNKNOWN]')
                        );
                    }

                    $value = sprintf(
                        '%s%s%s',
                        $verboseString,
                        $indention,
                        is_object($value) ? '}' : ']'
                    );
                }
            }

            if (is_array($value)) {
                $value = json_encode($value);
            }

            if (is_object($value)) {
                $value = get_class($value);
            }

            return $value;
        };

        foreach ($keyValuePairs as $field => $value) {
            $value = $valueFormatter($value, $indent, $verbose);

            $this->line(
                sprintf(
                    '%s%s => %s',
                    $indent,
                    $field,
                    (is_scalar($value) ? $value : '[UNKNOWN]')
                )
            );
        }
    }
}
