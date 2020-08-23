--TEST--
runkit7_import() Importing and overriding class properties with inheritance with overriding objects
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
      if(!function_exists('runkit_import')) print "skip";
?>
--FILE--
<?php
class Test {
    public static $s = "s";
    public $v = "v";
    private $p = "p";
    protected $o = "o";

    public function getPrivate() {return $this->p;}
    public function getProtected() {return $this->o;}
}

class SubClass extends Test {}

$o = new SubClass;
echo $o->v, "\n";
echo $o->getPrivate(), "\n";
echo $o->getProtected(), "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property_and_inheritance.inc', RUNKIT7_IMPORT_CLASS_PROPS |
                                                                                       RUNKIT7_IMPORT_CLASS_STATIC_PROPS |
                                                                                       RUNKIT7_IMPORT_OVERRIDE);
$o1 = new SubClass;
echo $o->v, "\n";
echo $o->getPrivate(), "\n";
echo $o->getProtected(), "\n";
echo $o1->v, "\n";
echo $o1->getPrivate(), "\n";
echo $o1->getProtected(), "\n";
runkit7_import(dirname(__FILE__) . '/runkit_import_class_property_and_inheritance.inc', RUNKIT7_IMPORT_CLASS_PROPS |
                                                                                       RUNKIT7_IMPORT_CLASS_STATIC_PROPS |
                                                                                       RUNKIT7_IMPORT_OVERRIDE |
                                                                                       RUNKIT7_OVERRIDE_OBJECTS);
echo $o->v, "\n";
echo $o->getPrivate(), "\n";
echo $o->getProtected(), "\n";
?>
--EXPECTF--
v
p
o

Notice: runkit7_import(): Making SubClass::p public to remove it from class without objects overriding in %s on line %d

Notice: runkit7_import(): Making SubClass::o public to remove it from class without objects overriding in %s on line %d
v
p
o
IMPORTED: v
IMPORTED: p
IMPORTED: o
IMPORTED: v
IMPORTED: p
IMPORTED: o
--XFAIL--
Using PHP_RUNKIT7_IMPORT_OVERRIDE in combination with PHP_RUNKIT7_IMPORT_CLASS_PROPS/PHP_RUNKIT7_IMPORT_CLASS_STATIC_PROPS is not supported
