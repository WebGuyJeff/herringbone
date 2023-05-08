<?php
namespace Jefferson\Herringbone;

/**
 * Register Projects Custom Post Type - Herringbone Theme.
 * 
 * This post type will store example projects for a portfolio.
 *
 * @package herringbone
 */

class Register_Projects_CPT {

	// Prefix for storing custom fields in the postmeta table.
	private const PREFIX = '_hbpr_';

	// Custom post type ID.
	private const CPTID = 'projects';

	// Metabox ID.
	private const METABOXID = 'project-meta';

	// Define custom meta fields.
	private const CUSTOMFIELDS = array(
		array(
			"name"        => "_title",
			"title"       => "Title",
			"description" => "",
			"type"        => "text"
		),
		array(
			"name"        => "_description",
			"title"       => "Description",
			"description" => "",
			"type"        => "textarea"
		),
		array(
			"name"        => "_display_order",
			"title"       => "Display Order",
			"description" => "",
			"type"        => "number"
		),
		array(
			"name"        => "_featured",
			"title"       => "Featured",
			"description" => "",
			"type"        => "checkbox"
		)
	);

	/**
	 * Register the custom post type.
	 */
	public function create_cpt() {
		register_post_type( self::CPTID,
			array(
				'labels' => array(
					'name'               => 'Projects',
					'singular_name'      => 'Project',
					'add_new'            => 'New Project',
					'add_new_item'       => 'Add New Project',
					'edit_item'          => 'Edit Project',
					'new_item'           => 'New Project',
					'view_item'          => 'View Project',
					'search_items'       => 'Search Projects',
					'not_found'          => 'No Projects Found',
					'not_found_in_trash' => 'No Projects found in Trash',
				),
				'supports'            => array( 'title', 'custom-fields' ),
				'description'         => 'A collection of projects.',
				'public'              => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'query_var'           => true,
				'show_in_menu'        => 'edit.php?post_type=projects',
				'menu_position'       => 90,
				'menu_icon'           => 'dashicons-portfolio',
				'hierarchical'        => false,
				'taxonomies'          => ['category', 'post_tags'],
				'show_in_rest'        => true,
				'delete_with_user'    => false,
			)
		);
		register_taxonomy_for_object_type( 'category', self::CPTID );
		register_taxonomy_for_object_type( 'post_tags', self::CPTID );
		add_action( 'admin_menu', array( &$this, 'create_custom_fields' ) );
		add_action( 'save_post', array( &$this, 'save_custom_fields' ), 1, 2 );
		add_action( 'do_meta_boxes', array( &$this, 'remove_default_custom_fields' ), 10, 3 );
	}

	/**
	 * Remove default custom fields meta box.
	 */
	public function remove_default_custom_fields( $type, $context, $post ) {
		foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
			remove_meta_box( 'postcustom', self::CPTID, $context );
		}
	}

	/**
	 * Create new custom fields meta box.
	 */
	public function create_custom_fields() {
		add_meta_box( self::METABOXID, 'Project Meta', array( &$this, 'display_custom_fields' ), self::CPTID, 'normal', 'high' );
	}

	/**
	 * Display the new custom fields meta box.
	 */
	public function display_custom_fields() {
		global $post;
		?>
		<div class="form-wrap">
			<?php
			wp_nonce_field( self::METABOXID, self::METABOXID . '_wpnonce', false, true );
			foreach ( self::CUSTOMFIELDS as $field ) {
				?>
				<div class="form-field form-required">
					<?php
					switch ( $field[ 'type' ] ) {
						case "text": {
							echo '<label for="' . self::PREFIX . $field[ 'name' ] .'"><b>' . $field[ 'title' ] . '</b></label>';
							echo '<input type="text" name="' . self::PREFIX . $field[ 'name' ] . '" id="' . self::PREFIX . $field[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, self::PREFIX . $field[ 'name' ], true ) ) . '" />';
							break;
						}
						case "textarea": {
							echo '<label for="' . self::PREFIX . $field[ 'name' ] .'"><b>' . $field[ 'title' ] . '</b></label>';
							echo '<textarea name="' . self::PREFIX . $field[ 'name' ] . '" id="' . self::PREFIX . $field[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, self::PREFIX . $field[ 'name' ], true ) ) . '</textarea>';
							break;
						}
						case "number": {
							echo '<label for="' . self::PREFIX . $field[ 'name' ] .'"><b>' . $field[ 'title' ] . '</b></label>';
							echo '<input type="number" name="' . self::PREFIX . $field[ 'name' ] . '" id="' . self::PREFIX . $field[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, self::PREFIX . $field[ 'name' ], true ) ) . '" />';
							break;
						}
						case 'checkbox': {
							echo '<label for="' . self::PREFIX . $field[ 'name' ] .'" style="display:inline;"><b>' . $field[ 'title' ] . '</b></label>';
							echo '<input type="checkbox" name="' . self::PREFIX . $field[ 'name' ] . '" id="' . self::PREFIX . $field[ 'name' ] . '" value="yes"';
							if ( get_post_meta( $post->ID, self::PREFIX . $field['name'], true ) == "yes" )
								echo ' checked="checked"';
							echo '" style="width: auto;" />';
							break;
						}
						default: {
							echo '<label>Custom field output error: Field type "' . $field[ 'type' ] . '" not found.</label>';
							error_log( 'Bigup_Contact_Form: field output type "' . $field[ 'type' ] . '" not found.' );
							break;
						}
					}
					?>
					<?php if ( $field[ 'description' ] ) echo '<p>' . $field[ 'description' ] . '</p>'; ?>
				</div>
				<?php
			} ?>
		</div>
		<?php
	}

	/**
	 * Save the new Custom Fields values
	 */
	function save_custom_fields( $post_id, $post ) {
		if ( ! isset( $_POST[ self::METABOXID . '_wpnonce' ] )
			|| ! wp_verify_nonce( $_POST[ self::METABOXID . '_wpnonce' ], self::METABOXID )
			|| ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( self::CUSTOMFIELDS as $field ) {
			if ( isset( $_POST[ self::PREFIX . $field[ 'name' ] ] ) && trim( $_POST[ self::PREFIX . $field['name'] ] ) ) {
				$value = $_POST[ self::PREFIX . $field[ 'name' ] ];
				// Auto-paragraphs for message body
				if ( $field[ 'type' ] == "textarea" ) $value = wpautop( $value );
					update_post_meta( $post_id, self::PREFIX . $field[ 'name' ], $value );
			} else {
				delete_post_meta( $post_id, self::PREFIX . $field[ 'name' ] );
			}
		}
	}
}
