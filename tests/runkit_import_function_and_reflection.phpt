--TEST--
runkit7_import() imports function with reflection
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION || !function_exists('runkit_import')) print "skip"; ?>
--FILE--
<?php
function runkitFunction($param) {
	echo "Runkit function\n";
}

$reflFunc = new ReflectionFunction('runkitFunction');

runkit7_import('runkit_import_function_and_reflection.inc', RUNKIT7_IMPORT_FUNCTIONS | RUNKIT7_IMPORT_OVERRIDE);

var_dump($reflFunc);
$reflFunc->invoke("test");
?>
--EXPECTF--
object(ReflectionFunction)#%d (1) {
  ["name"]=>
  string(30) "__function_removed_by_runkit__"
}

Fatal error: __function_removed_by_runkit__(): A function removed by runkit7 was somehow invoked in %s on line %d
