--TEST--
runkit7_method_redefine() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit7_class {
	static function runkit7_method($a) {
		echo "a is $a\n";
	}
	static function runkitMethod($a) {
		echo "a is $a\n";
	}
}
runkit7_class::runkit7_method('foo');
runkit7_method_redefine('runkit7_class','runkit7_method','$b', 'echo "b is $b\n";', RUNKIT_ACC_STATIC);
runkit7_class::runkit7_method('bar');
runkit7_class::runkitMethod('foo');
runkit7_method_redefine('runkit7_class','runkitMethod','$b', 'echo "b is $b\n";', RUNKIT_ACC_STATIC);
runkit7_class::runkitMethod('bar');
?>
--EXPECT--
a is foo
b is bar
a is foo
b is bar
