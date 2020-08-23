--TEST--
runkit7_constant_add() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
runkit7_constant_add('FOO', "BAR\n");
echo FOO;
?>
--EXPECT--
BAR
