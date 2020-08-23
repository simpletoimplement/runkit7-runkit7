--TEST--
runkit_zval_inspect() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
error_reporting=E_ALL
display_errors=on
--FILE--
<?php
$a = 1;

var_dump(runkit_zval_inspect($a));
?>
--EXPECTF--
Deprecated: Function runkit_zval_inspect() is deprecated in %srunkit_zval_inspect_alias.php on line 4
array(2) {
  ["address"]=>
  string(%d) "0x%s"
  ["type"]=>
  int(4)
}
