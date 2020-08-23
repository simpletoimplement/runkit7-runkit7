--TEST--
runkit7_constant_remove() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
define('FOO', "BAR\n");
echo FOO;
runkit7_constant_remove('FOO');
if (!defined('FOO')) {
	echo "BAZ\n";
}
?>
--EXPECT--
BAR
BAZ
