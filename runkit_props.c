/*
  +----------------------------------------------------------------------+
  | PHP Version 7                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2006 The PHP Group, (c) 2008-2015 Dmitry Zenovich |
  | "runkit7" patches (c) 2015-2017 Tyson Andre                          |
  +----------------------------------------------------------------------+
  | This source file is subject to the new BSD license,                  |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.opensource.org/licenses/BSD-3-Clause                      |
  | If you did not receive a copy of the license and are unable to       |
  | obtain it through the world-wide-web, please send a note to          |
  | dzenovich@gmail.com so we can mail you a copy immediately.           |
  +----------------------------------------------------------------------+
  | Author: Sara Golemon <pollita@php.net>                               |
  | Modified by Dmitry Zenovich <dzenovich@gmail.com>                    |
  | Modifications for php7 (in progress) by Tyson Andre                  |
  +----------------------------------------------------------------------+
Note: This file is no longer compiled because of changes to the VM for adding new properties. See the README.
runkit_property_modify() may be added in the future
*/

/* $Id$ */

#include "php_runkit.h"
#include "php_runkit_zval.h"

#ifdef PHP_RUNKIT_MANIPULATION

/* {{{ php_runkit_make_object_property_public */
static inline void php_runkit_make_object_property_public(zend_string *propname, zend_object *object, int offset, zend_property_info *property_info_ptr TSRMLS_DC) {
	if ((property_info_ptr->flags & (ZEND_ACC_PRIVATE | ZEND_ACC_PROTECTED | ZEND_ACC_SHADOW))) {
		zval *prop_val = NULL;
		if (!object->properties) {
			prop_val = &object->properties_table[offset];
			rebuild_object_properties(object);
		} else if (!Z_ISUNDEF(object->properties_table[offset])) {
			// TODO: Is Z_ISUNDEF the correct thing to do?
			prop_val = &object->properties_table[offset];
		}
		if (prop_val) {
			// TODO: should these references be shared?
			Z_TRY_ADDREF_P(prop_val);
			// Could probably also be ZSTR_H
			if (ZSTR_HASH(propname) != ZSTR_HASH(property_info_ptr->name)) {
				zend_hash_del(object->properties, property_info_ptr->name);
			}
			// TODO: This is probably going to cause a segfault.
			zend_hash_update(object->properties, propname, prop_val);
			php_error_docref(NULL TSRMLS_CC, E_NOTICE, "Making %s::%s public to remove it "
					 "from class without objects overriding", ZSTR_VAL(object->ce->name), ZSTR_VAL(propname));
		}
	}
}
/* }}} */

/* {{{ php_runkit_remove_children_def_props
	Scan the class_table for children of the class just removed */
static void php_runkit_remove_children_def_props(zend_class_entry *ce, zend_class_entry *parent_class, zend_string *pname,
	zend_class_entry *class_we_originally_removing_from, zend_bool was_static, zend_bool remove_from_objects, zend_property_info *parent_property)
{
	if (ce->parent != parent_class) {
		/* Not a child, ignore */
		return;
	}

	php_runkit_def_prop_remove_int(ce, pname, class_we_originally_removing_from, was_static, remove_from_objects,
	                               parent_property TSRMLS_CC);
}
/* }}} */

/* {{{ php_runkit_remove_property_by_full_name */
static int php_runkit_remove_property_by_full_name(zval *pDest, void *argument) {
	const zend_property_info *prop = Z_PTR_P(pDest);
	const zend_property_info *comp_prop = (zend_property_info*) argument;

	ZEND_ASSERT(Z_TYPE_P(pDest) == IS_PTR);

	if (ZSTR_H(prop->name) == ZSTR_H(comp_prop->name) && zend_string_equals(comp_prop->name, prop->name)) {
		return ZEND_HASH_APPLY_REMOVE;
	}

	return ZEND_HASH_APPLY_KEEP;
}
/* }}} */

/* {{{ php_runkit_remove_overlapped_property_from_child
       Clean private properties of children by offset */
static void php_runkit_remove_overlapped_property_from_childs(zend_class_entry *ce, zend_class_entry *parent_class, zend_string *propname, int offset, zend_bool is_static, zend_bool remove_from_objects, zend_property_info *property_info_ptr);
static void php_runkit_remove_overlapped_property_from_childs_foreach(HashTable* ht, zend_class_entry *parent_class, zend_string *propname, int offset, zend_bool is_static, zend_bool remove_from_objects, zend_property_info *property_info_ptr) {
	zend_class_entry *ce;
	ZEND_HASH_FOREACH_PTR(ht, ce) {
		php_runkit_remove_overlapped_property_from_childs(ce, parent_class, propname, offset, is_static, remove_from_objects, property_info_ptr);
	} ZEND_HASH_FOREACH_END();
}
/* }}} */

/* {{{ php_runkit_remove_overlapped_property_from_child
       Clean private properties of child by offset */
