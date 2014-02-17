<?php
/* Meetings Post Type
*/

if(!class_exists('kcrf_meetings'))
{

	class kcrf_meetings
	{
		const POST_TYPE	= "meetings";

    	public function __construct()
    	{
    		add_action('init', array(&$this, 'init'));
    		add_action('admin_init', array(&$this, 'init'));
    		add_action('admin_menu', array(&$this, 'admin_menu'));
    	} // END public function __construct()

    	public function init()
    	{
    		$this->register_meetings_type();
    		add_action('save_post', array(&$this, 'save_post'));
    	} // END public function init()


    	public function register_meetings_type() 
    	{ 
			register_post_type(
				self::POST_TYPE,
				array( 'labels' => array(
					'name' => __( 'Meetings', 'bonestheme' ), /* This is the Title of the Group */
					'singular_name' => __( 'Meeting', 'bonestheme' ), /* This is the individual type */
					'all_items' => __( 'All Meetings', 'bonestheme' ), /* the all items menu item */
					'add_new' => __( 'Add New', 'bonestheme' ), /* The add new menu item */
					'add_new_item' => __( 'Add New Meeting', 'bonestheme' ), /* Add New Display Title */
					'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
					'edit_item' => __( 'Edit Post Types', 'bonestheme' ), /* Edit Display Title */
					'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
					'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
					'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Meetings Type Title */ 
					'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */ 
					'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
					'parent_item_colon' => ''
					), /* end of arrays */
					'description' => __( 'This the place to post meeting information and archives.', 'bonestheme' ), /* Meetings Type Description */
					'public' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'show_ui' => true,
					'query_var' => true,
					'menu_position' => 8,
					'menu-icon' => 'dashicons-calendar',
					'rewrite'	=> array( 'slug' => 'meetings', 'with_front' => false ),
					'has_archive' => 'meetings', /* you can rename the slug here */
					'capability_type' => 'post',
					'hierarchical' => false,
					/* the next one is important, it tells what's enabled in the post editor */
					'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'Meetings-fields', 'comments', 'revisions', 'sticky')
				) /* end of options */
			); /* end of register post type */

			register_taxonomy( 'meeting-categories', 
				array('meetings'), /* if you change the name of register_post_type( 'Meetings_type', then you have to change this */
				array('hierarchical' => true,     /* if this is true, it acts like categories */
					'labels' => array(
						'name' => __( 'Meetings Categories', 'bonestheme' ), /* name of the Meetings taxonomy */
						'singular_name' => __( 'Meetings Category', 'bonestheme' ), /* single taxonomy name */
						'search_items' =>  __( 'Search Meetings Categories', 'bonestheme' ), /* search title for taxomony */
						'all_items' => __( 'All Meetings Categories', 'bonestheme' ), /* all title for taxonomies */
						'parent_item' => __( 'Parent Meetings Category', 'bonestheme' ), /* parent title for taxonomy */
						'parent_item_colon' => __( 'Parent Meetings Category:', 'bonestheme' ), /* parent taxonomy title */
						'edit_item' => __( 'Edit Meetings Category', 'bonestheme' ), /* edit Meetings taxonomy title */
						'update_item' => __( 'Update Meetings Category', 'bonestheme' ), /* update title for taxonomy */
						'add_new_item' => __( 'Add New Meetings Category', 'bonestheme' ), /* add new title for taxonomy */
						'new_item_name' => __( 'New Meetings Category Name', 'bonestheme' ) /* name title for taxonomy */
					),
					'show_admin_column' => true, 
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => 'meetings-cat' ),
				)
			);

			register_taxonomy( 'meetings_tag', 
				array('meetings'), /* if you change the name of register_post_type( 'Meetings_type', then you have to change this */
				array('hierarchical' => false,    /* if this is false, it acts like tags */
					'labels' => array(
						'name' => __( 'Meetings Tags', 'bonestheme' ), /* name of the Meetings taxonomy */
						'singular_name' => __( 'Meetings Tag', 'bonestheme' ), /* single taxonomy name */
						'search_items' =>  __( 'Search Meetings Tags', 'bonestheme' ), /* search title for taxomony */
						'all_items' => __( 'All Meetings Tags', 'bonestheme' ), /* all title for taxonomies */
						'parent_item' => __( 'Parent Meetings Tag', 'bonestheme' ), /* parent title for taxonomy */
						'parent_item_colon' => __( 'Parent Meetings Tag:', 'bonestheme' ), /* parent taxonomy title */
						'edit_item' => __( 'Edit Meetings Tag', 'bonestheme' ), /* edit Meetings taxonomy title */
						'update_item' => __( 'Update Meetings Tag', 'bonestheme' ), /* update title for taxonomy */
						'add_new_item' => __( 'Add New Meetings Tag', 'bonestheme' ), /* add new title for taxonomy */
						'new_item_name' => __( 'New Meetings Tag Name', 'bonestheme' ) /* name title for taxonomy */
					),
					'show_admin_column' => true,
					'show_ui' => true,
					'query_var' => true,
				)
			);
		}

    	public function save_post($post_id)
    	{
            // verify if this is an auto save routine. 
            // If it is our form has not been submitted, so we dont want to do anything
            if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            {
                return;
            }
            
    		if($_POST['meetings'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    		{
    			foreach($this->_meta as $field_name)
    			{
    				// Update the post's meta field
    				update_post_meta($post_id, $field_name, $_POST[$field_name]);
    			}
    		}
    		else
    		{
    			return;
    		} // if($_POST['post_type'] == self::POST_TYPE && current_user_can('edit_post', $post_id))
    	} // END public function save_post($post_id)

	} // END class kcrf_meetings
} // END if(!class_exists('kcrf_meetings'))

?>