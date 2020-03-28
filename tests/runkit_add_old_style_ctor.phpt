--TEST--
add old-style parent ctor
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
if(PHP_VERSION_ID >= 80000) print "skip php >= 8.0";
?>
--FILE--
<?php

class Test {
}

class FOO_test extends test {
}

class FOO_test_Child extends FOO_test {
}

runkit_method_add("test", "test", "", "var_dump('new constructor');");
$a = new test;
$a = new foo_test;
$a = new FOO_test_Child;

echo "after removing\n";

runkit_method_remove("test", "test");
$a = new test;
$a = new foo_test;
$a = new FOO_test_Child;

echo "==DONE==\n";
?>
--EXPECT--
string(15) "new constructor"
string(15) "new constructor"
string(15) "new constructor"
after removing
==DONE==
