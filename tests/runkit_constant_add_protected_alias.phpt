--TEST--
runkit_constant_redefine() function redefines protected class constants (when accessing other files, not working for same file)
--INI--
error_reporting=E_ALL
display_errors=on
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--FILE--
<?php
// For this test case to actually work (The php compiler, not opcache, does this optimization), the code would need to be compiled with ZEND_COMPILE_NO_CONSTANT_SUBSTITUTION | ZEND_COMPILE_NO_PERSISTENT_CONSTANT_SUBSTITUTION
// That requires either patching php-src or triggering recompilation of code in affected class and in subclasses.
class TestClass {
	public static function get_foo() {
		// missing unless added by runkit
		return self::_FOO;
	}
}

class TestSubclass extends TestClass {
	public static function get_parent_foo() {
		// missing unless added by runkit
		return self::_FOO;
	}
}

function access_protected_constant() {
	try {
		$x = TestClass::_FOO;
		printf("Fetched constant, value=%s\n", var_export($x, true));
	} catch (Error $e) {
		printf("Caught %s: %s\n", get_class($e), $e->getMessage());
	}
}

error_reporting(E_ALL);

access_protected_constant();
$const = 'TestClass::_FOO';
try {
	$x = TestClass::get_foo();
} catch (Error $e) {
	printf("Caught %s from get_foo: %s\n", get_class($e), $e->getMessage());
}
runkit_constant_add($const, 'roh', RUNKIT7_ACC_PROTECTED);
var_dump($const);
var_dump(TestClass::get_foo());
var_dump(TestSubclass::get_foo());
access_protected_constant();
// TODO: Remove public/protected constants from subclasses automatically, if they're the same value and visibility?
// I forget if upstream does this.
runkit_constant_remove('TestSubclass::_FOO');
runkit_constant_remove($const);
try {
	var_dump(TestClass::get_foo());
	echo "Unexpectedly able to fetch removed constant from TestClass\n";
} catch (Error $e) {
	printf("Caught %s from get_foo: %s\n", get_class($e), $e->getMessage());
}
try {
	var_dump(TestSubclass::get_parent_foo());
	echo "Unexpectedly able to fetch removed constant from TestSubclass::get_parent_foo()\n";
} catch (Error $e) {
	printf("Caught %s from TestSubclass::get_parent_foo: %s\n", get_class($e), $e->getMessage());
}
runkit_constant_add($const, 'dah', RUNKIT7_ACC_PRIVATE);
var_dump($const);
var_dump(TestClass::get_foo());
var_dump(TestSubclass::get_foo());
try {
	var_dump(TestSubclass::get_parent_foo());
	echo "Unexpectedly able to fetch private constant of TestClass from a method declared in TestSubclass\n";
} catch (Error $e) {
	printf("Caught %s from TestSubclass::get_parent_foo: %s\n", get_class($e), $e->getMessage());
}

?>
--EXPECTF--
Caught Error: Undefined %Sconstant %S_FOO%S
Caught Error from get_foo: Undefined %Sconstant %S_FOO%S

Deprecated: Function runkit_constant_add() is deprecated in %srunkit_constant_add_protected_alias.php on line 36
string(15) "TestClass::_FOO"
string(3) "roh"
string(3) "roh"
Caught Error: Cannot access protected const%S TestClass::_FOO

Deprecated: Function runkit_constant_remove() is deprecated in %srunkit_constant_add_protected_alias.php on line 43

Deprecated: Function runkit_constant_remove() is deprecated in %srunkit_constant_add_protected_alias.php on line 44
Caught Error from get_foo: Undefined %Sconstant %S_FOO%S
Caught Error from TestSubclass::get_parent_foo: Undefined %Sconstant %S_FOO%S

Deprecated: Function runkit_constant_add() is deprecated in %srunkit_constant_add_protected_alias.php on line 57
string(15) "TestClass::_FOO"
string(3) "dah"
string(3) "dah"
Caught Error from TestSubclass::get_parent_foo: Undefined %Sconstant %S_FOO%S
