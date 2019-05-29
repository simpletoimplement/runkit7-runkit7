dnl config.m4 for extension runkit7

PHP_ARG_ENABLE(runkit7, whether to enable runkit7 support,
[  --enable-runkit7          Enable runkit7 support], no, yes)

PHP_ARG_ENABLE(runkit7-modify, whether to enable runtime manipulation of functions/classes/constants,
[  --enable-runkit7-modify    Enable runtime manipulation], inherit, no)

PHP_ARG_ENABLE(runkit7-super, whether to enable registration of user-defined autoglobals,
[  --enable-runkit7-super     Enable registration of user-defined autoglobals], inherit, yes)

PHP_ARG_ENABLE(runkit7_spl_object_id, whether to enable spl_object_id in PHP <= 7.1,
[  --enable-runkit7-spl_object_id    Enable spl_object_id support], no, no)

dnl PHP_ARG_ENABLE(runkit7-sandbox, whether to enable Sandbox support,
dnl [  --enable-runkit7-sandbox   Enable Runkit_Sandbox (Requires ZTS)], inherit, no)

if test "$PHP_RUNKIT7" != "no"; then
  AC_MSG_CHECKING([if this is built with PHP >= 7.1])
  AC_COMPILE_IFELSE([AC_LANG_PROGRAM([[
  #include <$phpincludedir/main/php_version.h>
  ]], [[
#if PHP_VERSION_ID < 70100
#error PHP < 7.1
#endif
  ]])],[
    AC_MSG_RESULT([this is PHP 7.1 or newer])
  ],[
    AC_MSG_ERROR([Runkit7 requires PHP 7.1 or newer, phpize was run with PHP < 7.1]);
  ])
  if test "$PHP_RUNKIT7_SUPER" = "inherit"; then
    PHP_RUNKIT7_SUPER=yes
  fi
dnl  if test "$PHP_RUNKIT7_SANDBOX" = "inherit"; then
dnl    PHP_RUNKIT7_SANDBOX=yes
dnl  fi
else
  if test "$PHP_RUNKIT7_MODIFY" = "inherit"; then
    PHP_RUNKIT7_MODIFY=no
  fi
  if test "$PHP_RUNKIT7_SUPER" = "inherit"; then
    PHP_RUNKIT7_SUPER=no
  fi
dnl  if test "$PHP_RUNKIT7_SANDBOX" = "inherit"; then
dnl    PHP_RUNKIT7_SANDBOX=no
dnl  fi
fi

if test "$PHP_RUNKIT7" != "no"; then
  if test "$PHP_RUNKIT7_MODIFY" != "no"; then
    AC_DEFINE(PHP_RUNKIT7_FEATURE_MODIFY, 1, [Whether to export runtime modification features])
  fi
  if test "$PHP_RUNKIT7_SUPER" != "no"; then
    AC_DEFINE(PHP_RUNKIT7_FEATURE_SUPER, 1, [Whether to export custom autoglobal registration feature])
  fi
dnl  if test "$PHP_RUNKIT7_SANDBOX" != "no"; then
dnl    AC_DEFINE(PHP_RUNKIT7_FEATURE_SANDBOX, 1, [Whether to export Sandbox feature])
dnl  fi
  if test "$PHP_RUNKIT7_SPL_OBJECT_ID" != "no"; then
    AC_DEFINE(PHP_RUNKIT7_SPL_OBJECT_ID, 1, [Whether to define spl_object_id in php <= 7.1])
  fi
dnl runkit_sandbox.c runkit_sandbox_parent.c
  PHP_NEW_EXTENSION(runkit7, runkit.c runkit_functions.c runkit_methods.c \
runkit_import.c \
runkit_constants.c \
runkit_object_id.c \
runkit_common.c \
runkit_zend_execute_API.c \
runkit_classes.c \
runkit_props.c \
, $ext_shared,, -Wdeclaration-after-statement -Werror -Wall -Wno-deprecated-declarations -Wno-pedantic)
fi
