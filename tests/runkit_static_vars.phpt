--TEST--
Static Variables in runkit modified functions
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
function orig() {
  static $x = 0;
  var_dump(++$x);
}

orig();
runkit7_function_copy('orig', 'funccopy');
funccopy();
runkit7_function_remove('orig');
funccopy();

echo "====\n";

class C {
  public function orig() {
    static $x = 0;
    var_dump(++$x);
  }
}
$c = new C;

$c->orig();
runkit7_method_copy('C', 'copy', 'C', 'orig');
$c->copy();
runkit7_method_remove('C', 'orig');
$c->copy();

--EXPECT--
int(1)
int(2)
int(3)
====
int(1)
int(2)
int(3)
