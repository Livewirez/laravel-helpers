<?php

use Illuminate\Support\Facades\Log;





if (! function_exists('array_each_item')) {
    /**
     * Put array values into an new list array. //just call array_values on the array smh
    */
    function array_each_item(array $values)
    {
        $array = [];
        foreach ($values as $value) {
            $array[] = $value;
        }

        return $array;
    }
}

if (! function_exists('assoc_array_convert')) {
    /**
     *Transforms Arrays with two values and sets the first value as the key for the second value.
     * [['Key' => 'TransactionStatus', 'Value' => 'Completed'], ['Key' => 'Amount', 'Value' => 100.0]]
     * becomes
     *  ['TransactionStatus' => 'Completed', 'Amount' => 100.0]
     *
     * @param array $array
     * @param string|integer|null $new_key
     * @param string|integer|null $new_value
     * @return array
     */
    function assoc_array_convert(array $array, string|int $new_key = null, string|int $new_value = null): array
    {
        $new_array = [];

        if($new_key !== null && $new_value !== null) {
            foreach ($array as $single_item) {
                if (! (array_key_exists($new_key, $single_item))) throw new InvalidArgumentException("{$new_key} does nnot exist in this array.");

                else $new_array[$single_item[$new_key]] = $single_item[$new_value];
            }
        } else foreach ($array as $single_item) $new_array[array_values($single_item)[0]] = array_values($single_item)[1];

        return $new_array;
    }
}

if(! function_exists('is_true')) {
    function is_true(bool $value)
    {
        return $value === true ? true : false;
    }
}

if(! function_exists('is_false')) {
    function is_false(bool $value)
    {
        return $value === false ? true : false;
    }
}

if (! function_exists('log_this')) {
    /**
     * Helper to log to any channel of your choosing, by default logs to the normal default file
     *
     * @param mixed $values what will be logged
     * @param array $context provides extra information
     * @param string|null $level choose between `emergency`, `alert`, `critical` , `error`, `warning` , `notice`, `info`, `debug`, this list is a heirachal order in which messages are logged
     * @param string|null $channel if you have another channel defined in config you can put in here, will always choose the default channel
     *
     * @return void
     */
    function log_this(mixed $values, array $context = [], ?string $level = null, ?string $channel = null): void
    {
        $level ??= 'info';

        empty($channel) ? Log::$level($values, $context) : Log::channel($channel)->$level($values,  $context);
    }
}

if(! function_exists('log_secondary')) {
    function log_secondary(mixed $values, array $context = [])
    {
        return log_this($values, $context, channel: 'secondary');
    }
}

