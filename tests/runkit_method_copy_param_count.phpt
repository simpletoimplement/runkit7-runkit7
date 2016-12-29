--TEST--
runkit_method_redefine() function
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; 
if (PHP_VERSION_ID < 70100) print "skip";
?>
--INI--
display_errors=on
--FILE--
<?php
error_reporting(E_ALL);
class runkit_class {
	public static function runkit_method($a, $b, $c = null) {
		echo "a is $a, b is $b\n";
	}
}

class runkit_subclass extends runkit_class {
	public static function indirect_runkit_method($a) {
		try {
			static::runkit_method($a);
		} catch (Error $e) {
			echo get_class($e) . ": " . $e->getMessage() . "\n";
		}
	}
}

function test_runkit_class() {
	$fn = new ReflectionMethod('runkit_class', 'runkit_method');
	printf("runkit_method param count = %d, required = %d\n", $fn->getNumberOfParameters(), $fn->getNumberOfRequiredParameters());
	unset($fn);
	runkit_class::runkit_method('foo', 'bar');
	runkit_subclass::indirect_runkit_method('foo2');
	runkit_method_rename('runkit_class','runkit_method', 'runkit_method_2');
	runkit_method_add('runkit_class','runkit_method', function($x, $c = 2) {
		echo "Mock: x = $x\n";
	}, RUNKIT_ACC_STATIC);
	$fn = new ReflectionMethod('runkit_class', 'runkit_method');
	printf("runkit_method param count = %d, required = %d\n", $fn->getNumberOfParameters(), $fn->getNumberOfRequiredParameters());
	unset($fn);
	$fn2 = new ReflectionMethod('runkit_subclass', 'runkit_method');
	printf("subclass param count = %d, required = %d\n", $fn2->getNumberOfParameters(), $fn2->getNumberOfRequiredParameters());
	unset($fn2);
	runkit_class::runkit_method('foo', 'bar');
	runkit_subclass::indirect_runkit_method('foo3');
	$fn3 = new ReflectionMethod('runkit_subclass', 'runkit_method_2');
	printf("renamed param count = %d, required = %d\n", $fn3->getNumberOfParameters(), $fn3->getNumberOfRequiredParameters());
	unset($fn3);
}
test_runkit_class();
?>
--EXPECTF--
runkit_method param count = 3, required = 2
a is foo, b is bar
ArgumentCountError: Too few arguments to function runkit_class::runkit_method(), 1 passed in %s on line %d and at least 2 expected
runkit_method param count = 2, required = 1
subclass param count = 2, required = 1
Mock: x = foo
Mock: x = foo3
renamed param count = 3, required = 2
