<?php

namespace Vortexgin\CoreBundle\Util;

/**
 * String Hexadecimal Converter.
 *
 * @author Tommy Dian P
 * @license GPL
 */
abstract class StringHex
{
    public static function toHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); ++$i) {
            $hex .= dechex(ord($string[$i]));
        }

        return $hex;
    }

    public static function toString($hex)
    {
        $string = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i].$hex[$i + 1]));
        }

        return $string;
    }
}
