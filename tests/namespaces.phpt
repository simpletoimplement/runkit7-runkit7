--TEST--
runkit7_method_add(), runkit7_method_redefine(), runkit7_method_rename() & runkit7_method_copy() functions with namespaces
--SKIPIF--
<?php
	if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--INI--
error_reporting=E_ALL
display_errors=on
--FILE--
<?php

namespace Test;
class Foo {
	public function bar() {
		echo "Called original bar()\n";
	}
}

runkit7_method_redefine('Test\Foo', 'bar', '', 'echo "Mocked\n";');
runkit7_method_add('Test\Foo', 'm', '', '');
runkit7_method_redefine('\Test\Foo', 'm', '', 'echo "New mocked\n";');
runkit7_method_add('\Test\Foo', 'p', '', 'echo "New\n";');
runkit7_method_rename('Test\Foo', 'm', 'n');
runkit7_method_rename('\Test\Foo', 'p', 's');
runkit7_method_copy('Test\Foo', 'o', 'Test\Foo', 'n');
runkit7_method_copy('\Test\Foo', 'q', '\Test\Foo', 's');

$foo = new \Test\Foo();
$foo->bar();
$foo->o();
$foo->q();

runkit7_method_remove('Test\Foo', 'n');
runkit7_method_remove('\Test\Foo', 's');
$foo->n();
?>
--EXPECTF--
Mocked
New mocked
New

Fatal error: Uncaught Error: Call to undefined method Test\Foo::n() in %s:%d
Stack trace:
#0 {main}
  thrown in %s on line %d
