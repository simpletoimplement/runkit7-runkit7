--TEST--
runkit_method_rename() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
error_reporting=E_ALL
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {
	public static function runkit_original($a) {
		echo "Runkit Original: a is $a\n";
	}
}

runkit_class::runkit_original(1);
runkit_method_rename('runkit_class','runkit_original','runkit_duplicate');
if (method_exists('runkit_class','runkit_original')) {
	echo "Runkit Original still exists!\n";
}
runkit_class::runkit_duplicate(2);
runkit_method_rename('runkit_class','runkit_duplicate', 'runkitDuplicate');
if (method_exists('runkit_class','runkit_duplicate')) {
	echo "Runkit Duplicate still exists!\n";
}
runkit_class::runkitDuplicate(3);
runkit_method_rename('runkit_class','runkitDuplicate', 'runkit_original');
if (method_exists('runkit_class','runkitDuplicate')) {
	echo "RunkitDuplicate still exists!\n";
}
runkit_class::runkit_original(4);
runkit_class::runkitDuplicate(4);
?>
--EXPECTF--
Runkit Original: a is 1

Deprecated: Function runkit_method_rename() is deprecated in %srunkit_method_rename_alias.php on line 11
Runkit Original: a is 2

Deprecated: Function runkit_method_rename() is deprecated in %srunkit_method_rename_alias.php on line 16
Runkit Original: a is 3

Deprecated: Function runkit_method_rename() is deprecated in %srunkit_method_rename_alias.php on line 21
Runkit Original: a is 4

Fatal error: Uncaught Error: Call to undefined method runkit_class::runkitDuplicate() in %srunkit_method_rename_alias.php:26
Stack trace:
#0 {main}
  thrown in %srunkit_method_rename_alias.php on line 26