--TEST--
runkit7_method_add() function for static method
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit7_class {
}

runkit7_method_add('runkit7_class', 'runkit7_method', '$a, $b = "bar"', 'static $is="is"; echo "a $is $a\nb $is $b\n";', RUNKIT_ACC_STATIC | RUNKIT_ACC_PUBLIC);
runkit7_class::runkit7_method('foo','bar');
?>
--EXPECT--
a is foo
b is bar
