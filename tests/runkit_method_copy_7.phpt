--TEST--
runkit7_method_copy() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit7_one {
	public static function runkit7_method($n) {
		echo "Runkit Method: $n\n";
	}

	public static function runkitMethod($n) {
		echo "Runkit Method: $n\n";
	}
}

class runkit7_two {
}

runkit7_one::runkit7_method(1);
runkit7_method_copy('runkit7_two','runkit7_method','runkit7_one');
runkit7_method_copy('runkit7_two','runkitMethod','runkit7_one');
runkit7_one::runkit7_method(2);
runkit7_two::runkit7_method(3);
runkit7_one::runkitMethod(4);
runkit7_two::runkitmethod(5);
runkit7_two::runkitMethod(6);
runkit7_method_remove('runkit7_one','runkit7_method');
if (method_exists('runkit7_one','runkit7_method')) {
	echo "runkit7_method still exists in Runkit One!\n";
}
runkit7_method_remove('runkit7_one','runkitMethod');
if (method_exists('runkit7_one','runkitMethod')) {
	echo "runkitMethod still exists in Runkit One!\n";
}
runkit7_two::runkit7_method(7);
runkit7_two::runkitMethod(8);
if (class_exists('ReflectionMethod')) {
	$reflMethod = new ReflectionMethod('runkit7_two', 'runkitMethod');
	$declClass = $reflMethod->getDeclaringClass();
	echo $declClass->getName(), "\n";
	echo $reflMethod->getName(), "\n";
} else {
	echo "runkit7_two\n";
	echo "runkitMethod\n";
}
?>
--EXPECT--
Runkit Method: 1
Runkit Method: 2
Runkit Method: 3
Runkit Method: 4
Runkit Method: 5
Runkit Method: 6
Runkit Method: 7
Runkit Method: 8
runkit7_two
runkitMethod
