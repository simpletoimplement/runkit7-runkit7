--TEST--
runkit_count_objects()
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php

class FOO_test {
}

$objects = [
    new FOO_test(),
    new stdClass(),
    new FOO_test(),
];
$object_names = runkit_count_objects();
unset($objects);
ksort($object_names);
var_export($object_names);
echo "\n";
var_export(runkit_count_objects());

?>
--EXPECT--
array (
  'FOO_test' => 2,
  'stdClass' => 1,
)
array (
)
