--TEST--
runkit7_import() Importing and overriding method with closure
--SKIPIF--
<?php
    if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
    if(!function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
class Test {
    public function f() {
        $f = function() {
            echo "f\n";
        };
        $f();
    }
}

$t = new Test;
$t->f();
runkit7_import(dirname(__FILE__) . '/runkit_import_method_with_closure.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_FUNCTIONS | RUNKIT7_IMPORT_OVERRIDE);
$t->f();
runkit7_import(dirname(__FILE__) . '/runkit_import_method_with_closure.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_FUNCTIONS | RUNKIT7_IMPORT_OVERRIDE);
$t->f();
?>
--EXPECT--
f
IMPORTED: f
IMPORTED: f