static void php_runkit_remove_overlapped_property_from_childs(zend_class_entry *ce, zend_class_entry *parent_class, zend_string *propname, int offset, zend_bool is_static, zend_bool remove_from_objects, zend_property_info *property_info_ptr) {
	uint32_t i;
	zend_property_info *p;
	zval *table;

	if (ce->parent != parent_class) {
		/* Not a child, ignore */
		return;
	}

	php_runkit_remove_overlapped_property_from_childs_foreach(RUNKIT_53_TSRMLS_PARAM(EG(class_table)), ce, propname, offset, is_static, remove_from_objects, property_info_ptr);
	php_runkit_remove_property_from_reflection_objects(ce, propname TSRMLS_CC);

	if (is_static) {
		goto st_success;
	}

	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_BEGIN(i)
		if (object->ce == ce) {
			if (!remove_from_objects) {
				php_runkit_make_object_property_public(propname, object, offset, property_info_ptr TSRMLS_CC);
			} else {
				if (!Z_ISUNDEF(object->properties_table[offset])) {
					if (!object->properties) {
						zval_ptr_dtor(&object->properties_table[offset]);
						ZVAL_UNDEF(&object->properties_table[offset]);
					} else {
						zend_hash_del(object->properties, propname);
					}
				}
			}
		}
	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_END

st_success:
	table = is_static ? ce->default_static_members_table : ce->default_properties_table;
	if (!Z_ISUNDEF(table[offset])) {
		zval_ptr_dtor(&table[offset]);
		ZVAL_UNDEF(&table[offset]);
		php_runkit_default_class_members_list_add(&RUNKIT_G(removed_default_class_members), ce, is_static, offset);
	}
	zend_hash_apply_with_argument(&ce->properties_info,
								  php_runkit_remove_property_by_full_name,
	                              property_info_ptr TSRMLS_CC);
	if ((p = zend_hash_find_ptr(&ce->properties_info, propname)) != NULL &&
	    ZSTR_H(p->name) == ZSTR_H(property_info_ptr->name)) {
		zend_hash_del(&ce->properties_info, propname);
	}
}
/* }}} */

/* {{{ php_runkit_dump_string */
/*
static inline void php_runkit_dump_string(const char *str, int len) {
	int j;
	for (j=0; j<len; j++) {
		printf("%c", str[j]);
	}
}
*/
/* }}} */

/* {{{ php_runkit_dump_hashtable_keys */
/*
static inline void php_runkit_dump_hashtable_keys(HashTable* ht) {
	HashPosition pos;
	void *ptr;
	for(zend_hash_internal_pointer_end_ex(ht, &pos);
	    zend_hash_get_current_data_ex(ht, (void*)&ptr, &pos) == SUCCESS;
	    zend_hash_move_backwards_ex(ht, &pos)) {
		printf("key = ");
		php_runkit_dump_string(pos->arKey, pos->nKeyLength);
	}
}
*/
/* }}} */

