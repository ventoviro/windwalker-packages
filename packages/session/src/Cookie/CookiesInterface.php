<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Session\Cookie;

/**
 * Interface CookiesInterface
 */
interface CookiesInterface
{
    public function set(string $name, string $value): bool;

    public function get(string $name): ?string;
}
