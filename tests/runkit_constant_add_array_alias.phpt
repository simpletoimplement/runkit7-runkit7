--TEST--
runkit_constant_add() function can add simple arrays
--INI--
error_reporting=E_ALL
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
runkit_constant_add('FOO', ["BAR"]);
var_dump(FOO);
echo "\n";
runkit_constant_redefine('FOO', [['key' => "BAR"]]);
var_dump(FOO);
?>
--EXPECTF--
Deprecated: Function runkit_constant_add() is deprecated in %srunkit_constant_add_array_alias.php on line 2
array(1) {
  [0]=>
  string(3) "BAR"
}


Deprecated: Function runkit_constant_redefine() is deprecated in %srunkit_constant_add_array_alias.php on line 5
array(1) {
  [0]=>
  array(1) {
    ["key"]=>
    string(3) "BAR"
  }
}