/* {{{ php_runkit_def_prop_remove_int */
int php_runkit_def_prop_remove_int(zend_class_entry *ce, zend_string *propname, zend_class_entry *class_we_originally_removing_from,
                                   zend_bool was_static, zend_bool remove_from_objects,
                                   zend_property_info *parent_property TSRMLS_DC)
{
	uint32_t i;
	int offset;
	int flags;
	zend_property_info *property_info_ptr;

	if ((property_info_ptr = zend_hash_find_ptr(&ce->properties_info, propname)) != NULL) {
		if (class_we_originally_removing_from == NULL) {
			class_we_originally_removing_from = property_info_ptr->ce;
		}
		if (parent_property &&
		    (parent_property->offset != property_info_ptr->offset ||
		     parent_property->ce != property_info_ptr->ce ||
		     ((parent_property->flags & ZEND_ACC_STATIC) != (property_info_ptr->flags & ZEND_ACC_STATIC))
		    )) {
			return SUCCESS;
		}

		if (class_we_originally_removing_from != property_info_ptr->ce) {
			return SUCCESS;
		}

		if (property_info_ptr->flags & ZEND_ACC_STATIC) {
			was_static = 1;
			// TODO: is this reasonable?
			if (!Z_ISUNDEF(ce->default_static_members_table[property_info_ptr->offset])) {
				// TODO: Free this property?
				zval_ptr_dtor(&ce->default_static_members_table[property_info_ptr->offset]);
				// TODO: is this reasonable?
				ZVAL_UNDEF(&ce->default_static_members_table[property_info_ptr->offset]);
				php_runkit_default_class_members_list_add(&RUNKIT_G(removed_default_class_members), ce, 1, property_info_ptr->offset);
			}
		} else {
			was_static = 0;
		}

		flags = property_info_ptr->flags;
		offset = property_info_ptr->offset;

		if (property_info_ptr->flags & (ZEND_ACC_PRIVATE|ZEND_ACC_SHADOW)) {
			if (offset >= 0) {
				php_runkit_remove_overlapped_property_from_childs_foreach(RUNKIT_53_TSRMLS_PARAM(EG(class_table)),
				                               ce, propname, offset,
				                               property_info_ptr->flags & ZEND_ACC_STATIC, remove_from_objects, property_info_ptr);
			}
		}
		{
			zend_class_entry *ce_iter;
			ZEND_HASH_FOREACH_PTR(EG(class_table), ce_iter) {

				php_runkit_remove_children_def_props(ce_iter, ce, propname, class_we_originally_removing_from,
		                               was_static, remove_from_objects, property_info_ptr);
			} ZEND_HASH_FOREACH_END();
		}

		php_runkit_remove_property_from_reflection_objects(ce, propname TSRMLS_CC);
		php_runkit_clear_all_functions_runtime_cache(TSRMLS_C);
	} else {
		if (parent_property) {
			return SUCCESS;
		} else {
			php_error_docref(NULL TSRMLS_CC, E_WARNING, "%s::%s does not exist", ZSTR_VAL(ce->name), ZSTR_VAL(propname));
			return FAILURE;
		}
	}

	if (flags & ZEND_ACC_STATIC) {
		goto st_success;
	}

	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_BEGIN(i)
		if (object->ce == ce) {
			if (!remove_from_objects) {
				php_runkit_make_object_property_public(propname, object, offset, property_info_ptr TSRMLS_CC);
			} else {
				if (!Z_ISUNDEF(object->properties_table[offset])) {
					if (!object->properties) {
						zval_ptr_dtor(&object->properties_table[offset]);
						ZVAL_UNDEF(&object->properties_table[offset]);
					} else {
						zend_hash_del(object->properties, property_info_ptr->name);
					}
				}
			}
		}
	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_END

st_success:
	// TODO: Should this be undefined?
	if (was_static == 0 && !Z_ISUNDEF(ce->default_properties_table[property_info_ptr->offset])) {
		zval_ptr_dtor(&ce->default_properties_table[property_info_ptr->offset]);
		// TODO: Does this make sense?
		// What is the layout of a table?
		ZVAL_UNDEF(&ce->default_properties_table[property_info_ptr->offset]);
		php_runkit_default_class_members_list_add(&RUNKIT_G(removed_default_class_members), ce, 0, property_info_ptr->offset);
	}
	return SUCCESS;
}
/* }}} */

/* {{{ php_runkit_def_prop_remove */
static int php_runkit_def_prop_remove(zend_string *classname, zend_string *propname,
                                      zend_bool remove_from_objects TSRMLS_DC)
{
	zend_class_entry *ce;

	if ((ce = php_runkit_fetch_class_int(classname)) == NULL) {
		return FAILURE;
	}

	if (ce->type & ZEND_INTERNAL_CLASS) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "Removing properties from internal classes is not allowed");
		return FAILURE;
	}

	php_runkit_clear_all_functions_runtime_cache(TSRMLS_C);
	return php_runkit_def_prop_remove_int(ce, propname, NULL, 0, remove_from_objects, NULL TSRMLS_CC);
}
/* }}} */

/* {{{ php_runkit_remove_property_from_reflection_objects */
void php_runkit_remove_property_from_reflection_objects(zend_class_entry *ce, zend_string *propname TSRMLS_DC) {
	uint32_t i;
	extern PHPAPI zend_class_entry *reflection_property_ptr;

	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_BEGIN(i)
		if (object->ce == reflection_property_ptr) {
			reflection_object *refl_obj = (reflection_object *) object;
			if (refl_obj->ptr && refl_obj->ce == ce) {
				property_reference *prop_ref = (property_reference *) refl_obj->ptr;
				if (prop_ref->ce == ce && zend_string_equals(prop_ref->prop.name, propname)) {
					if (refl_obj->ref_type == REF_TYPE_DYNAMIC_PROPERTY) {
						// TODO: set this to null?
						zend_string_release(prop_ref->prop.name);
					}
					efree(refl_obj->ptr);
					refl_obj->ptr = NULL;
				}
				php_runkit_update_reflection_object_name(object, i, RUNKIT_G(removed_property_str));
			}
		}
	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_END
}
/* }}} */

/* ******************
   * Properties API *
   ****************** */

/* {{{ proto bool runkit_default_property_remove(string classname, string propname)
Remove a property from a class
 */
PHP_FUNCTION(runkit_default_property_remove)
{
	zend_string *classname;
	zend_string *propname;
	zend_bool remove_from_objects = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "SS|b", &classname, &propname, &remove_from_objects) == FAILURE) {
		RETURN_FALSE;
	}

	RETURN_BOOL(php_runkit_def_prop_remove(classname, propname, remove_from_objects TSRMLS_CC) == SUCCESS);
}
/* }}} */
#endif /* PHP_RUNKIT_MANIPULATION */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
