--TEST--
runkit7_method_add() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {
}

runkit7_method_add('runkit_class', 'runkit_method', '$a, $b = "bar"', 'static $is="is"; echo "a $is $a\nb $is $b\n";', RUNKIT7_ACC_STATIC);
runkit_class::runkit_method('foo','bar');
?>
--EXPECT--
a is foo
b is bar
