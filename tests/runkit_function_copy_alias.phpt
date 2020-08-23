--TEST--
runkit_function_copy() function
--INI--
error_reporting=E_ALL
display_errors=on
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
function runkitSample($n) {
	static $runkit = "Runkit";
	$v = explode(".", PHP_VERSION);
	if($v[0] >= 5) {
		$constArray = array('a'=>1);
	}
	for ($i = 0; $i < 10; $i++) {}
	$sample = "Sample";
	if ($v[0] >= 5 && $constArray != array('a'=>1)) {
		echo "FAIL!";
	}
	echo "$runkit $sample: $n\n";
}

$oldName = 'runkitSample';
$newName = 'runkitDuplicate';

runkitSample(1);
runkit_function_copy($oldName, $newName);
runkitSample(2);
runkitDuplicate(3);
runkit_function_remove($oldName);
if (function_exists('runkitSample')) {
	echo "runkitSample() still exists!\n";
}
runkitDuplicate(4);
echo $oldName, "\n";
echo $newName, "\n";
?>
--EXPECTF--
Runkit Sample: 1

Deprecated: Function runkit_function_copy() is deprecated in %srunkit_function_copy_alias.php on line 20
Runkit Sample: 2
Runkit Sample: 3

Deprecated: Function runkit_function_remove() is deprecated in %srunkit_function_copy_alias.php on line 23
Runkit Sample: 4
runkitSample
runkitDuplicate