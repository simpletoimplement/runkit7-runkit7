--TEST--
runkit7_method_redefine() must also update method's prototype
--FILE--
<?php

class a {
	function foo() {
	}
}

runkit7_method_redefine("a", "foo", "", "return false;");

eval("
class b extends a {
	function foo() {
	}
}");

echo "==DONE==\n";

?>
--EXPECT--
==DONE==
