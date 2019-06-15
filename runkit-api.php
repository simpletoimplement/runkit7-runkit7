<?php
// API for runkit7 3.0.0
// The runkit7 fork has a slightly different API from what is documented at https://secure.php.net/runkit
//
// - Parameters for return types were added for php7 support.
// - Some functions are unsupported

// Flags for manipulation of elements of classes (methods and constants)
// These constants depend on the php version, and may change.
const RUNKIT7_ACC_RETURN_REFERENCE = 0x4000000;
const RUNKIT7_ACC_PUBLIC           = 0x100;
const RUNKIT7_ACC_PROTECTED        = 0x200;
const RUNKIT7_ACC_PRIVATE          = 0x400;
const RUNKIT7_ACC_STATIC           = 0x1;

// Flags for runkit7_import()
// NOTE: All RUNKIT7_* constants have corresponding RUNKIT_* constants with the same values.
const RUNKIT7_IMPORT_FUNCTIONS = 1;

const RUNKIT7_IMPORT_CLASS_CONSTS = 4;
const RUNKIT7_IMPORT_CLASS_METHODS = 2;
const RUNKIT7_IMPORT_CLASS_PROPS = 8;
const RUNKIT7_IMPORT_CLASS_STATIC_PROPS = 16;
const RUNKIT7_IMPORT_CLASSES = RUNKIT7_IMPORT_CLASS_CONSTS | RUNKIT7_IMPORT_CLASS_METHODS | RUNKIT7_IMPORT_CLASS_PROPS | RUNKIT7_IMPORT_CLASS_STATIC_PROPS;
const RUNKIT7_OVERRIDE_OBJECTS = 32768;

const RUNKIT7_IMPORT_FUNCTIONS = 1;

// Feature identifying constants (defaults).
// These are 1 if enabled by configuration options, and 0 if disabled.
const RUNKIT7_FEATURE_MANIPULATION = 1;
// RUNKIT7_FEATURE_SANDBOX is always 0; it's impractical to implement this in php 7.
const RUNKIT7_FEATURE_SANDBOX = 0;
const RUNKIT7_FEATURE_SUPERGLOBALS = 1;

/**
 * Similar to define(), but allows defining in class definitions as well.
 *
 * NOTE: Constants and class constants within the same file may be inlined by the Zend VM optimizer,
 * and this may or may not have an effect if the constant already exists.
 *
 * Aliases: runkit_constant_add
 *
 * @param string $constname Name of constant to declare. Either a string to indicate a global constant, or classname::constname to indicate a class constant.
 * @param mixed $value null, Bool, Long, Double, String, Resource, or Array value to store in the new constant.
 * @param int $visibility - Visibility of the constant. Public by default.
 * @return bool - TRUE on success or FALSE on failure.
 */
function runkit7_constant_add(string $constname, $value, int $visibility = RUNKIT7_ACC_PUBLIC) : bool {
}

/**
 * Similar to define(), but allows defining in class definitions as well.
 *
 * NOTE: Constants and class constants within the same file may be inlined by the Zend VM optimizer,
 * and this may or may not have an effect if the constant already exists.
 *
 * Aliases: runkit_constant_redefine
 *
 * @param string $constname Name of constant to declare. Either a string to indicate a global constant, or classname::constname to indicate a class constant.
 * @param mixed $value null, Bool, Long, Double, String, Resource, or Array value to store in the new constant.
 * @param int|null $newVisibility The new visibility of the constant. Unchanged by default.
 * @return bool - TRUE on success or FALSE on failure.
 */
function runkit7_constant_redefine(string $constname, $value, int $newVisibility = null) : bool {
}

/**
 * Remove/Delete an already defined constant
 *
 * NOTE: Constants and class constants within the same file may be inlined by the Zend VM optimizer,
 * and this may or may not have an effect if the constant already exists.
 *
 * Aliases: runkit_constant_remove
 *
 * @param string $constname Name of constant to declare. Either a string to indicate a global constant, or classname::constname to indicate a class constant.
 * @return bool - TRUE on success or FALSE on failure.
 */
function runkit7_constant_remove(string $constname) : bool {
}

/**
 * Add a new function, similar to create_function()
 * Gives you more control over the type of function being created
 * (Signature 1 of 2)
 *
 * Aliases: runkit_function_add
 *
 * @param string $funcname Name of function to be created
 * @param string $arglist Comma separated argument list
 * @param string $code Code making up the function
 * @param bool $return_by_reference whether the function should return by reference
 * @param ?string $doc_comment The doc comment of the function
 * @param ?string $return_type Return type of this function (e.g. `stdClass`, `?string`(php 7.1))
 * @return bool - True on success or false on failure.
 */
