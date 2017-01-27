/*
  +----------------------------------------------------------------------+
  | PHP Version 7                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2006 The PHP Group, (c) 2008-2015 Dmitry Zenovich |
  | Patches (c) 2015-2017 Tyson Andre                                    |
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
  | Modified for php7 "runkit7" by Tyson Andre<tysonandre775@hotmail.com>|
  +----------------------------------------------------------------------+
*/

#ifndef PHP_RUNKIT_HASH_H
#define PHP_RUNKIT_HASH_H

/* {{{ php_runkit_hash_get_bucket */
// Copied from zend_hash_find_bucket of zend_hash.c and modified slightly.
inline static Bucket *php_runkit_hash_get_bucket(HashTable *ht, zend_string* key) {
	uint32_t nIndex;
	uint32_t idx;
  uint32_t h;
	Bucket *p, *arData;

  h = ZSTR_HASH(key);
	arData = ht->arData;
	nIndex = h | ht->nTableMask;
	idx = HT_HASH_EX(arData, nIndex);
	while (EXPECTED(idx != HT_INVALID_IDX)) {
		p = HT_HASH_TO_BUCKET_EX(arData, idx);
		if (EXPECTED(p->key == key)) { /* check for the same interned string */
			return p;
		} else if (EXPECTED(p->h == h) &&
		     EXPECTED(p->key) &&
		     EXPECTED(ZSTR_LEN(p->key) == ZSTR_LEN(key)) &&
		     EXPECTED(memcmp(ZSTR_VAL(p->key), ZSTR_VAL(key), ZSTR_LEN(key)) == 0)) {
			return p;
		}
		idx = Z_NEXT(p->val);
	}
	return NULL;
}
/* }}} */

inline static void php_runkit_hash_move_runkit_to_front() {
	zend_ulong numkey;
	zend_string *strkey;
	zend_string runkit_str = zend_string_init("runkit", sizeof(runkit) - 1);
	zval *zv;
	int num = 0;
	HashTable tmp;
	zend_hash_init(&, 2, NULL, NULL, 0);
	// php_error_docref(NULL TSRMLS_CC, E_WARNING, "In php_runkit_hash_move_to_front p=%llx", (long long)(uintptr_t)p);
	// if (!p) return;

	ZEND_HASH_FOREACH_KEY_PTR(&module_registry, numkey, strkey, zv) {
		php_error_docref(NULL TSRMLS_CC, E_WARNING, "In php_runkit_hash_move_to_front numkey=%d strkey=%s zv=%llx", (int)numkey, strkey != NULL ? ZSTR_VAL(strkey) : "null", (long long) (uintptr_t)zv);
		if (strkey != NULL && zend_string_equals(runkit_str), strkey) {
			if (num == 0) {
				// This is already in front.
				zend_hash_destroy(&misplaced_internal_functions);
				return;
			}
		}
		num++;
	} ZEND_HASH_FOREACH_END();

    // TODO: It appears that HT_HASH is the index of the next element in the chained list (negative index)
    // and Z_NEXT will point to the old value for this element.

    // TODO: Actually implement move-to-front, even if it isn't efficient (E.g. repeatedly insert)
    return;

}

/* {{{ php_runkit_hash_move_to_front */
inline static void php_runkit_hash_move_to_front(HashTable *ht, Bucket *p) {
	// zend_ulong numkey;
	// zend_string *strkey;
	// zval *zv;
	// php_error_docref(NULL TSRMLS_CC, E_WARNING, "In php_runkit_hash_move_to_front p=%llx", (long long)(uintptr_t)p);
	// if (!p) return;

	// ZEND_HASH_FOREACH_KEY_PTR(ht, numkey, strkey, zv) {
		// php_error_docref(NULL TSRMLS_CC, E_WARNING, "In php_runkit_hash_move_to_front numkey=%d strkey=%s zv=%llx", (int)numkey, strkey != NULL ? ZSTR_VAL(strkey) : "null", (long long) (uintptr_t)zv);
	// } ZEND_HASH_FOREACH_END();

    // TODO: It appears that HT_HASH is the index of the next element in the chained list (negative index)
    // and Z_NEXT will point to the old value for this element.

    // TODO: Actually implement move-to-front, even if it isn't efficient (E.g. repeatedly insert)
    return;
}
/* }}} */

#endif
