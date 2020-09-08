/* This is a generated file, edit the .stub.php file instead.
 * Stub hash: 4ed3bde43667f15f3395fc2c4f6cce57626fb6d2 */

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_constant_add, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, constant_name, IS_STRING, 0)
	ZEND_ARG_INFO(0, value)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, new_visibility, IS_LONG, 0, "RUNKIT7_ACC_PUBLIC")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_constant_redefine, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, constant_name, IS_STRING, 0)
	ZEND_ARG_INFO(0, value)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, new_visibility, IS_LONG, 1, "null")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_constant_remove, 0, 1, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, constant_name, IS_STRING, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_function_add, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, function_name, IS_STRING, 0)
	ZEND_ARG_INFO(0, argument_list_or_closure)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, code_or_doc_comment, IS_STRING, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, return_by_reference, _IS_BOOL, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, doc_comment, IS_STRING, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, return_type, IS_STRING, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, is_strict, _IS_BOOL, 1, "null")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_function_copy, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, source_name, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, target_name, IS_STRING, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit7_function_redefine arginfo_runkit7_function_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_function_remove, 0, 1, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, function_name, IS_STRING, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit7_function_rename arginfo_runkit7_function_copy
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_method_add, 0, 3, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, class_name, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, method_name, IS_STRING, 0)
	ZEND_ARG_INFO(0, argument_list_or_closure)
	ZEND_ARG_INFO_WITH_DEFAULT_VALUE(0, code_or_flags, "null")
	ZEND_ARG_INFO_WITH_DEFAULT_VALUE(0, flags_or_doc_comment, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, doc_comment, IS_STRING, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, return_type, IS_STRING, 1, "null")
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, is_strict, _IS_BOOL, 1, "null")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_method_copy, 0, 3, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, destination_class, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, destination_method, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, source_class, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, source_method, IS_STRING, 1, "null")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit7_method_redefine arginfo_runkit7_method_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_method_remove, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, class_name, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, method_name, IS_STRING, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_method_rename, 0, 3, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, class_name, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, source_method_name, IS_STRING, 0)
	ZEND_ARG_TYPE_INFO(0, source_target_name, IS_STRING, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_zval_inspect, 0, 1, IS_ARRAY, 0)
	ZEND_ARG_INFO(0, value)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit_constant_add, 0, 2, _IS_BOOL, 0)
	ZEND_ARG_TYPE_INFO(0, constant_name, IS_STRING, 0)
	ZEND_ARG_INFO(0, value)
	ZEND_ARG_TYPE_INFO_WITH_DEFAULT_VALUE(0, new_visibility, IS_LONG, 1, "RUNKIT7_ACC_PUBLIC")
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_constant_redefine arginfo_runkit7_constant_redefine
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_constant_remove arginfo_runkit7_constant_remove
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_function_add arginfo_runkit7_function_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_function_copy arginfo_runkit7_function_copy
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_function_redefine arginfo_runkit7_function_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_function_remove arginfo_runkit7_function_remove
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_function_rename arginfo_runkit7_function_copy
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_method_add arginfo_runkit7_method_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_method_copy arginfo_runkit7_method_copy
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_method_redefine arginfo_runkit7_method_add
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_method_remove arginfo_runkit7_method_remove
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_method_rename arginfo_runkit7_method_rename
#endif

#if defined(PHP_RUNKIT_MANIPULATION)
#define arginfo_runkit_zval_inspect arginfo_runkit7_zval_inspect
#endif

#if defined(PHP_RUNKIT_SUPERGLOBALS)
ZEND_BEGIN_ARG_WITH_RETURN_TYPE_INFO_EX(arginfo_runkit7_superglobals, 0, 0, IS_ARRAY, 0)
ZEND_END_ARG_INFO()
#endif

#if defined(PHP_RUNKIT_SUPERGLOBALS)
#define arginfo_runkit_superglobals arginfo_runkit7_superglobals
#endif
