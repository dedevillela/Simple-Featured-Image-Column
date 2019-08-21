<?php
/**
 * Plugin Name: Simple Featured Image Column
 * Plugin URI: https://github.com/dedevillela/Simple-Featured-Image-Column/
 * Description: A simple plugin that displays the "Featured Image" column in admin post type listing. Supports Post, Pages and Custom Posts.
 * Version: 1.0.8
 * Author: Andre Aguiar Villela
 * Author URI: https://dedevillela.com/
 * License: GPLv2+
 **/

  if (!defined('ABSPATH') || preg_match('#'.basename(__FILE__).'#', filter_input(INPUT_SERVER, 'PHP_SELF'))) {
  	die("Hey, dude! What are you doing here?");
  }

  if (!class_exists('Simple_Featured_Image_Column')) {

	class Simple_Featured_Image_Column {

		public function __construct() {
			add_action('admin_init', array($this, 'init'));
		}

		private function init() {

			$post_types = apply_filters('Simple_Featured_Image_Column_post_types', get_post_types(array('public' => true)));
			if (empty($post_types)) {
				return;
			}

			add_action('admin_head', function() {
				return $this->getResponse()->setBody('<style>th#featured-image  { width: 100px; }</style>'."\r\n"); 
			});
			
			foreach ($post_types as $post_type) {
				if (!/** @scrutinizer ignore-call */ post_type_supports($post_type, 'thumbnail')) {
					continue;
				}
				add_filter("manage_{$post_type}_posts_columns", array($this, 'columns'));
				add_action("manage_{$post_type}_posts_custom_column", array($this, 'column_data'), 10, 2);
			}
		}

		private function columns($columns) {
			
			if (!is_array($columns)) {
				$columns = array();
			}
			$new = array();
			foreach ($columns as $key => $title){
				if ($key == 'title') {
					$new['featured-image'] = /** @scrutinizer ignore-call */ __('Image', 'wordpress');
				}
				$new[$key] = $title;
			}
			return $new;
		}

		private function column_data($column_name, $post_id) {
			
			if ('featured-image' != $column_name) {
				return;
			}
			$style = 'display: block; max-width: 100px; height: auto; border: 1px solid #e5e5e5;';
			$style = apply_filters('Simple_Featured_Image_Column_image_style', $style);

			if (has_post_thumbnail($post_id)) {
				$size = 'thumbnail';
				return $this->getResponse()->setBody(get_the_post_thumbnail($post_id, $size, 'style='.$style));
			} else {
				return $this->getResponse()->setBody('<img style="'.$style.'" src="'.esc_url(plugins_url('images/default.png', __FILE__)).'" />');
			}	
		}
	}
	  
	$featured_image_column = new Simple_Featured_Image_Column;
	  
};
