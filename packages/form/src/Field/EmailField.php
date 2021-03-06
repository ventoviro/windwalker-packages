<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Form\Field;

/**
 * The EmailField class.
 *
 * @since  2.0
 */
class EmailField extends TextField
{
    /**
     * Property type.
     *
     * @var  string
     */
    protected string $inputType = 'email';
}
