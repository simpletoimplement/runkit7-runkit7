--TEST--
runkit_function_rename() function corruption prevented when original method is replaced with a substitute.
--SKIPIF--
<?php if (!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php

function hi() {
    echo "Hi";
}

function make_object() {
    return new stdClass();
}

function fake_hi() {
    $c = make_object();
    var_dump($c);
}

runkit_function_rename('hi', 'hi5');

try {
	hi();
} catch (Throwable $e) {
	echo 'Caught ' . get_class($e) . ': ' . $e->getMessage();
}
--EXPECTF--
Caught Error: Call to undefined function hi()
