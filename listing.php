<?php
/**
 * Book Details HTML
 *
 * @link       akashsoni.com
 * @since      1.0.0
 * @package    Library_Book_Search_Plugin
 * @subpackage Library_Book_Search_Plugin/public/partials
 */

$book_data = get_query_var( 'book_search_data', array(
	'max_price' => 0,
	'min_price' => 0,
) );

$publisher_terms = get_terms(
	array(
		'taxonomy' => 'publisher',
	)
);
?>
<div class="search-book-list" id="search-book-list">
	<div class="search-heading">Library Books Search	</div>
	<div class="lbs-col-md-2">
		<label>Book Name:</label>
		<input class="book-name" type="text"/>
	</div>
	<div class="lbs-col-md-2">
		<label>Author:</label>
		<input class="book-author" type="text"/>
	</div>
	<div class="lbs-col-md-2">
		<label>Publisher:</label>
		<select class="book-publisher">
			<option value=""><?php esc_html_e( 'Select Publisher', 'library-book-search-plugin' ); ?></option>
			<?php
			if ( $publisher_terms ) {
				foreach ( $publisher_terms as $publisher_term ) {
					printf( '<option value="%s">%s</option>', esc_attr( $publisher_term->name ), esc_html( $publisher_term->name ) );
				}
			}
			?>
		</select>
	</div>
	<div class="lbs-col-md-2">
		<label>Rating:</label>
		<select class="book-rating">
			<option value=""><?php esc_html_e( 'Select Rating', 'library-book-search-plugin' ); ?></option>
			<?php
			for ( $i = 1; $i < 6; $i ++ ) {
				printf( '<option value="%s">%s</option>', esc_attr( $i ), esc_html( $i ) );
			}
			?>
		</select>
	</div>
	<div class="lbs-col-md-2">
		<label>Price: </label>
		<span class="price-range">
			<?php echo esc_html( '$' . $book_data['min_price'] . ' - $' . $book_data['max_price'] ); ?>
		</span>
		<input type="hidden" class="book-price" max="<?php echo esc_attr( $book_data['max_price'] ); ?>" min="<?php echo esc_attr( $book_data['min_price'] ); ?>"/>
		<div id="book-price"></div>
	</div>
	<div class="lbs-col-md-1">
		<button class="btn-book-search">Search</button>
	</div>
</div>
<div class="book-list-table">
	<table class="book-list" id="book-list">
		<thead>
		<tr>
			<th>No</th>
			<th>Book Name</th>
			<th>Price</th>
			<th>Author</th>
			<th>Publisher</th>
			<th>Rating</th>
		</tr>
		</thead>
		<tbody>
		<?php echo wp_kses_post( $book_lists ); ?>
		</tbody>
	</table>
</div>

