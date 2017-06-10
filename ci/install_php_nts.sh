#!/bin/bash -xeu

echo "Attempting to install NTS PHP, NTS version '$PHP_NTS_VERSION'/ configure args '$PHP_CONFIGURE_ARGS'"
if [ "x$PHP_NTS_VERSION" = "x" -o "x$PHP_CONFIGURE_ARGS" = "x" ] ; then
	echo "Missing nts version or configuration arguments";
	exit 1;
fi
PHP_INSTALL_DIR="$(./ci/generate_php_install_dir.sh)"
echo "Downloading $PHP_INSTALL_DIR\n"
if [ -x $PHP_INSTALL_DIR/bin/php ] ; then
	echo "PHP $PHP_NTS_VERSION already installed and in cache at $PHP_INSTALL_DIR";
	exit 0
fi
PHP_NTS_NORMAL_VERSION=${PHP_NTS_VERSION//RC[0-9]/}
PHP_NTS_NORMAL_VERSION=${PHP_NTS_NORMAL_VERSION//alpha[0-9]/}
PHP_NTS_NORMAL_VERSION=${PHP_NTS_NORMAL_VERSION//beta[0-9]/}
PHP_FOLDER="php-$PHP_NTS_VERSION"

# Remove cache if it somehow exists
if [ "x${TRAVIS:-0}" != "x" ]; then
	rm -rf $HOME/travis_cache/
fi
# Otherwise, put a minimal installation inside of the cache.
PHP_TAR_FILE="$PHP_FOLDER.tar.bz2"
if [ "$PHP_NTS_NORMAL_VERSION" != "7.2.0" ] ; then
       curl --verbose https://secure.php.net/distributions/$PHP_TAR_FILE -o $PHP_TAR_FILE
else
       curl --verbose https://downloads.php.net/~pollita/php-7.2.0alpha1.tar.bz2 -o $PHP_TAR_FILE
       PHP_FOLDER="php-7.2.0alpha1"
fi

tar xjf $PHP_TAR_FILE

pushd $PHP_FOLDER
./configure $PHP_CONFIGURE_ARGS --prefix="$PHP_INSTALL_DIR"
make -j5
make install
popd

echo "PHP $PHP_NTS_VERSION already installed and in cache at $HOME/travis_cache/$PHP_FOLDER";
