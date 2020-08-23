--TEST--
runkit7_import() Importing and overriding class properties
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
      if(!function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
class Test {
    public static $s = "s";
    public $v = "v";
}

$o = new Test;
echo $o->v, "\n";
echo Test::$s, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property.inc', RUNKIT7_IMPORT_CLASS_PROPS);
$o = new Test;
echo $o->v, "\n";
echo Test::$s, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property.inc', RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS | RUNKIT7_IMPORT_OVERRIDE);
echo $o->v, "\n";
$o = new Test;
echo $o->v, "\n";
echo Test::$s, "\n";
$o->v = 'v';
echo $o->v, "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property.inc', RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS | RUNKIT7_IMPORT_OVERRIDE | RUNKIT7_OVERRIDE_OBJECTS);
echo $o->v, "\n";
?>
--EXPECTF--
v
s

Notice: runkit7_import(): Test->v already exists, not importing in %s on line %d
v
s
v
IMPORTED: v
IMPORTED: s
v
IMPORTED: v
--XFAIL--
Property manipulation isn't supported, including in runkit_import.
