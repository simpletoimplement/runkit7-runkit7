--TEST--
runkit7_method_add() function with closure
--SKIPIF--
<?php
if (!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip\n";
?>
--INI--
display_errors=on
--FILE--
<?php
ini_set('error_reporting', E_ALL);

class runkit_class {}

class test {
	public function run() {
		$c = 'use';
		$d = 'ref_use';
		runkit7_method_add('runkit_class', 'runkit_method',
			function($a, $b = "bar") use ($c, &$d) {
			static $is="is";
			global $g;
			echo "a $is $a\nb $is $b\n";
			echo "c $is $c\nd $is $d\n";
			echo "g $is $g\n";
			$d .= ' modified';
		}, RUNKIT7_ACC_STATIC);
		runkit_class::runkit_method('foo', 'bar');
		echo "d after call is $d\n";
	}
}
$g = 'global';
$t = new test();
$t->run();
$rc = new runkit_class();
$rc->runkit_method('foo','bar');
?>
--EXPECTREGEX--
a is foo
b is bar
c is use
d is ref_use
g is global
d after call is ref_use modified
a is foo
b is bar
c is use
d is ref_use modified
g is global
