--TEST--
removing magic __tostring method
--SKIPIF--
<?php
if (!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
if (PHP_VERSION_ID < 80000) print "skip";
?>
--FILE--
<?php
class Test {
    function __tostring() {echo "__tostring\n";}
}

$a = new Test();
try {
    (string) $a;
} catch (Error $e) {
    printf("Caught %s: %s\n", get_class($e), $e->getMessage());
}
runkit7_method_remove("Test", "__tostring");
try {
    (string) $a;
} catch (Error $e) {
    printf("Caught %s: %s\n", get_class($e), $e->getMessage());
}
runkit7_method_add("Test", "__tostring", function () {
	return 'a valid string';
});
$s = (string)$a;
echo "Value: $s\n";
?>
--EXPECT--
__tostring
Caught TypeError: Return value of Test::__tostring() must be of type string, none returned
Caught Error: Object of class Test could not be converted to string
Value: a valid string
