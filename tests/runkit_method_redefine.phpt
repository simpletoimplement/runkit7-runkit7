--TEST--
runkit7_method_redefine() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
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
runkit7_method_redefine('runkit_class','runkit_method','$b', 'echo "b is $b\n";', RUNKIT7_ACC_STATIC);
runkit_class::runkit_method('bar');
runkit_class::runkitMethod('foo');
runkit7_method_redefine('runkit_class','runkitMethod','$b', 'echo "b is $b\n";', RUNKIT7_ACC_STATIC);
runkit_class::runkitMethod('bar');
?>
--EXPECT--
a is foo
b is bar
a is foo
b is bar
