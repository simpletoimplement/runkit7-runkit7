--TEST--
runkit7_method_add() function with closure
--SKIPIF--
<?php
	if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--INI--
display_errors=on
--FILE--
<?php
class Example {
    function foo() {
        echo "foo!\n";
    }
}


// create an Example object
$e = new Example();


for ($i=0; $i<=1; $i++) {
    // Add a new public method
    runkit7_method_add(
        'Example',
        'add',
        function ($num1, $num2) {
            return $num1 + $num2;
        }
    );
    $e->add(12, 4);//echo "\n";
    runkit7_method_remove(
        'Example',
        'add'
    );
}
--EXPECT--
