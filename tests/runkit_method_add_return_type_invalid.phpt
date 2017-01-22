--TEST--
runkit_method_add() function should detect invalid return types passed in as a string
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php declare(strict_types=1);
ini_set('error_reporting', (string)(E_ALL));

$retval = runkit_method_add('runkit_class', 'runkit_method', 'string $a, $valid=false', 'return $valid ? $a : new stdClass();', RUNKIT_ACC_STATIC, '/** doc comment */', 'string#');
printf("runkit_method_add returned: %s\n", var_export($retval, true));
printf("Method exists: %s\n", var_export(method_exists('runkit_class', 'runkit_method'), true));
?>
--EXPECTF--
Warning: runkit_method_add(): Return type should match regex %s in %s on line %d
runkit_method_add returned: false
Method exists: false
