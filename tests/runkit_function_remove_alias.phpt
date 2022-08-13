--TEST--
runkit_function_remove() function
--INI--
error_reporting=E_ALL
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
function runkitSample() {
	echo "Function Exists\n";
}

$name = 'runkitSample';
runkitSample();
runkit_function_remove($name);
if (!function_exists('runkitSample')) {
	echo "Function Removed\n";
}
echo $name, "\n";
runkitSample();
?>
--EXPECTF--
Function Exists

Deprecated: Function runkit_function_remove() is deprecated in %srunkit_function_remove_alias.php on line 8
Function Removed
runkitSample

Fatal error: Uncaught Error: Call to undefined function runkit%sample() in %srunkit_function_remove_alias.php:13
Stack trace:
#0 {main}
  thrown in %srunkit_function_remove_alias.php on line 13