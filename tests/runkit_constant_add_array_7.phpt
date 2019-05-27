--TEST--
runkit7_constant_add() function can add simple arrays
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
runkit7_constant_add('FOO', ["BAR"]);
var_export(FOO);
echo "\n";
runkit7_constant_redefine('FOO', [['key' => "BAR"]]);
var_export(FOO);
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
