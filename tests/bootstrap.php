<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Simple_Featured_Image_Column
 */

$_tests_dir = getenv('WP_TESTS_DIR');
if (!$_tests_dir) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}
if (!file_exists($_tests_dir.'/includes/functions.php')) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?";
	exit(1);
}

// Give access to tests_add_filter() function.
require_once $_tests_dir.'/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname(__DIR__).'/src/class-simple-featured-image-column.php';
}
/** @scrutinizer ignore-call */
tests_add_filter('muplugins_loaded', '_manually_load_plugin');

// Start up the WP testing environment.
require $_tests_dir.'/includes/bootstrap.php';
