--TEST--
runkit_method_rename() function
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
error_reporting = E_ALL & ~E_DEPRECATED
--FILE--
<?php
// ReflectionMethod::__toString was deprecated in php 7.4, and the deprecation is reversed in 8.0-dev. E_DEPRECATED is suppressed.
class A {
    public static function test() : BInstance{
        return new BInstance();
    }
}
class BInstance{}
function main() {
    var_export((string)(new ReflectionMethod('A', 'test'))->getReturnType());
    runkit_method_copy('A', 'testbackup', 'A', 'test');
    runkit_method_remove('A', 'test');
    var_export((string)(new ReflectionMethod('A', 'testbackup'))->getReturnType());
    runkit_method_copy('A', 'test', 'A', 'testbackup');
    runkit_method_remove('A', 'testbackup');
    var_export((string)(new ReflectionMethod('A', 'test'))->getReturnType());
}
main();
main();
main();
main();
--EXPECT--
'BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance''BInstance'
