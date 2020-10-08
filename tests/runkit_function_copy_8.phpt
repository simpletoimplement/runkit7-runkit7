--TEST--
runkit7_function_copy() function for union types
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
if(PHP_VERSION_ID < 80000) print "skip php8 union type support required";
?>
--FILE--
<?php
function runkitSample(Stringable|string|int $n) {
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
runkit7_function_copy($oldName, $newName);
runkitSample(2);
try {
	runkitSample([]);
} catch (TypeError $e) {
	echo "Caught {$e->getMessage()}\n";
}
runkitDuplicate(3);
runkit7_function_remove($oldName);
if (function_exists('runkitSample')) {
	echo "runkitSample() still exists!\n";
}
runkitDuplicate(4);
echo $oldName, "\n";
echo $newName, "\n";
try {
	runkitDuplicate(new stdClass());
} catch (TypeError $e) {
	echo "Caught {$e->getMessage()}\n";
}
?>
--EXPECT--
Runkit Sample: 1
Runkit Sample: 2
Caught runkitSample(): Argument #1 ($n) must be of type Stringable|string|int, array given, called in %srunkit_function_copy_8.php on line 23
Runkit Sample: 3
Runkit Sample: 4
runkitSample
runkitDuplicate
Caught runkitDuplicate(): Argument #1 ($n) must be of type Stringable|string|int, stdClass given, called in %srunkit_function_copy_8.php on line 36
