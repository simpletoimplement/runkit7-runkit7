--TEST--
runkit7_function_redefine() closure and doc_comment
--SKIPIF--
<?php
	if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--INI--
display_errors=on
--FILE--
<?php
function runkit_function() {}

runkit7_function_redefine('runkit_function', function () {}, 'new doc_comment');
$r1 = new ReflectionFunction('runkit_function');
echo $r1->getDocComment(), "\n";
?>
--EXPECT--
new doc_comment
