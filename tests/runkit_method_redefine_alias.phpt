--TEST--
runkit_method_redefine() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
error_reporting=E_ALL
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {
	static function runkit_method($a) {
		echo "a is $a\n";
	}
	static function runkitMethod($a) {
		echo "a is $a\n";
	}
}
runkit_class::runkit_method('foo');
runkit_method_redefine('runkit_class','runkit_method','$b', 'echo "b is $b\n";', RUNKIT7_ACC_STATIC);
runkit_class::runkit_method('bar');
runkit_class::runkitMethod('foo');
runkit_method_redefine('runkit_class','runkitMethod','$b', 'echo "b is $b\n";', RUNKIT7_ACC_STATIC);
runkit_class::runkitMethod('bar');
?>
--EXPECTF--
a is foo

Deprecated: Function runkit_method_redefine() is deprecated in %srunkit_method_redefine_alias.php on line 13
b is bar
a is foo

Deprecated: Function runkit_method_redefine() is deprecated in %srunkit_method_redefine_alias.php on line 16
b is bar