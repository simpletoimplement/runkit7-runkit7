--TEST--
complex test for renaming, adding and removing with internal functions
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
error_reporting=E_ALL
display_errors=on
runkit.internal_override=On
--FILE--
<?php
runkit7_function_rename('rand', 'oldRand');
echo oldRand(), "\n";
runkit7_function_add('rand', '', 'return "a" . oldRand();');
echo rand(), "\n";
runkit7_function_remove('rand');
runkit7_function_rename('oldRand', 'rand');
echo rand(), "\n";
echo "\n";
// once again
runkit7_function_rename('rand', 'oldRand');
echo oldRand(), "\n";
runkit7_function_add('rand', '', 'return "a" . oldRand();');
echo rand(), "\n";
runkit7_function_remove('rand');
runkit7_function_rename('oldRand', 'rand');
echo rand(), "\n";
?>
--EXPECTF--
%d
a%d
%d

%d
a%d
%d
