<?php

namespace sergey144010\tasks;


class Helper
{
    public static function prepareTags(string $string)
    {
        $string = trim($string);
        $tags = preg_split("/[\s,\-\:\;\.]+/", $string);
        return $tags;
    }

    public static function isEmptyVar($var)
    {
        if(empty($var)){
            return false;
        };
        return true;
    }
}