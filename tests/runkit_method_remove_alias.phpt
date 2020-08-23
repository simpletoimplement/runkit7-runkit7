--TEST--
runkit_method_remove() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
error_reporting=E_ALL
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {
	public static function runkit_method() {
		echo "Runkit Method\n";
	}
	public static function runkitMethod() {
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

Deprecated: Function runkit_method_remove() is deprecated in %srunkit_method_remove_alias.php on line 14
Runkit Method Removed
Runkit Method

Deprecated: Function runkit_method_remove() is deprecated in %srunkit_method_remove_alias.php on line 19
Runkit Method Removed

Fatal error: Uncaught Error: Call to undefined method runkit_class::runkitMethod() in %srunkit_method_remove_alias.php:23
Stack trace:
#0 {main}
  thrown in %srunkit_method_remove_alias.php on line 23