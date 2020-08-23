--TEST--
runkit_default_property_add() function - static override
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
      if(!function_exists('runkit_default_property_add')) print "skip";
?>
--INI--
error_reporting=E_ALL
display_errors=on
--FILE--
<?php
class RunkitClass {
}

$className = 'RunkitClass';
$value = true;
runkit_default_property_add($className, 'publicProperty', $value, RUNKIT7_ACC_PUBLIC|RUNKIT7_ACC_STATIC);
var_export(RunkitClass::$publicProperty);
?>
--EXPECTF--
true
