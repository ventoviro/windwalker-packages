<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Utilities\Contract;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

/**
 * The AccessibleInterface class.
 *
 * @since  __DEPLOY_VERSION__
 */
interface AccessibleInterface extends
    AccessorAccessibleInterface,
    ArrayAccessibleInterface,
    ObjectAccessibleInterface,
    JsonSerializable,
    DumpableInterface,
    Countable,
    IteratorAggregate,
    NullableInterface
{
    /**
     * Dynamically retrieve the value.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function &__get($key);

    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return void
     */
    public function __set($key, $value);

    /**
     * Dynamically check if an attribute is set.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key);

    /**
     * Dynamically unset an attribute.
     *
     * @param  string  $key
     *
     * @return void
     */
    public function __unset($key);
}
