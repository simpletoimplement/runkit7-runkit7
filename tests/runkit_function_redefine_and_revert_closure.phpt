--TEST--
runkit7_function_redefine() and revert
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
error_reporting=E_ALL
display_errors=on
runkit.internal_override=On
--FILE--
<?php
//xdebug_start_code_coverage();
for ($i = 0; $i < 3; $i++) {
    echo sprintf("%s\n",'bar');
    runkit7_function_copy('sprintf','sprintf_old');
    runkit7_function_redefine('sprintf', function (string $a, string $b): string {
        return "new function\n" . sprintf_old($a,$b);
    });
    echo sprintf("%s\n",'bar');
    echo "Done call\n";
    runkit7_function_remove('sprintf');
    echo "Removed redefined function\n";
    echo sprintf_old("calling original %s\n", "sprintf");
    echo "Done call to copy\n";
    runkit7_function_copy('sprintf_old','sprintf');
    echo sprintf("before removing sprintf_old:%s\n", 'foo');
    runkit7_function_remove('sprintf_old');
    echo sprintf("%s\n",'foo');
}
?>
--EXPECT--
bar
new function
bar
Done call
Removed redefined function
calling original sprintf
Done call to copy
before removing sprintf_old:foo
foo
bar
new function
bar
Done call
Removed redefined function
calling original sprintf
Done call to copy
before removing sprintf_old:foo
foo
bar
new function
bar
Done call
Removed redefined function
calling original sprintf
Done call to copy
before removing sprintf_old:foo
foo
--XFAIL--
Expected to fail because this bug was just discovered with runkit.internal_override and functions from closures.
