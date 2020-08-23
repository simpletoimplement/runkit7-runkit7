--TEST--
redefining methods with static variables
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);


class A {
    public static function m() {
        static $a = 0;
        $a++;
        return $a;
    }
}

echo A::m(), "\n";

runkit7_method_copy('A', 'm1', 'A', 'm');
runkit7_method_remove('A', 'm');

echo A::m1();
?>
--EXPECT--
1
2