function runkit7_function_add(string $funcname, string $arglist, string $code, bool $return_by_reference = null, string $doc_comment = null, string $return_type = null, bool $is_strict = null) : bool {
}

/**
 * Add a new function, similar to create_function()
 * Gives you more control over the type of function being created
 * (Signature 2 of 2)
 *
 * Aliases: runkit_function_add
 *
 * @param string $funcname Name of function to be created
 * @param Closure $closure A closure to use as the source for this function. Static variables and `use` variables are copied.
 * @param ?string $doc_comment The doc comment of the function
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_function_add(string $funcname, Closure $closure, string $doc_comment = null, bool $is_strict = null) : bool {
}

/**
 * Copy a function to a new function name
 *
 * Aliases: runkit_function_copy
 *
 * @param string $funcname - Name of existing function
 * @param string $targetname - Name of new function to copy definition to
 * @return bool - True on success or false on failure.
 */
function runkit7_function_copy(string $funcname, string $targetname) : bool {
}

/**
 * Replace a function definition with a new implementation. (Should be equivalent to remove() then add())
 * (Signature 1 of 2)
 *
 * Aliases: runkit_function_redefine
 *
 * @param string $funcname Name of function to redefine
 * @param string $arglist New list of arguments to be accepted by function
 * @param string $code New code implementation
 * @param bool $return_by_reference whether the function should return by reference
 * @param ?string $doc_comment The doc comment of the function
 * @param ?string $return_type Return type of this function (e.g. `stdClass`, `?string`(php 7.1))
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_function_redefine(string $funcname, string $arglist, string $code, bool $return_by_reference = null, string $doc_comment = null, string $return_type = null, bool $is_strict = null) : bool {
}

/**
 * Replace a function definition with a new implementation. (Should be equivalent to remove() then add())
 * (Signature 2 of 2)
 *
 * Aliases: runkit_function_redefine
 *
 * @param string $funcname Name of function to redefine
 * @param Closure $closure A closure to use as the new definition for this function. Static variables and `use` variables are copied.
 * @param ?string $doc_comment The doc comment of the function
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_function_redefine(string $funcname, Closure $closure, string $doc_comment = null, bool $is_strict = null) : bool {
}

/**
 * Remove a function definition.
 *
 * Aliases: runkit_function_remove
 *
 * @param string $funcname Name of function to be deleted
 * @return bool - True on success or false on failure.
 */
function runkit7_function_remove(string $funcname) : bool {
}

/**
 * Change a function's name
 *
 * Aliases: runkit_function_rename
 *
 * @param string $funcname Current function name
 * @param string $newname New function name
 *
 * @return bool - True on success or false on failure.
 */
function runkit7_function_rename(string $funcname, string $newname) : bool {
}

/**
 * Dynamically adds a new method to a given class
 * (Signature 1 of 2)
 *
 * Aliases: runkit_method_add
 *
 * @param string $classname The class to which this method will be added
 * @param string $methodname The name of the method to add
 * @param string $arglist Comma separated argument list
 * @param string $code The code to be evaluated when $methodname is called
 * @param int $flags The type of method to create, can be RUNKIT7_ACC_PUBLIC, RUNKIT7_ACC_PROTECTED or RUNKIT7_ACC_PRIVATE
 *                   optionally combined via bitwise OR with RUNKIT7_ACC_STATIC (since 1.0.1)
 * @param ?string $doc_comment The doc comment of the method
 * @param ?string $return_type Return type of this method (e.g. `stdClass`, `?string`(php 7.1))
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_method_add(string $classname, string $methodname, string $arglist, string $code, int $flags = RUNKIT7_ACC_PUBLIC, string $doc_comment = null, string $return_type = null, bool $is_strict = null) : bool {
}

/**
 * Dynamically adds a new method to a given class, similar to create_function()
 * (Signature 2 of 2)
 *
 * Aliases: runkit_method_add
 *
 * @param string $classname The class to which this method will be added
 * @param string $methodname The name of the method to add
 * @param Closure $closure A closure to use as the source for this function. Static variables and `use` variables and return types are copied.
 * @param int $flags The type of method to create, can be RUNKIT7_ACC_PUBLIC, RUNKIT7_ACC_PROTECTED or RUNKIT7_ACC_PRIVATE
 *                   optionally combined via bitwise OR with RUNKIT7_ACC_STATIC (since 1.0.1)
 * @param ?string $doc_comment The doc comment of the method
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_method_add(string $classname, string $methodname, Closure $closure, int $flags = RUNKIT7_ACC_PUBLIC, string $doc_comment = null, bool $is_strict = null) : bool {
}

/**
 * Copies a method from class to another
 *
 * Aliases: runkit_method_copy
 * @param string $dClass Destination class for copied method
 * @param string $dMethod Destination method name
 * @param string $sClass Source class of the method to copy
 * @param string $sMethod Name of the method to copy from the source class. If this parameter is omitted, the value of $dMethod is assumed.
 * @return bool - True on success or false on failure.
 */
