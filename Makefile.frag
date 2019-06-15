install: $(all_targets) $(install_targets) show-install-instructions

show-install-instructions:
	@echo
	@$(top_srcdir)/build/shtool echo -n -e %B
	@echo   "  +----------------------------------------------------------------------+"
	@echo   "  |                                                                      |"
	@echo   "  |   UPGRADING NOTICE                                                   |"
	@echo   "  |   ================                                                   |"
	@echo   "  |                                                                      |"
	@echo   "  |   In runkit7 v3, the name of the installed shared library has been   |"
	@echo   "  |   changed from \"runkit\" to \"runkit7\".                                |"
	@echo   "  |   (i.e. runkit.so changed to runkit7.so, and php_runkit.dll changed  |"
	@echo   "  |   to php_runkit7.dll)                                                |"
	@echo   "  |                                                                      |"
	@echo   "  |   - php.ini files WILL NEED TO BE CHANGED TO LOAD RUNKIT7 INSTEAD.   |"
	@echo   "  |                                                                      |"
	@echo   "  |   Additionally, the configuration flags used have changed from       |"
	@echo   "  |   --enable-runkit-feature to --enable-runkit7-feature.               |"
	@echo   "  |                                                                      |"
	@echo   "  |   This change was made to comply with PECL's naming/packaging        |"
	@echo   "  |   guidelines.                                                        |"
	@echo   "  |                                                                      |"
	@echo   "  +----------------------------------------------------------------------+"
	@$(top_srcdir)/build/shtool echo -n -e %b
	@echo
	@echo

findphp:
	@echo $(PHP_EXECUTABLE)
