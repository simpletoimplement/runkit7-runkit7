--TEST--
runkit_method_redefine() function
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; 
?>
--INI--
display_errors=on
--FILE--
<?php
error_reporting(E_ALL);
class runkit_class {
	public static function runkit_method($a, $b) {
		echo "a is $a, b is $b\n";
	}
}
class runkit_subclass extends runkit_class {
}

function test_runkit_class() {
	$fn = new ReflectionMethod('runkit_class', 'runkit_method');
	printf("param count = %d, required = %d\n", $fn->getNumberOfParameters(), $fn->getNumberOfRequiredParameters());
	unset($fn);
	runkit_class::runkit_method('foo', 'bar');
	runkit_method_redefine('runkit_class','runkit_method','$a, $b=2, $c=3', 'echo "This is a stub: a=$a\n";', RUNKIT_ACC_STATIC);
	runkit_class::runkit_method('foo');
	runkit_subclass::runkit_method('foo');
	$fn = new ReflectionMethod('runkit_class', 'runkit_method');
	printf("param count = %d, required = %d\n", $fn->getNumberOfParameters(), $fn->getNumberOfRequiredParameters());
	unset($fn);
	$fn2 = new ReflectionMethod('runkit_subclass', 'runkit_method');
	printf("param count = %d, required = %d\n", $fn2->getNumberOfParameters(), $fn2->getNumberOfRequiredParameters());
	unset($fn2);
}
test_runkit_class();
?>
--EXPECT--
param count = 2, required = 2
a is foo, b is bar
This is a stub: a=foo
This is a stub: a=foo
param count = 3, required = 1
param count = 3, required = 1
