--TEST--
runkit7_import() Importing and overriding classes extending another loaded class
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
if (!function_exists('runkit_import')) print "skip";
// FIXME this test segfaults in 7.3+ NTS because the class being imported extends a declared class that was already loaded.
if ((DIRECTORY_SEPARATOR === "\\" && !ZEND_THREAD_SAFE) || PHP_VERSION_ID >= 70300) {
	print "skip this is a known bug on windows/PHP 7.3+ and only affects NTS runkit7_import(). https://github.com/runkit7/runkit7/issues/135 was filed to investigate this\n";
}
?>
--FILE--
<?php
class ext{
	function ver(){
		print "n\n";
	}
}

runkit7_import(dirname(__FILE__) . '/runkit_import_class_extend.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_OVERRIDE);
$Test = new Test;
$Test->ver();
unset($Test);
//load it once more to override
runkit7_import(dirname(__FILE__) . '/runkit_import_class_extend.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_OVERRIDE);
$Test = new Test;
$Test->ver();
$Test->aaa();
echo "done\n";
?>
--EXPECTF--
n
n
n
done
