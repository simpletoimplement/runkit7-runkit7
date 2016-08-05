#!/bin/bash -xeu
# Print a folder name based on the integer width(32 bit or 64 bit), whether or not NTS is used (implied by PHP_CONFIGURE_ARGS), and PHP_CONFIGURE_ARGS.
PHP_INSTALL_DIR="$HOME/travis_cache/php-$PHP_NTS_VERSION"
if [ "${USE_32BIT:-0}" = "1" ]; then
	PHP_INSTALL_DIR="$PHP_INSTALL_DIR-32bit"
else
	PHP_INSTALL_DIR="$PHP_INSTALL_DIR-64bit"
fi
if [ "$PHP_NTS_USE" = "1" ]; then
	PHP_INSTALL_DIR="$PHP_INSTALL_DIR-nts"
else
	PHP_INSTALL_DIR="$PHP_INSTALL_DIR-zts"
fi
HASH=$(echo -n "$PHP_CONFIGURE_ARGS" | sha1sum | cut -c -4)
PHP_INSTALL_DIR="$PHP_INSTALL_DIR-$HASH"
echo -n "$PHP_INSTALL_DIR"
