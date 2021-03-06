<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Form\Attributes;

use Windwalker\Form\Form;
use Windwalker\Utilities\Attributes\AttributeHandler;
use Windwalker\Utilities\Attributes\AttributeInterface;

/**
 * The Group class.
 */
class Group implements AttributeInterface
{
    public string $name;

    /**
     * Fieldset constructor.
     *
     * @param  string       $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function __invoke(AttributeHandler $handler)
    {
        return function () use ($handler) {
            $resolver = $handler->getResolver();

            /** @var Form $form */
            $form = $resolver->getOption('form');

            $form->group($this->name, $handler);
        };
    }
}
