--TEST--
runkit7_method_remove() function
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL & (~E_DEPRECATED) & (~E_STRICT));

class runkit7_class {
	function runkit7_method() {
		echo "Runkit Method\n";
	}
	function runkitMethod() {
		echo "Runkit Method\n";
	}
}

runkit7_class::runkit7_method();
runkit7_method_remove('runkit7_class','runkit7_method');
if (!method_exists('runkit7_class','runkit7_method')) {
	echo "Runkit Method Removed\n";
}
runkit7_class::runkitMethod();
runkit7_method_remove('runkit7_class','runkitMethod');
if (!method_exists('runkit7_class','runkitMethod')) {
	echo "Runkit Method Removed\n";
}
runkit7_class::runkitMethod();
?>
--EXPECTF--
Runkit Method
Runkit Method Removed
Runkit Method
Runkit Method Removed

Fatal error: Uncaught Error: Call to undefined method runkit7_class::runkitMethod() in %s:%d
Stack trace:
#0 {main}
  thrown in %s on line %d
