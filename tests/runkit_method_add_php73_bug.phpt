--TEST--
Bug in runkit_method_add (runkit7 issue #173)
--SKIPIF--
<?php if(!extension_loaded("runkit") || !RUNKIT_FEATURE_MANIPULATION) print "skip"; ?>
--INI--
display_errors=on
--FILE--
<?php declare(strict_types=1);
class Cache {

    private $_cacheWidget;

    public function __construct($options = null) {
        $this->_configureWidgets();
    }

    private function _configureWidgets() {
        $this->_cacheWidget = new CacheWidget();
    }

    public function execRequest(string $request) {
        return $this->_sendToService($request);
    }

    private function _sendToService(string $request) {
        return $this->_cacheWidget->exec($request);
    }
}

class CacheWidget {
    private static $_host;

    public function __construct() {
    }

    public function exec(string $request, $bindObj = null, $bazChoice = 0) {

        $postData = [];

        while (true) {
            // Prepare curl
            self::_prepare_post($postData);
            break;
        }
    }

    private static function _init_host() {
        if (empty(self::$_host)) {
            self::$_host = 'host';
        }
        return self::$_host;
    }

    private static function _prepare_post(array $data) {
        self::_init_host();
    }
}
class StaticMock {
    public static function add_count(string $method, array $args) {
        echo "Saw $method\n";
    }
}

call_user_func(function () {
    echo "in " . __METHOD__ . "\n";

    assert(class_exists('CacheWidget'));
    assert(runkit_method_copy('CacheWidget', '_init_host_old', 'CacheWidget', '_init_host'));
    assert(runkit_method_remove('CacheWidget', '_init_host'));
    assert(runkit_method_add(
        'CacheWidget',
        '_init_host',
        '',
        '    StaticMock::add_count(\'cacheconnection::_init_host\', func_get_args());

    CacheWidget::$_host = \'testhost\';
',
    1025,
        NULL,
        NULL,
        true
    ));

    $tdbConfig = [
        'pkey'           => 6,
        'use_solid_pdbs' => true,
    ];
    $cache = new Cache($tdbConfig);

    $request = "request key";
    $cache->execRequest($request);
});
?>
--EXPECT--
in {closure}
Saw cacheconnection::_init_host
