--TEST--
reflection should pick up runkit7 arginfo
--SKIPIF--
<?php
if(!extension_loaded("runkit7") || !function_exists('runkit_superglobals') || !RUNKIT7_FEATURE_MANIPULATION) print "skip";
?>
--INI--
error_reporting=E_ALL
--FILE--
<?php
foreach ([
    'runkit_constant_add',
    'runkit7_constant_add',
    'runkit_constant_redefine',
    'runkit7_constant_redefine',
    'runkit_constant_remove',
    'runkit7_constant_remove',
    'runkit_function_add',
    'runkit7_function_add',
    'runkit_function_copy',
    'runkit7_function_copy',
    'runkit_function_redefine',
    'runkit7_function_redefine',
    'runkit_function_remove',
    'runkit7_function_remove',
    'runkit_function_rename',
    'runkit7_function_rename',
    'runkit_method_add',
    'runkit7_method_add',
    'runkit_method_copy',
    'runkit7_method_copy',
    'runkit_method_redefine',
    'runkit7_method_redefine',
    'runkit_method_remove',
    'runkit7_method_remove',
    'runkit_method_rename',
    'runkit7_method_rename',
    'runkit_superglobals',
    'runkit7_superglobals',
    'runkit_zval_inspect',
    'runkit7_zval_inspect',
] as $name) {
$function = new ReflectionFunction($name);
printf("%-30s: %d to %d args: (%s)%s\n",
    $name,
    $function->getNumberOfRequiredParameters(),
    $function->getNumberOfParameters(),
    implode(', ', array_map(function(ReflectionParameter $param) {
        $raw_type = $param->getType();
        $type = @(string) $raw_type;  // __toString deprecated in 7.4 but reversed in 8.0
        if ($raw_type && $raw_type->allowsNull() && strpos($type, '?') === false) {
            $type = '?' . $type;
        }
        $result = '$' . $param->getName();
        if ($type) {
            return "$type $result";
        }
        return $result;
    }, $function->getParameters())),
    $function->isDeprecated() ? ' (Deprecated)' : ''
);
}


?>
--EXPECT--
runkit_constant_add           : 2 to 3 args: (string $constant_name, $value, int $new_visibility) (Deprecated)
runkit7_constant_add          : 2 to 3 args: (string $constant_name, $value, ?int $new_visibility)
runkit_constant_redefine      : 2 to 3 args: (string $constant_name, $value, ?int $new_visibility) (Deprecated)
runkit7_constant_redefine     : 2 to 3 args: (string $constant_name, $value, ?int $new_visibility)
runkit_constant_remove        : 1 to 1 args: (string $constant_name) (Deprecated)
runkit7_constant_remove       : 1 to 1 args: (string $constant_name)
runkit_function_add           : 2 to 7 args: (string $function_name, $argument_list_or_closure, ?string $code_or_doc_comment, ?bool $return_by_reference, ?string $doc_comment, ?string $return_type, ?bool $is_strict) (Deprecated)
runkit7_function_add          : 2 to 7 args: (string $function_name, $argument_list_or_closure, ?string $code_or_doc_comment, ?bool $return_by_reference, ?string $doc_comment, ?string $return_type, ?bool $is_strict)
runkit_function_copy          : 2 to 2 args: (string $source_name, string $target_name) (Deprecated)
runkit7_function_copy         : 2 to 2 args: (string $source_name, string $target_name)
runkit_function_redefine      : 2 to 7 args: (string $function_name, $argument_list_or_closure, ?string $code_or_doc_comment, ?bool $return_by_reference, ?string $doc_comment, ?string $return_type, ?bool $is_strict) (Deprecated)
runkit7_function_redefine     : 2 to 7 args: (string $function_name, $argument_list_or_closure, ?string $code_or_doc_comment, ?bool $return_by_reference, ?string $doc_comment, ?string $return_type, ?bool $is_strict)
runkit_function_remove        : 1 to 1 args: (string $function_name) (Deprecated)
runkit7_function_remove       : 1 to 1 args: (string $function_name)
runkit_function_rename        : 2 to 2 args: (string $source_name, string $target_name) (Deprecated)
runkit7_function_rename       : 2 to 2 args: (string $source_name, string $target_name)
runkit_method_add             : 3 to 8 args: (string $class_name, string $method_name, $argument_list_or_closure, $code_or_flags, $flags_or_doc_comment, ?string $doc_comment, ?string $return_type, ?bool $is_strict) (Deprecated)
runkit7_method_add            : 3 to 8 args: (string $class_name, string $method_name, $argument_list_or_closure, $code_or_flags, $flags_or_doc_comment, ?string $doc_comment, ?string $return_type, ?bool $is_strict)
runkit_method_copy            : 3 to 4 args: (string $destination_class, string $destination_method, string $source_class, ?string $source_method) (Deprecated)
runkit7_method_copy           : 3 to 4 args: (string $destination_class, string $destination_method, string $source_class, ?string $source_method)
runkit_method_redefine        : 3 to 8 args: (string $class_name, string $method_name, $argument_list_or_closure, $code_or_flags, $flags_or_doc_comment, ?string $doc_comment, ?string $return_type, ?bool $is_strict) (Deprecated)
runkit7_method_redefine       : 3 to 8 args: (string $class_name, string $method_name, $argument_list_or_closure, $code_or_flags, $flags_or_doc_comment, ?string $doc_comment, ?string $return_type, ?bool $is_strict)
runkit_method_remove          : 2 to 2 args: (string $class_name, string $method_name) (Deprecated)
runkit7_method_remove         : 2 to 2 args: (string $class_name, string $method_name)
runkit_method_rename          : 3 to 3 args: (string $class_name, string $source_method_name, string $source_target_name) (Deprecated)
runkit7_method_rename         : 3 to 3 args: (string $class_name, string $source_method_name, string $source_target_name)
runkit_superglobals           : 0 to 0 args: () (Deprecated)
runkit7_superglobals          : 0 to 0 args: ()
runkit_zval_inspect           : 1 to 1 args: ($value) (Deprecated)
runkit7_zval_inspect          : 1 to 1 args: ($value)