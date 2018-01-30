<?php
/**
 * Plugin Name: Cookbook
 * Description: Makes a cookbook.
 * Author: XDLeader555
 * Author URI: https://www.andrewmiyaguchi.com
 * Text Domain: cookbook
 *
 * Version: 1.0.0
 *
 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 */

// Create necessary post types.
if( ! defined( 'ABSPATH' ) ){
  exit;
}

// Init settings page.
include_once( 'settings.php' );

add_action( 'init', function(){
  // Add JS just in case. Normally you'd only enqueue on the page you need, but eh. TODO.
  wp_enqueue_script( 'cookbook', plugin_dir_path( __FILE__ ) . '/assets/main.js', array( 'jquery' ) );

  // Register the cookbook post type.
  $labels = array(
		'name'               => _x( 'Recipes', 'post type general name', 'cookbook' ),
		'singular_name'      => _x( 'Recipe', 'post type singular name', 'cookbook' ),
		'menu_name'          => _x( 'Recipes', 'admin menu', 'cookbook' ),
		'name_admin_bar'     => _x( 'Recipe', 'add new on admin bar', 'cookbook' ),
		'add_new'            => _x( 'Add New', 'recipe', 'cookbook' ),
		'add_new_item'       => __( 'Add New Recipe', 'cookbook' ),
		'new_item'           => __( 'New Recipe', 'cookbook' ),
		'edit_item'          => __( 'Edit Recipe', 'cookbook' ),
		'view_item'          => __( 'View Recipe', 'cookbook' ),
		'all_items'          => __( 'All Recipes', 'cookbook' ),
		'search_items'       => __( 'Search Recipes', 'cookbook' ),
		'parent_item_colon'  => __( 'Parent Recipes:', 'cookbook' ),
		'not_found'          => __( 'No recipes found.', 'cookbook' ),
		'not_found_in_trash' => __( 'No recipes found in Trash.', 'cookbook' )
	);

	$args = array(
		'labels'             => $labels,
    'description'        => __( 'Description.', 'cookbook' ),
		'public'             => true,
    'menu_icon'          => 'dashicons-carrot',
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'recipe' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	);

	register_post_type( 'recipe', $args );
});


// Add the metabox necessary for custom data. We can get input/outputting this in a form later, I'll show you how
add_action( 'add_meta_boxes_recipe', function(){

  // You can call this function multiple times with different references (arg #0) and different callbacks (arg #1)
  // in order to add muleiple metaboxes.
  add_meta_box(
    'my-meta-box',
    __( 'Recipe Meta Shit' ),
    'render_recipe_meta_box',
    'recipe',
    'normal',
    'high'
  );
});

function render_recipe_meta_box(){
  global $post;
  $value = get_post_meta($post->ID, '_wporg_meta_key', true);
  ?>
  <label>Iunno, ingredients or something.</label>
  <select name="wporg_field" class="postbox">
      <option value="">Select something...</option>
      <option value="something" <?php selected($value, 'something'); ?>>Something</option>
      <option value="else" <?php selected($value, 'else'); ?>>Else</option>
  </select>
  <?php
}

function wporg_save_postdata($post_id)
{
    if (array_key_exists('wporg_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key',
            $_POST['wporg_field']
        );
    }
}
add_action('save_post', 'wporg_save_postdata');
