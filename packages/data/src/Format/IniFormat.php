<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Data\Format;

use Windwalker\Utilities\Arr;

/**
 * INI format handler for Data.
 *
 * @since  2.0
 */
class IniFormat implements FormatInterface
{
    /**
     * Converts an object into an INI formatted string
     * - Unfortunately, there is no way to have ini values nested further than two
     * levels deep.  Therefore we will only go through the first two levels of
     * the object.
     *
     * @param  object  $data     Data source object.
     * @param  array   $options  Options used by the formatter.
     *
     * @return  string  INI formatted string.
     */
    public function dump($data, array $options = []): string
    {
        $local  = [];
        $global = [];

        // Iterate over the object to set the properties.
        foreach ($data as $key => $value) {
            // If the value is an object then we need to put it in a local section.
            if (is_array($value)) {
                if (!Arr::isAssociative($value)) {
                    continue;
                }

                // Add the section line.
                $local[] = '';
                $local[] = '[' . $key . ']';

                // Add the properties for this section.
                foreach ($value as $k => $v) {
                    if (is_numeric($k)) {
                        continue;
                    }

                    $local[] = $k . '=' . static::getValueAsINI($v);
                }
            } else {
                // Not in a section so add the property to the global array.
                $global[] = $key . '=' . static::getValueAsINI($value);
            }
        }

        return implode("\n", array_merge($global, $local));
    }

    /**
     * Parse an INI formatted string and convert it into an object.
     *
     * @param  string  $string   INI formatted string to convert.
     * @param  array   $options  An array of options used by the formatter, or a boolean setting to process sections.
     *
     * @return array|false Data array.
     */
    public function parse(string $string, array $options = [])
    {
        try {
            return parse_ini_string(
                $string,
                $options['process_section'] ?? true,
                $options['mode'] ?? INI_SCANNER_NORMAL
            );
        } catch (\Throwable $e) {
            preg_match('/on line (\d+)/', $e->getMessage(), $match);

            throw new \ErrorException(
                $e->getMessage(),
                $e->getCode(),
                E_ERROR,
                '',
                ($match[1] ?? 2) - 1,
                $e
            );
        }
    }

    /**
     * Method to get a value in an INI format.
     *
     * @param  mixed  $value  The value to convert to INI format.
     *
     * @return  string  The value in INI format.
     */
    protected static function getValueAsINI($value)
    {
        $string = '';

        switch (gettype($value)) {
            case 'integer':
            case 'double':
                $string = $value;
                break;

            case 'boolean':
                $string = $value ? 'true' : 'false';
                break;

            case 'string':
                // Sanitize any CRLF characters..
                $string = '"' . str_replace(["\r\n", "\n"], '\\n', $value) . '"';
                break;
        }

        return $string;
    }
}
