--TEST--
runkit7_import() Importing and overriding method with a static variable
--SKIPIF--
<?php
    if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION || !function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
class Test {
    function f() {
        static $v = 0;
        $v++;
        echo $v, "\n";
    }
}

$t = new Test;
$t->f();
runkit7_import(dirname(__FILE__) . '/runkit_import_method_with_static_var.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_OVERRIDE);
$t->f();
runkit7_import(dirname(__FILE__) . '/runkit_import_method_with_static_var.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_OVERRIDE);
$t->f();
?>
--EXPECT--
1
2
2

