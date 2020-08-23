--TEST--
runkit7_method_copy() causes uninitialized read
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php

runkit7_method_copy('test', "new_method", "test", "old_method");

class test
{
    function old_method() {
            if(1)
                $this->a[] = "b";
    }
}

echo "==DONE==\n";

?>
--EXPECT--
==DONE==
