--TEST--
runkit7_constant_add() function can add objects in php 8.1+
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
if(PHP_VERSION_ID < 80100) print "skip requires php 8.1+\n";
?>
--FILE--
<?php
enum Suit: string {
    case Hearts = 'H';
    case Diamonds = 'D';
    case Spades = 'S';
    case Clubs = 'C';
}
runkit7_constant_add('FOO', (object)['key' => 'value']);
runkit7_constant_add('Hearts', Suit::Hearts);
runkit7_constant_add('Diamonds', [Suit::Diamonds, Suit::Diamonds]);
runkit7_constant_add('Suit::SpadesAlias', Suit::Spades);
var_dump(Hearts);
var_dump(FOO);
var_dump(Diamonds);
var_dump(Suit::SpadesAlias);
var_dump(runkit7_constant_remove('Diamonds'));
foreach (['Spades', 'SpadesAlias'] as $const_name) {
    $rc = new ReflectionClassConstant(Suit::class, $const_name);
    printf("Suit::%s: case=%s\n", $const_name, var_export($rc->isEnumCase(), true));
    printf("Suit::%s: public=%s\n", $const_name, var_export($rc->isPublic(), true));
    var_dump(runkit7_constant_remove("Suit::$const_name"));
    var_dump($rc);
}
echo "Test redefining not supported\n";
var_dump(runkit7_constant_redefine('Suit::Hearts', Suit::Diamonds));
var_dump(Suit::Hearts);
runkit7_constant_redefine('FOO', Suit::Clubs);
var_dump(FOO);

?>
--EXPECTF--
enum(Suit::Hearts)
object(stdClass)#%d (1) {
  ["key"]=>
  string(5) "value"
}
array(2) {
  [0]=>
  enum(Suit::Diamonds)
  [1]=>
  enum(Suit::Diamonds)
}
enum(Suit::Spades)
bool(true)
Suit::Spades: case=true
Suit::Spades: public=true

Warning: runkit7_constant_remove(): Refusing to remove enum case Suit::Spades in %s on line 21
bool(false)
object(ReflectionClassConstant)#%d (2) {
  ["name"]=>
  string(6) "Spades"
  ["class"]=>
  string(4) "Suit"
}
Suit::SpadesAlias: case=false
Suit::SpadesAlias: public=true
bool(true)
object(ReflectionClassConstant)#%d (2) {
  ["name"]=>
  string(11) "SpadesAlias"
  ["class"]=>
  string(4) "Suit"
}
Test redefining not supported

Warning: runkit7_constant_redefine(): Refusing to remove enum case Suit::Hearts in %s on line 25
bool(false)
enum(Suit::Hearts)
enum(Suit::Clubs)