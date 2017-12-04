<?php
/**
 * The admin-specific functionality of the plugin.
*/
class Book_Library_Admin {
	
	private $plugin_name;	
	private $version;

	/**
	 * Initialize the class and set its properties.	
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;		
		add_action( 'init', array( $this, 'create_book_post_type' ) );
		add_action( 'init', array( $this, 'create_book_taxonomies' ) );
		add_action( 'add_meta_boxes', array( $this, 'create_book_details_meta_box' ) );
		add_action( 'save_post_book', array( $this, 'save_book_details_values' ) );
		add_action( 'admin_menu', array( $this, 'lbs_detail_page' ) );
	}

	/**
	 * Creating a function to create our Book post type.	 
	 */
	public function create_book_post_type() {

		$labels = array(
			'name'               => _x( 'Books', 'Post Type General Name', 'library-book-search-plugin' ),
			'singular_name'      => _x( 'Book', 'Post Type Singular Name', 'library-book-search-plugin' ),
			'menu_name'          => __( 'Books', 'library-book-search-plugin' ),
			'parent_item_colon'  => __( 'Parent Book', 'library-book-search-plugin' ),
			'all_items'          => __( 'All Books', 'library-book-search-plugin' ),
			'view_item'          => __( 'View Book', 'library-book-search-plugin' ),
			'add_new_item'       => __( 'Add New Book', 'library-book-search-plugin' ),
			'add_new'            => __( 'Add New', 'library-book-search-plugin' ),
			'edit_item'          => __( 'Edit Book', 'library-book-search-plugin' ),
			'update_item'        => __( 'Update Book', 'library-book-search-plugin' ),
			'search_items'       => __( 'Search Book', 'library-book-search-plugin' ),
			'not_found'          => __( 'Not Found', 'library-book-search-plugin' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'library-book-search-plugin' ),
		);

		$args = array(
			'label'               => __( 'Books', 'library-book-search-plugin' ),
			'description'         => __( 'Book news and reviews', 'library-book-search-plugin' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'revisions', 'thumbnail' ),
			'taxonomies'          => array( 'publishers', 'author' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);

		/*
		 * Register book post type.
		 */
		register_post_type( 'book', $args );

	}

	/**
	 * Creating a function to create our taxonomies for book.
	 */
	public function create_book_taxonomies() {

		$labels = array(
			'name'              => _x( 'Publishers', 'taxonomy general name', 'library-book-search-plugin' ),
			'singular_name'     => _x( 'publisher', 'taxonomy singular name', 'library-book-search-plugin' ),
			'search_items'      => __( 'Search publishers', 'library-book-search-plugin' ),
			'all_items'         => __( 'All publishers', 'library-book-search-plugin' ),
			'parent_item'       => __( 'Parent publisher', 'library-book-search-plugin' ),
			'parent_item_colon' => __( 'Parent publisher:', 'library-book-search-plugin' ),
			'edit_item'         => __( 'Edit publisher', 'library-book-search-plugin' ),
			'update_item'       => __( 'Update publisher', 'library-book-search-plugin' ),
			'add_new_item'      => __( 'Add New publisher', 'library-book-search-plugin' ),
			'new_item_name'     => __( 'New publisher Name', 'library-book-search-plugin' ),
			'menu_name'         => __( 'publisher', 'library-book-search-plugin' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'publisher' ),
		);

		register_taxonomy( 'publisher', array( 'book' ), $args );

		$labels = array(
			'name'              => _x( 'Authors', 'taxonomy general name', 'library-book-search-plugin' ),
			'singular_name'     => _x( 'Author', 'taxonomy singular name', 'library-book-search-plugin' ),
			'search_items'      => __( 'Search Authors', 'library-book-search-plugin' ),
			'all_items'         => __( 'All Authors', 'library-book-search-plugin' ),
			'parent_item'       => __( 'Parent Author', 'library-book-search-plugin' ),
			'parent_item_colon' => __( 'Parent Author:', 'library-book-search-plugin' ),
			'edit_item'         => __( 'Edit Author', 'library-book-search-plugin' ),
			'update_item'       => __( 'Update Author', 'library-book-search-plugin' ),
			'add_new_item'      => __( 'Add New Author', 'library-book-search-plugin' ),
			'new_item_name'     => __( 'New Author Name', 'library-book-search-plugin' ),
			'menu_name'         => __( 'Author', 'library-book-search-plugin' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'author' ),
		);

		register_taxonomy( 'author', array( 'book' ), $args );
	}

	/**
	 * Creating a function to create meta box in book edit page.
	 *
	 * @since  1.0.0
	 */
	public function create_book_details_meta_box() {

		add_meta_box( 'book_details', __( 'Book Details', 'library-book-search-plugin' ),
			array(
				$this,
				'create_book_details_field',
			),
		'book', 'normal', 'high');

	}

	/**
	 * Save book price and rating details values.
	 *
	 * @since  1.0.0
	 *
	 * @param object $book This object of Book.
	 */
	public function create_book_details_field( $book ) {
		wp_nonce_field( basename( __FILE__ ), 'book_details' );		
		$book_price = get_post_meta( $book->ID, '_book_price', true );
		$book_rating = get_post_meta( $book->ID, '_book_rating', true );
		$book_price  = ( $book_price ) ? $book_price : '0';
		$book_rating = ( $book_rating ) ? $book_rating : '';
		?>
		<div class='inside'>
			<h3><?php esc_attr_e( 'Price', 'library-book-search-plugin' ); ?></h3>
			<p>
				<input type="number" class="book_price" name="book_price" value="<?php echo esc_attr( $book_price ); ?>"/>
			</p>

			<h3><?php esc_attr_e( 'Rating', 'library-book-search-plugin' ); ?></h3>
			<p>
				<select class="book_rating" name="book_rating">
					<?php
					for ( $i = 1; $i < 6; $i ++ ) {
						?>
						<option value="<?php echo esc_attr( $i ); ?>" <?php selected( $i, $book_rating ); ?> ><?php echo esc_html( $i ); ?> </option>
						<?php
					}
					?>
				</select>
			</p>
		</div>
<?php
	}

	/**
	 * Save book price and rating details values.
	 *
	 * @since    1.0.0
	 *
	 * @param integer $post_id This ID of Book.
	 */
	public function save_book_details_values( $post_id ) {

		$book_price   = filter_input( INPUT_POST, 'book_price', FILTER_VALIDATE_INT );
		$book_rating  = filter_input( INPUT_POST, 'book_rating', FILTER_VALIDATE_INT );
		$book_details = filter_input( INPUT_POST, 'book_details', FILTER_SANITIZE_STRING );

		// Verify taxonomies meta box nonce.
		if ( ! isset( $book_details ) || ! wp_verify_nonce( $book_details, basename( __FILE__ ) ) ) {
			return;
		}
		// Return if auto save.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( empty( $book_price ) ) {
			$book_price = 0;
		}

		update_post_meta( $post_id, '_book_price', $book_price );
		update_post_meta( $post_id, '_book_rating', $book_rating );
	}

	/**
	 * Create the function for add Library Book Search menu admin side.
	 *
	 * @since  1.0.0
	 */
	public function lbs_detail_page() {
		add_menu_page( 'Book Library', 'Book Library', 'manage_options', 'book-library',
			array(
				$this,
				'lbs_detail_text',
			)
		);
	}

	
	//Create the function for display plugin details on admin side.
	
	public function lbs_detail_text() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html( 'You do not have sufficient permissions to access this page.', 'library-book-search-plugin' ) );
		}
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline">Books Library Shortcode</h1>
			<p>
				Please use below shortcode in your page/post to display books listing.
			</p>
			<h2>[library-book-search]</h2>			
		</div>
<?php
	}

}
