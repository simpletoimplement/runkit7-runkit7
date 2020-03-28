--TEST--
runkit_method_remove() function
--SKIPIF--
<?php if (!extension_loaded("runkit7") || !RUNKIT_FEATURE_MANIPULATION) print "skip\n"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {
	static function runkit_method() {
		echo "Runkit Method\n";
	}
	static function runkitMethod() {
		echo "Runkit Method\n";
	}
}

runkit_class::runkit_method();
runkit_method_remove('runkit_class','runkit_method');
if (!method_exists('runkit_class','runkit_method')) {
	echo "Runkit Method Removed\n";
}
runkit_class::runkitMethod();
runkit_method_remove('runkit_class','runkitMethod');
if (!method_exists('runkit_class','runkitMethod')) {
	echo "Runkit Method Removed\n";
}
runkit_class::runkitMethod();
?>
--EXPECTF--
Runkit Method
Runkit Method Removed
Runkit Method
Runkit Method Removed

Fatal error: Uncaught Error: Call to undefined method runkit_class::runkitMethod() in %s:%d
Stack trace:
#0 {main}
  thrown in %s on line %d
