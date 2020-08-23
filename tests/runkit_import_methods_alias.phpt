--TEST--
runkit_import() Importing and overriding class methods
--INI--
error_reporting=E_ALL
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !function_exists('runkit_import')) print "skip";
if ((DIRECTORY_SEPARATOR === "\\" && !ZEND_THREAD_SAFE) || PHP_VERSION_ID >= 70300) {
	print "skip TODO: Fix PHP 7.3 NTS runkit_import(). https://github.com/runkit7/runkit7/issues/135 was filed to investigate this\n";
}
?>
--FILE--
<?php

error_reporting(E_ALL & ~E_STRICT);

class ParentClass {
  public static function foo() {
    echo "Parent::foo\n";
  }
}

include dirname(__FILE__) . '/runkit_import_methods1.inc';

ParentClass::foo();
Child::foo();

echo "Importing\n";
runkit_import(dirname(__FILE__) . '/runkit_import_methods2.inc', RUNKIT7_IMPORT_CLASS_METHODS);
Child::foo();

echo "Importing\n";
runkit_import(dirname(__FILE__) . '/runkit_import_methods2.inc', RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_OVERRIDE);
Child::foo();

--EXPECTF--
Parent::foo
Child1::foo
Importing

Deprecated: Function runkit_import() is deprecated in %srunkit_import_methods_alias.php on line 17

Notice: runkit_import(): Child::foo() already exists, not importing in %srunkit_import_methods_alias.php on line 17
Child1::foo
Importing

Deprecated: Function runkit_import() is deprecated in %srunkit_import_methods_alias.php on line 21
Child2::foo