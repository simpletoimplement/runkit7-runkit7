--TEST--
runkit_function_rename() function with large switch statements
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--FILE--
<?php
// See https://derickrethans.nl/php7.2-switch.html for an explanation of this optimization.
// This test checks that renamed functions with large switch cases continue to work properly.
function runkitNSwitch(int $n) {
	switch ($n) {
		case 1: echo "one\n"; break;
		case 2: echo "two\n";  // fallthrough
		case 3: echo "three\n"; break;
		case 4: echo "four\n"; break;
		case 5: echo "five\n"; break;
		case 6: echo "six\n"; break;
		case 7: echo "seven\n"; break;
		case 8: echo "eight\n"; break;
	}
}

function runkitSSwitch(string $n) {
	switch ($n) {
		case "one": echo "1\n"; break;
		case "two": echo "2\n";  // fallthrough
		case "three": echo "3\n"; break;
		case "four": echo "4\n"; break;
		case "five": echo "5\n"; break;
		case "six": echo "6\n"; break;
		case "seven": echo "7\n"; break;
		case "eight": echo "8\n"; break;
	}
}
$oldName = 'runkitNSwitch';
$newName = 'runkitNewIntName';
runkitNSwitch(2);
runkit_function_rename($oldName, $newName);
runkitNewIntName(1);
runkitNewIntName(2);
runkitNewIntName(8);
runkitNewIntName(10);
runkitNewIntName(7);
runkitNewIntName(8);

if (function_exists('runkitNSwitch')) {
	echo "Old function name still exists!\n";
}

$oldName = 'runkitSSwitch';
$newName = 'runkitNewStringName';
runkitSSwitch("one");
runkit_function_rename($oldName, $newName);
if (function_exists('runkitSSwitch')) {
	echo "Old function name still exists!\n";
}
runkitNewStringName("one");
runkitNewStringName("one");
runkitNewStringName("missing");
runkitNewStringName("eight");
?>
--EXPECT--
two
three
one
two
three
eight
seven
eight
1
1
1
8
