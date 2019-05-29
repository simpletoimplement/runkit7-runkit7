--TEST--
runkit7_method_rename() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL & (~E_DEPRECATED) & (~E_STRICT));

class runkit7_class {
	function runkit7_original($a) {
		echo "Runkit Original: a is $a\n";
	}
}

runkit7_class::runkit7_original(1);
runkit7_method_rename('runkit7_class','runkit7_original','runkit7_duplicate');
if (method_exists('runkit7_class','runkit7_original')) {
	echo "Runkit Original still exists!\n";
}
runkit7_class::runkit7_duplicate(2);
runkit7_method_rename('runkit7_class','runkit7_duplicate', 'runkitDuplicate');
if (method_exists('runkit7_class','runkit7_duplicate')) {
	echo "Runkit Duplicate still exists!\n";
}
runkit7_class::runkitDuplicate(3);
runkit7_method_rename('runkit7_class','runkitDuplicate', 'runkit7_original');
if (method_exists('runkit7_class','runkitDuplicate')) {
	echo "RunkitDuplicate still exists!\n";
}
runkit7_class::runkit7_original(4);
runkit7_class::runkitDuplicate(4);
?>
--EXPECTF--
Runkit Original: a is 1
Runkit Original: a is 2
Runkit Original: a is 3
Runkit Original: a is 4

Fatal error: Uncaught Error: Call to undefined method runkit7_class::runkit%suplicate() in %s:%d
Stack trace:
#0 {main}
  thrown in %s on line %d
