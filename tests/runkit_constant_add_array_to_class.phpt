--TEST--
runkit7_constant_add() function can add simple arrays to classes
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
class A { }
runkit7_constant_add('A::FOO', ["BAR"]);
var_export(A::FOO);
echo "\n";
runkit7_constant_redefine('A::FOO', [['key' => "BAR"]]);
var_export(A::FOO);
?>
--EXPECT--
array (
  0 => 'BAR',
)
array (
  0 => 
  array (
    'key' => 'BAR',
  ),
)
