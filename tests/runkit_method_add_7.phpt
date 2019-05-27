--TEST--
runkit7_method_add() function
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL & (~E_DEPRECATED) & (~E_STRICT));

class runkit7_class {
}

runkit7_method_add('runkit7_class', 'runkit7_method', '$a, $b = "bar"', 'static $is="is"; echo "a $is $a\nb $is $b\n";');
runkit7_class::runkit7_method('foo','bar');
?>
--EXPECT--
a is foo
b is bar
