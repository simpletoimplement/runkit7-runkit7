--TEST--
runkit.superglobal setting creates superglobals that can be referenced multiple ways. (new function name) (8.1+)
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip\n";
if(!extension_loaded("session")) print "skip - This test assumes \$_SESSION will exist, but the session extension isn't enabled/installed\n";
if(PHP_VERSION_ID < 80100) print "skip GLOBALS changed in 8.1\n";
?>
--INI--
display_errors=on
runkit.superglobal=foo
error_reporting=E_ALL
--FILE--
<?php
ini_set('error_reporting', E_ALL);

function capture_runkit_superglobals_dump() {
    ob_start();
    debug_zval_dump(runkit_superglobals());
    return ob_get_clean();
}

class FooClass {
    public $prop;
    public function __construct($value) {
        $this->prop = $value;
    }

    public function bar() {
        debug_print_backtrace();
        var_dump($GLOBALS['foo']);
        var_dump($foo);
        // Verify that runkit_superglobals properly reference counts string keys, call it twice.
        $result = capture_runkit_superglobals_dump();
        echo $result;
        // In php 8.1, debug_zval_dump starts printing "interned" for internally interned strings.
        debug_zval_dump(array_keys($GLOBALS));
        $result2 = capture_runkit_superglobals_dump();
        echo "result === result2: ";
        $same = $result === $result2;
        var_dump($same);
        if (!$same) {
            echo "result2\n";
            var_dump($result2);
        }
    }
}

function initfoo() {
    $foo = new FooClass('value');
}

function usefoo() {
    $foo->bar();
}
initfoo();
usefoo();
?>
--EXPECTF--
#0 %srunkit_superglobals_obj_alias_php81.php(41): FooClass->bar()
#1 %srunkit_superglobals_obj_alias_php81.php(44): usefoo()
object(FooClass)#1 (1) {
  ["prop"]=>
  string(5) "value"
}
object(FooClass)#1 (1) {
  ["prop"]=>
  string(5) "value"
}

Deprecated: Function runkit_superglobals() is deprecated in %srunkit_superglobals_obj_alias_php81.php on line 6
array(10) refcount(1){
  [0]=>
  string(7) "GLOBALS" interned
  [1]=>
  string(4) "_GET" interned
  [2]=>
  string(5) "_POST" interned
  [3]=>
  string(7) "_COOKIE" interned
  [4]=>
  string(7) "_SERVER" interned
  [5]=>
  string(4) "_ENV" interned
  [6]=>
  string(8) "_REQUEST" interned
  [7]=>
  string(6) "_FILES" interned
  [8]=>
  string(8) "_SESSION" interned
  [9]=>
  string(3) "foo" refcount(3)
}
array(8) refcount(1){
  [0]=>
  string(4) "_GET" interned
  [1]=>
  string(5) "_POST" interned
  [2]=>
  string(7) "_COOKIE" interned
  [3]=>
  string(6) "_FILES" interned
  [4]=>
  string(4) "argv" interned
  [5]=>
  string(4) "argc" interned
  [6]=>
  string(7) "_SERVER" interned
  [7]=>
  string(3) "foo" interned
}
result === result2: bool(true)