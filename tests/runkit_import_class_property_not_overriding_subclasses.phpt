--TEST--
runkit7_import() Importing and not overriding subclass properties
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
      if(!function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
class Test {}
class TestSub extends Test {
    public static $s = "s";
    public $v = "v";
}

$o = new TestSub;
echo $o->v, "\n";
echo TestSub::$s, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property_not_overriding_subclasses.inc', RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS);
$o = new TestSub;
echo $o->v, "\n";
echo TestSub::$s, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property_not_overriding_subclasses.inc', RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS | RUNKIT7_IMPORT_OVERRIDE);
echo $o->v, "\n";
$o = new TestSub;
echo $o->v, "\n";
echo TestSub::$s, "\n";
$o->v = 'v';
echo $o->v, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property_not_overriding_subclasses.inc', RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS | RUNKIT7_IMPORT_OVERRIDE | RUNKIT7_OVERRIDE_OBJECTS);
echo $o->v, "\n";
?>
--EXPECTF--
v
s

Notice: runkit7_import(): TestSub::$s already exists, not adding in %s on line %d

Notice: runkit7_import(): TestSub->v already exists, not adding in %s on line %d
v
s
v
IMPORTED: v
IMPORTED: s
v
IMPORTED: v
--XFAIL--
PHP_RUNKIT7_IMPORT_CLASS_PROPS/PHP_RUNKIT7_IMPORT_CLASS_STATIC_PROPS are not supported yet
