--TEST--
runkit7_import() Importing and overriding function with a static variable
--SKIPIF--
<?php
    if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION || !function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
function f() {
	static $v = 0;
	$v++;
	echo $v, "\n";
}

f();
runkit7_import(dirname(__FILE__) . '/runkit_import_function_with_static_var.inc', RUNKIT7_IMPORT_FUNCTIONS | RUNKIT7_IMPORT_OVERRIDE);
f();
runkit7_import(dirname(__FILE__) . '/runkit_import_function_with_static_var.inc', RUNKIT7_IMPORT_FUNCTIONS | RUNKIT7_IMPORT_OVERRIDE);
f();
?>
--EXPECT--
1
2
2

