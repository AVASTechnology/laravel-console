<?php

namespace Avastechnology\LaravelConsole\Traits;

use Illuminate\Support\Collection;

/**
 * Class CollectionChoice
 *
 * Use choice function with a collection
 *
 * @package Avastechnology\LaravelConsole\Traits
 */
trait CollectionChoice
{
    /**
     * @param $question
     * @param  Collection  $collection
     * @param $pluckField
     * @param  null  $default
     * @param  null  $attempts
     * @param  false  $multiple
     * @return mixed
     */
    protected function choiceOfCollection(
        $question,
        Collection $collection,
        $pluckField,
        $default = null,
        $attempts = null,
        bool $multiple = false
    ): mixed {
        $choices = $collection->pluck($pluckField)->toArray();
        $selection = $this->choice($question, $choices, $default, $attempts, $multiple);

        $key = array_search($selection, $choices);

        return $collection->get($key);
    }
}
