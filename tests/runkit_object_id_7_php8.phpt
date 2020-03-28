--TEST--
runkit7_object_id should fetch the object handle.
--SKIPIF--
<?php
if(!extension_loaded("runkit7")) print "skip";
if(PHP_VERSION_ID < 80000) print "skip php < 8.0";
?>
--INI--
error_reporting=E_ALL
--FILE--
<?php
try {
	var_dump(runkit7_object_id([]));
} catch (TypeError $e) {
	echo "Caught {$e->getMessage()}\n";
	unset($e);  // reset object id
}
$x = new stdClass();
$y = new stdClass();
var_dump(runkit7_object_id($x));
var_dump(runkit7_object_id($y));
var_dump(runkit7_object_id($x));

?>
--EXPECTF--
Caught runkit7_object_id(): Argument #1 ($obj) must be of type object, array given
int(1)
int(2)
int(1)
