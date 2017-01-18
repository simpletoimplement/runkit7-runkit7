/*
  +----------------------------------------------------------------------+
  | PHP Version 7                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 2017 Tyson Andre                                       |
  +----------------------------------------------------------------------+
  | This source file is subject to the new BSD license,                  |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.opensource.org/licenses/BSD-3-Clause                      |
  | If you did not receive a copy of the license and are unable to       |
  | obtain it through the world-wide-web, please send a note to          |
  | dzenovich@gmail.com so we can mail you a copy immediately.           |
  +----------------------------------------------------------------------+
  | Author: Tyson Andre <tysonandre775@hotmail.com>                      |
  +----------------------------------------------------------------------+
*/

#include "php_runkit.h"

/* {{{ proto array runkit_object_listall()
Fetch an array of all PHP objects (for debugging) */
PHP_FUNCTION(runkit_object_listall)
{
	uint32_t i = 0;
	array_init(return_value);
	PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_BEGIN(i) {
		zval obj_zval;
		ZVAL_OBJ(&obj_zval, object);
		// This object already exists, so we need to add to the reference count instead of relying on default behavior.
		++GC_REFCOUNT(object);
		zend_hash_next_index_insert(Z_ARRVAL_P(return_value), &obj_zval);
	} PHP_RUNKIT_ITERATE_THROUGH_OBJECTS_STORE_END
	// return_value was already initialized.
}
/* }}} */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
