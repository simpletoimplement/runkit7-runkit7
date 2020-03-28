--TEST--
redefine old-style parent ctor
--SKIPIF--
<?php
if (!extension_loaded("runkit7") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
if (PHP_VERSION_ID < 80000) print "skip php < 8.0";
?>
--FILE--
<?php

class Test {
	function test() {
		var_dump("original constructor");
	}
}

class FOO_test extends test {
}

class FOO_test_child extends FOO_test {
}

class FOO_test_child_changed extends Foo_test_child {
	function Foo_test_child_changed() {
		var_dump("FOO_test_child_changed constructor");
	}
}

class FOO_test_child_changed_child extends FOO_test_child_changed {
}

runkit_method_redefine("test", "test", "", "var_dump('in test::test');");
$a = new test;
$a = new foo_test;
$a = new foo_test_child;
$a = new foo_test_child_changed;
$a = new foo_test_child_changed_child;

echo "after renaming\n";
runkit_method_rename("test", "test", "test1");
$a = new test;
$a = new foo_test;
$a = new foo_test_child;
$a = new foo_test_child_changed;
$a = new foo_test_child_changed_child;

$a = new foo_test;
echo "after construct\n";
$a->test1();
echo "==DONE==\n";
?>
--EXPECT--
after renaming
after construct
string(13) "in test::test"
==DONE==
