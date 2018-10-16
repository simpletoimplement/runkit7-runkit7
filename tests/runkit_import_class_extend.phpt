--TEST--
runkit_import() Importing and overriding classes extending another loaded class
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
if (!function_exists('runkit_import')) print "skip";
if ((DIRECTORY_SEPARATOR === "\\" && !ZEND_THREAD_SAFE) || PHP_VERSION_ID >= 70300) {
	print "skip this is a known bug on windows/PHP 7.3 and only affects NTS runkit_import(). https://github.com/runkit7/runkit7/issues/135 was filed to investigate this\n";
}
?>
--FILE--
<?php
class ext{
	function ver(){
		print "n\n";
	}
}

runkit_import(dirname(__FILE__) . '/runkit_import_class_extend.inc', RUNKIT_IMPORT_CLASS_METHODS | RUNKIT_IMPORT_OVERRIDE);
$Test = new Test;
$Test->ver();
unset($Test);
//load it once more to override
runkit_import(dirname(__FILE__) . '/runkit_import_class_extend.inc', RUNKIT_IMPORT_CLASS_METHODS | RUNKIT_IMPORT_OVERRIDE);
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
