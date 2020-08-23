--TEST--
Bug#57249 - Shutdown bug with runkit_import on a function-static variable
--SKIPIF--
<?php if (!extension_loaded("runkit7") || !function_exists('runkit_import')) print "skip"; ?>
--FILE--
<?php
runkit7_import('bug57249.inc', RUNKIT7_IMPORT_CLASS_METHODS);
$g_oBuggyObject = new cBuggyClass();
$g_oBuggyObject->mBuggyMethod();

class cBuggyClass { }

--EXPECT--
mBuggyMethod();
