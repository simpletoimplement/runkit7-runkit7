--TEST--
runkit7_function_rename() function
--INI--
error_reporting=E_ALL
display_errors=on
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
function runkitSample($n) {
	echo "Runkit Sample: $n\n";
}

$oldName = 'runkitSample';
$newName = 'runkitNewName';
runkitSample(1);
runkit_function_rename($oldName, $newName);
if (function_exists('runkitSample')) {
	echo "Old function name still exists!\n";
}
runkitNewName(2);
echo $oldName, "\n";
echo $newName, "\n";

runkitSample(2);
?>
--EXPECTF--
Runkit Sample: 1

Deprecated: Function runkit_function_rename() is deprecated in %srunkit_function_rename_alias.php on line 9
Runkit Sample: 2
runkitSample
runkitNewName

Fatal error: Uncaught Error: Call to undefined function runkitsample() in %srunkit_function_rename_alias.php:17
Stack trace:
#0 {main}
  thrown in %srunkit_function_rename_alias.php on line 17