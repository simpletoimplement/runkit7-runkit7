#!/bin/bash -xeu

echo "Attempting to install NTS PHP, NTS version '$PHP_NTS_VERSION'/ configure args '$PHP_CONFIGURE_ARGS'"
if [ "x$PHP_NTS_VERSION" = "x" -o "x$PHP_CONFIGURE_ARGS" = "x" ] ; then 
	echo "Missing nts version or configuration arguments";
	exit 1;
fi
PHP_FOLDER="php-$PHP_NTS_VERSION"
PHP_INSTALL_DIR="$(./ci/generate_php_install_dir.sh)"
echo "Downloading $PHP_INSTALL_DIR\n"
if [ -x $PHP_INSTALL_DIR/bin/php ] ; then 
	echo "PHP $PHP_NTS_VERSION already installed and in cache at $PHP_INSTALL_DIR";
	exit 0
fi
# Remove cache if it somehow exists
if [ "x${TRAVIS:-0}" != "x" ]; then
	rm -rf $HOME/travis_cache/
fi
# Otherwise, put a minimal installation inside of the cache.
PHP_TAR_FILE="$PHP_FOLDER.tar.bz2"
if [ "$PHP_NTS_VERSION" != "7.1.0" ] ; then
	curl --verbose https://secure.php.net/distributions/$PHP_TAR_FILE -o $PHP_TAR_FILE
else
	curl --verbose https://downloads.php.net/~davey/php-7.1.0RC1.tar.bz2 -o $PHP_TAR_FILE
fi
tar xjf $PHP_TAR_FILE
if [ "$PHP_NTS_VERSION" = "7.1.0" ] ; then
	mv "${PHP_FOLDER}beta1" "$PHP_FOLDER"
fi

pushd $PHP_FOLDER
./configure $PHP_CONFIGURE_ARGS --prefix="$PHP_INSTALL_DIR"
make -j5
make install
popd

echo "PHP $PHP_NTS_VERSION already installed and in cache at $HOME/travis_cache/$PHP_FOLDER";
