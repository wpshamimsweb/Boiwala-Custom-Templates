<?php
get_header(); // Load the header template
?>

<div class="single_book-content-container">
    <div class="single_book-main-content">
        <?php
        while (have_posts()) {
            the_post();
            ?>

            <h1><?php the_title(); ?></h1>
            <div class="single_book-entry-content">
                <?php the_content(); ?>
            </div>

            <?php
        }
        ?>

       <?php
$post_ids = rwmb_meta( 'publishers_popular_books' );

// Check if the related_books field has a value
if ( ! empty( $post_ids ) ) :
?>
<h3 class="related_books_title"><?php _e( 'Related Books Of This Publishers', 'boiwala' ); ?></h3>
<ul class="related_books">
    <?php foreach ( $post_ids as $post_id ) : ?>
        <li class="related_book">
            <div class="related_book_thumbnail">
                <a href="<?= get_permalink( $post_id ) ?>">
                <?php
                // Get the thumbnail URL for the post
                $thumbnail_url = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
                if ( $thumbnail_url ) {
                    echo '<img src="' . esc_url( $thumbnail_url ) . '" alt="' . get_the_title( $post_id ) . '">';
                }
                ?>
            </div>
            <div class="related_book_title">
                <?= get_the_title( $post_id ); ?></a>
            </div>
        </li>
    <?php endforeach ?>
</ul>
<?php
endif; // End of if statement
?>



    </div>

    <div class="single_book-sidebar">
        <?php
        // Get the post thumbnail
        if (has_post_thumbnail()) {
            the_post_thumbnail('thumbnail');
        }
        ?>

        
        <div class="single_book-custom-fields">
            <div class="book_author custom_meta_field">
                <h4 class="book_field_label"><?php _e( 'Name', 'boiwala' ); ?></h4>
                <p class="sidebar_book_title"><?php the_title(); ?></p>
            </div>
            <div class="book_author custom_meta_field">
                <h4 class="book_field_label"><?php _e( 'Proprietor Name', 'boiwala' ); ?></h4>
                <p class><?php rwmb_the_value( 'publishers_proprietor_name' );  ?></p>
            </div>
            <div class="book_publisher custom_meta_field">
                <h4 class="book_field_label"><?php _e( 'Established', 'boiwala' ); ?></h4>
                <p><?php rwmb_the_value( 'publishers_established' ); ?></p>
            </div>
            <div class="book_publisher_date custom_meta_field">
                <h4 class="book_field_label"><?php _e( 'Contact', 'boiwala' ); ?></h4>
                <p><?php rwmb_the_value( 'publishers_contact' ); ?></p>
            </div>
            <div class="book_publisher_price custom_meta_field">
                <h4 class="book_field_label"><?php _e( 'Sales Center', 'boiwala' ); ?></h4>
                <p><?php rwmb_the_value( 'publishers_sales_center' ); ?></p>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); // Load the footer template ?>