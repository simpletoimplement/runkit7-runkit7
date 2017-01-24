--TEST--
runkit_constant_redefine() function redefines protected class constants (when accessing other files, not working for same file)
--SKIPIF--
<?php
if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip";
if (PHP_MAJOR_VERSION == 7 && PHP_MINOR_VERSION == 0) { print "skip no const visibility in 7.0"; }
?>
--FILE--
<?php
require_once __DIR__ . '/runkit_constant_redefine_protected_across_file.inc';
// For this test case to actually work (The php compiler, not opcache, does this optimization), the code would need to be compiled with ZEND_COMPILE_NO_CONSTANT_SUBSTITUTION | ZEND_COMPILE_NO_PERSISTENT_CONSTANT_SUBSTITUTION
// That requires either patching php-src or triggering recompilation of code in affected class and in subclasses.
class TestClass extends TestBaseClass{
	public static function get_foo() {
		return self::_FOO;
	}
}

$const = 'TestBaseClass::_FOO';
var_dump($const, TestClass::get_foo());
runkit_constant_redefine($const, 'roh');
var_dump($const, TestClass::get_foo());
$x = TestClass::get_foo();
runkit_constant_redefine($const, $x);
var_dump($const, TestClass::get_foo());
runkit_constant_redefine($const, ['dah']);
var_dump($const, TestClass::get_foo());
runkit_constant_redefine($const, 2);
var_dump($const, TestClass::get_foo());
// TODO test subclass
?>
--EXPECT--
string(19) "TestBaseClass::_FOO"
string(3) "foo"
string(19) "TestBaseClass::_FOO"
string(3) "roh"
string(19) "TestBaseClass::_FOO"
string(3) "roh"
string(19) "TestBaseClass::_FOO"
array(1) {
  [0]=>
  string(3) "dah"
}
string(19) "TestBaseClass::_FOO"
int(2)
