<?php

class Utils
{
    public static function prettyDump(...$things)
    {
        foreach ($things as $thing) {
            echo "<pre>";
            var_dump($thing);
            echo "</pre>";
        }
    }
    public static function getProjectRoot()
    {
        return dirname(__DIR__) . '/sistema-cursos/';
    }

    public static function getPath($relativePath)
    {
        return self::getProjectRoot() . $relativePath;
    }
}
