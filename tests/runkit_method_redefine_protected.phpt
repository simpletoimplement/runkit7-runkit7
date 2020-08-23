--TEST--
runkit7_method_redefine() function for protected methods
--SKIPIF--
<?php if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
error_reporting=E_ALL
display_errors=on
--FILE--
<?php
class runkit7_class {
	protected $a = 'a';
	protected $b = 'b';
	protected function runkit7_method_int($a) {
		static $is = "is";
		echo "{$this->a} $is $a\n";
	}
	public function runkit7_method($a) {
		return $this->runkit7_method_int($a);
	}
}
$obj = new runkit7_class();
$obj->runkit7_method('foo');
runkit7_method_copy('runkit7_class','runkit7_method_old','runkit7_class','runkit7_method_int');
runkit7_method_redefine('runkit7_class','runkit7_method_int','$b', 'static $is="is"; echo "{$this->b} $is $b\n";');
$obj->runkit7_method('bar');
runkit7_method_remove('runkit7_class','runkit7_method_int');
runkit7_method_copy('runkit7_class','runkit7_method_int','runkit7_class','runkit7_method_old');
runkit7_method_remove('runkit7_class','runkit7_method_old');
$obj1 = new runkit7_class();
$obj1->runkit7_method('foo');
?>
--EXPECT--
a is foo
b is bar
a is foo
