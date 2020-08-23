--TEST--
runkit_function_redefine() function
--INI--
error_reporting=E_ALL
display_errors=on
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
$a = 'a';
function runkitSample($c) {
	global $a;
	echo "$a is $c\n";
}

$funcName = 'runkitSample';
runkitSample(1);
runkit_function_redefine($funcName,'$b','global $a; static $is="is"; for($i=0; $i<10; $i++) {} echo "$a $is $b\n";');
$a = 'b';
runkitSample(2);
echo $funcName
?>
--EXPECTF--
a is 1

Deprecated: Function runkit_function_redefine() is deprecated in %srunkit_function_redefine_alias.php on line 10
b is 2
runkitSample