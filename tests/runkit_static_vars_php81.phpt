--TEST--
Static Variables in runkit modified functions (php 8.1+)
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip\n";
if(PHP_VERSION_ID < 80100) print "skip static variables in methods changed in php 8.1\n";
?>
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
// TODO: Also test with refcounted types?
// TODO: Investigate if anything needs to be done with static_variables_map_ptr in php 8 and when.
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
int(1)
int(2)
====
int(1)
int(1)
int(2)
