<?php
class Singleton
{
    private static $instance = NULL;
    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (empty(self::$instance))
        {
            self::$instance = new Singleton();
        }
        return self::$instance;
    }
}


$a = Singleton::getInstance();
$b = Singleton::getInstance();

$s = $a == $b ? 'Y' : 'N';
echo $s;

