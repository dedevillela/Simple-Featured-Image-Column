<?php
/**
 * Class Test_Simple_Column.
 *
 * @package Simple_Featured_Image_Column
 */

use Simple_Featured_Image_Column;

/**
 * Class that tests the simple featured image column
 */
class Test_Simple_Column extends WP_UnitTestCase {

/**
 * The ID of this plugin.
 *
 * @since    1.0.8
 * @access   private
 * @var      string    $plugin_name    The ID of this plugin.
 */
	private $plugin_name = 'simple-featured-image-column';
	
/**
 * The version of this plugin.
 *
 * @since    1.0.8
 * @access   private
 * @var      string    $version    The current version of this plugin.
 */
	private $version = '1.0.8';
	
	function setUp() {
		parent::setUp();
		$this->sfic = new Simple_Featured_Image_Column;
	}
	
	function create_post( $post = array() ) {
		$defaults = array(
			'post_title' => 'My Post',
			'post_content' => 'This is my post',
			'post_status' => 'publish',
			'post_author' => 1,
		);
		return wp_insert_post( array_merge( $defaults, $post ) );
	}
	
/**
 * Test the column_data method
 *
 * Test if the method column_data exists.
 *
 * @since 1.0.8
 */
  public function test_method_type() {
    $featured_image_column = new Simple_Featured_Image_Column( $this->plugin_name, $this->version );
    $this->assertTrue( method_exists( $featured_image_column , 'column_data' ) );
  }
}
