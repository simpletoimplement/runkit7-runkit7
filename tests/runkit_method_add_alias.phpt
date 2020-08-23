--TEST--
runkit_method_add() function
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip\n";
if(PHP_VERSION_ID >= 80000) print "skip php >= 8.0";
?>
--INI--
display_errors=on
error_reporting=E_ALL
--FILE--
<?php
ini_set('error_reporting', E_ALL & (~E_DEPRECATED) & (~E_STRICT));

class runkit_class {
}

runkit_method_add('runkit_class', 'runkit_method', '$a, $b = "bar"', 'static $is="is"; echo "a $is $a\nb $is $b\n";');
runkit_class::runkit_method('foo','bar');
?>
--EXPECT--
a is foo
b is bar