function runkit7_method_copy(string $dClass, string $dMethod, string $sClass, string $sMethod = null) : bool {
}

/**
 * Replace a method definition with a new implementation. (Should be equivalent to remove() then add())
 * (Signature 1 of 2)
 *
 * Aliases: runkit_method_redefine
 *
 * @param string $classname The class in which to redefine the method
 * @param string $methodname The name of the method to redefine
 * @param string $arglist Comma separated argument list for the redefined method
 * @param string $code The new code to be evaluated when methodname is called
 * @param int $flags The type of method to create, can be RUNKIT7_ACC_PUBLIC, RUNKIT7_ACC_PROTECTED or RUNKIT7_ACC_PRIVATE
 *                   optionally combined via bitwise OR with RUNKIT7_ACC_STATIC (since 1.0.1)
 * @param ?string $doc_comment The doc comment of the method
 * @param ?string $return_type Return type of this method (e.g. `stdClass`, `?string`(php 7.1))
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_method_redefine(string $classname, string $methodname, string $args, string $code, int $flags = RUNKIT7_ACC_PUBLIC, string $doc_comment = null, string $return_type = null, bool $is_strict = null) : bool {
}

/**
 * Replace a method definition with a new implementation. (Should be equivalent to remove() then add())
 * (Signature 2 of 2)
 *
 * Aliases: runkit_method_redefine
 *
 * @param string $classname The class in which to redefine the method
 * @param string $methodname The name of the method to redefine
 * @param Closure $closure A closure to use as the new definition for this function. Static variables and `use` variables and return types are copied.
 * @param ?string $doc_comment The doc comment of the method
 * @param ?bool $is_strict Set to true to make the redefined function use strict types.
 * @return bool - True on success or false on failure.
 */
function runkit7_method_redefine(string $classname, string $methodname, Closure $closure, string $doc_comment = null, bool $is_strict = null) : bool {
}

/**
 * Dynamically removes the given method
 * (Signature 2 of 2)
 *
 * Aliases: runkit_method_rename
 *
 * @param string $classname The class in which to remove the method
 * @param string $methodname The name of the method to remove
 * @return bool - True on success or false on failure.
 */
function runkit7_method_remove(string $classname, string $methodname) : bool {
}

/**
 * Dynamically changes the name of the given method
 *
 * Aliases: runkit_method_rename
 * @param string $classname The class in which to rename the method
 * @param string $methodname The name of the method to rename
 * @param string $newname The new name to give to the renamed method
 * @return bool - True on success or false on failure.
 */
function runkit7_method_rename(string $classname, string $methodname, string $newname) : bool {
}

/**
 * Process a PHP file importing function and class definitions, overwriting where appropriate.
 *
 * Aliases: runkit_import
 *
 * @param string $filename Filename to import function and class definitions from.
 * @param int $flags Bitwise OR of the RUNKIT7_IMPORT_* family of constants.
 * @return bool - True on success or false on failure.
 */
function runkit7_import(string $filename, int $flags = RUNKIT7_IMPORT_CLASS_METHODS) : bool {
}

/**
 * Returns information about the data type, reference counts, etc.
 *
 * Aliases: runkit_zval_inspect
 *
 * @param mixed $val
 * @return array - has the fields address (hex string), type (int), is_ref (optional bool), and refcount (optional int)
 */
function runkit7_zval_inspect($value) {
}

/**
 * Gets a unique integer identifier (Will be reused when the object is garbage collected) for an object.
 * This is identical to `spl_object_id`, which will be built into PHP 7.2+.
 * Similar to `spl_object_hash`, but returns an int instead of a string.
 *
 * Aliases: runkit_object_id
 * @param object $obj - The object
 * @return int|false - Returns false if given a non-object.
 */
function runkit7_object_id($obj) : int {
}

/**
 * Gets a unique integer identifier (Will be reused when the object is garbage collected) for an object.
 * This is similar to `spl_object_hash`, but returns an int instead of a string.
 *
 * NOTE: runkit can provide an optional native implementation, but that is currently disabled by default by `./configure`.
 *       spl_object_id is built into PHP 7.2+.
 *
 * @param object $obj - The object
 * @return int|null - Returns null if given a non-object.
 */
function spl_object_id($obj) : int {
}

/**
 * Return numerically indexed array of registered superglobals.
 *
 * Aliases: runkit_superglobals
 * @return string[]
 */
function runkit7_superglobals() : array {
}
