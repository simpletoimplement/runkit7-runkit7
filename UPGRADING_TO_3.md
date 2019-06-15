Upgrading from runkit7 2.x to 3.0
=================================

Runkit7 3.0 finishes changing this extension's name from "runkit" to "runkit7".
THIS WILL REQUIRE CHANGES TO YOUR BUILD SCRIPTS AND PHP.INI FILES.
This change was made at the request of PECL admins, to comply with naming and packaging standards.

- The compiled shared object name has been changed from `runkit.so` to `runkit7.so` (Mac/Linux) and `php_runkit.dll` to `php_runkit7.dll` (Windows)
  (php.ini files should be changed to reference `extension=runkit7.so` or `extension=php_runkit7.dll`)
- The configure flag names have been changed from flags such as `--enable-runkit` / `--enable-runkit-modify` to `--enable-runkit7` / `--enable-runkit7-modify`
- Code using `extension_loaded('runkit')` should be changed to `extension_loaded('runkit7')` (as well as uses of ReflectionExtension, etc.)
- The ini options `runkit.superglobal` and `runkit.internal_override` are unaffected.

Other changes:
- Classkit compatibility functions/constants have been removed.
- The RUNKIT_VERSION constant was removed. (use ReflectionExtension->getVersion())
