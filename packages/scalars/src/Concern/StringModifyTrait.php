<?php

/**
 * Part of Windwalker project.
 *
 * @copyright  Copyright (C) 2019 LYRASOFT.
 * @license    MIT
 */

declare(strict_types=1);

namespace Windwalker\Scalars\Concern;

use Windwalker\Scalars\ArrayObject;
use Windwalker\Scalars\StringObject;
use Windwalker\Utilities\Assert\ArgumentsAssert;
use Windwalker\Utilities\Utf8String;

use function Windwalker\tap;

/**
 * The StringConcatTrait class.
 *
 * @since  __DEPLOY_VERSION__
 */
trait StringModifyTrait
{
    /**
     * split
     *
     * @param  int  $length
     *
     * @return  ArrayObject
     */
    public function chop($length = 1)
    {
        ArgumentsAssert::assert($length >= 1, '{caller} $length must larger than 1, %s given', $length);

        return new ArrayObject(Utf8String::strSplit($this->string, $length, $this->encoding) ?: []);
    }

    /**
     * replace
     *
     * @param  array|string  $search
     * @param  array|string  $replacement
     * @param  int|null      $count
     *
     * @return  static
     */
    public function replace($search, $replacement, int &$count = null)
    {
        return $this->cloneInstance(
            function (StringObject $new) use ($search, $replacement, &$count) {
                $new->string = str_replace($search, $replacement, $new->string, $count);
            }
        );
    }

    /**
     * compare
     *
     * @param  string  $compare
     * @param  bool    $caseSensitive
     *
     * @return  int
     */
    public function compare(string $compare, bool $caseSensitive = true): int
    {
        if ($caseSensitive) {
            return Utf8String::strcmp($this->string, $compare);
        }

        return Utf8String::strcasecmp($this->string, $compare, $this->encoding);
    }

    /**
     * reverse
     *
     * @return  static
     */
    public function reverse()
    {
        return $this->cloneInstance(
            function (StringObject $new) {
                $new->string = Utf8String::strrev($new->string);
            }
        );
    }

    /**
     * substrReplace
     *
     * @param  string  $replace
     * @param  int     $start
     * @param  int     $offset
     *
     * @return  static
     */
    public function substrReplace(string $replace, int $start, int $offset = null)
    {
        return $this->cloneInstance(
            function (StringObject $new) use ($replace, $start, $offset) {
                $new->string = Utf8String::substrReplace($new->string, $replace, $start, $offset, $this->encoding);
            }
        );
    }

    /**
     * ltrim
     *
     * @param  string|null  $charlist
     *
     * @return  static
     */
    public function trimLeft(string $charlist = null)
    {
        return $this->cloneInstance(
            function (StringObject $new) use ($charlist) {
                $new->string = Utf8String::ltrim($new->string, $charlist);
            }
        );
    }

    /**
     * rtrim
     *
     * @param  string|null  $charlist
     *
     * @return  static
     */
    public function trimRight(string $charlist = null)
    {
        return $this->cloneInstance(
            function (StringObject $new) use ($charlist) {
                $new->string = Utf8String::rtrim($new->string, $charlist);
            }
        );
    }

    /**
     * trim
     *
     * @param  string|null  $charlist
     *
     * @return  static
     */
    public function trim(string $charlist = null)
    {
        return $this->cloneInstance(
            function (StringObject $new) use ($charlist) {
                $new->string = Utf8String::trim($new->string, $charlist);
            }
        );
    }

    /**
     * ucfirst
     *
     * @return  static
     */
    public function upperCaseFirst()
    {
        return $this->cloneInstance(
            function (StringObject $new) {
                $new->string = Utf8String::ucfirst($new->string, $this->encoding);
            }
        );
    }

    /**
     * lcfirst
     *
     * @return  static
     */
    public function lowerCaseFirst()
    {
        return $this->cloneInstance(
            function (StringObject $new) {
                $new->string = Utf8String::lcfirst($new->string, $this->encoding);
            }
        );
    }

    /**
     * upperCaseWords
     *
     * @return  static
     */
    public function upperCaseWords()
    {
        return $this->cloneInstance(
            function (StringObject $new) {
                $new->string = Utf8String::ucwords($new->string, $this->encoding);
            }
        );
    }

    /**
     * clearHtml
     *
     * @param  string|null  $allowTags
     *
     * @return  static
     *
     * @since  3.5.13
     */
    public function stripHtmlTags(?string $allowTags = null)
    {
        return $this->cloneInstance(
            static function (self $new) use ($allowTags) {
                $new->string = strip_tags($new->string, $allowTags);
            }
        );
    }

    /**
     * append
     *
     * @param  string|StringObject  $string
     *
     * @return  StringObject
     *
     * @since  __DEPLOY_VERSION__
     */
    public function append($string)
    {
        return tap(
            clone $this,
            static function (StringObject $new) use ($string) {
                $new->string .= $string;
            }
        );
    }

    /**
     * prepend
     *
     * @param  string|StringObject  $string
     *
     * @return  StringObject
     *
     * @since  __DEPLOY_VERSION__
     */
    public function prepend($string)
    {
        return tap(
            clone $this,
            static function (StringObject $new) use ($string) {
                $new->string = $string . $new->string;
            }
        );
    }
}
