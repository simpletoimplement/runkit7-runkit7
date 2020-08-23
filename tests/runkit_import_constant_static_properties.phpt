--TEST--
runkit7_import() Importing and overriding static property with constant array as the value
--SKIPIF--
<?php
    if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
    if(!function_exists('runkit_import')) print "skip"
?>
--FILE--
<?php
class Test {
    const C = 1;
    public static $v = array(Test::C,2,3);
}

var_dump(Test::$v);
runkit7_import(dirname(__FILE__) . '/runkit_import_constant_static_properties.inc', RUNKIT7_IMPORT_CLASS_STATIC_PROPS | RUNKIT7_IMPORT_OVERRIDE);
var_dump(Test::$v);
runkit7_import(dirname(__FILE__) . '/runkit_import_constant_static_properties.inc', RUNKIT7_IMPORT_CLASSES | RUNKIT7_IMPORT_OVERRIDE);
var_dump(Test::$v);
?>
--EXPECT--
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(5)
  [2]=>
  int(6)
}
array(3) {
  [0]=>
  int(4)
  [1]=>
  int(5)
  [2]=>
  int(6)
}
--XFAIL--
Using PHP_RUNKIT7_IMPORT_OVERRIDE in combination with PHP_RUNKIT7_IMPORT_CLASS_STATIC_PROPS is not supported.
