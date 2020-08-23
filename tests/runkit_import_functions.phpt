--TEST--
runkit7_import() Importing and overriding functions
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION || !function_exists('runkit_import')) print "skip"; ?>
--FILE--
<?php

function foo()
{
	return "foo()\n";
}

print(foo());
runkit7_import(dirname(__FILE__) . '/runkit_import_functions.inc', RUNKIT7_IMPORT_FUNCTIONS);
print(foo());
runkit7_import(dirname(__FILE__) . '/runkit_import_functions.inc', RUNKIT7_IMPORT_OVERRIDE | RUNKIT7_IMPORT_FUNCTIONS);
print(foo());
?>
--EXPECT--
foo()
foo()
IMPORTED: foo()
