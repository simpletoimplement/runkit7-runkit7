--TEST--
removing magic serialize method
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--FILE--
<?php
class Test implements Serializable {
	function serialize() {}
	function unserialize($s) {}
}

$a = new Test();
runkit7_method_remove("Test", "serialize");
$s1 = serialize($a);
?>
--EXPECTF--
Fatal error: Couldn't find implementation for method Test::serialize in Unknown on line %d
