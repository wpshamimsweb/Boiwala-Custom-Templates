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
        $post_ids = rwmb_meta('popular_books_of_this_author');
        if (!empty($post_ids)) :
        ?>
            <h3 class="related_books_title"><?php _e( 'Related Books Of This Author', 'boiwala' ); ?></h3>
            <table class="related_books_table">
                <tr class="related_books_row header_row">
                    <th class="related_books_cell"><?php _e( 'Book Name', 'boiwala' ); ?></th>
                    <th class="related_books_cell"><?php _e( 'Publisher', 'boiwala' ); ?></th>
                    <th class="related_books_cell"><?php _e( 'Book Price', 'boiwala' ); ?></th>
                </tr>
                <?php foreach ($post_ids as $post_id) : ?>
                    <tr class="related_books_row">
                        <td class="related_books_cell">
                            <div class="book_thumbnail">
                                <?php
                                // Get the thumbnail URL for the related book
                                $thumbnail_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
                                if ($thumbnail_url) {
                                    echo '<img src="' . esc_url($thumbnail_url) . '" alt="' . get_the_title($post_id) . '">';
                                }
                                ?>
                            </div>
                            <h4 class="book_title">
                                <a href="<?= get_permalink($post_id) ?>"><?= get_the_title($post_id); ?></a>
                            </h4>
                        </td>
                        <td class="related_books_cell">
                            <?php
                            $publisher_id = rwmb_meta('book_publishers_name', ['object_type' => 'id'], $post_id);
                            if (!empty($publisher_id)) {
                                echo get_the_title($publisher_id);
                            }
                            ?>
                        </td>
                        <td class="related_books_cell">
                            <?php echo get_post_meta($post_id, 'book_price', true); ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
        <?php
        endif; // End of if statement
        ?>
    </div>

    <div class="single_book-sidebar single_author_sidebar">
        <?php
        // Get the post thumbnail
        if (has_post_thumbnail()) {
            the_post_thumbnail('thumbnail');
        }
        ?>

        <h4 class="sidebar_book_title"><?php the_title(); ?></h4>
        <div class="single_book-custom-fields">
            <div class="book_author custom_meta_field">
                <h4 class="book_field_label single_meta_field_label"><?php _e( 'Date Of Birth', 'boiwala' ); ?></h4>
                <p class="single_meta_field"><?php rwmb_the_value('author_date_of_birth'); ?></p>
            </div>
            <div class="book_publisher custom_meta_field">
                <h4 class="book_field_label single_meta_field_label"><?php _e( 'Date Of Death', 'boiwala' ); ?></h4>
                <p class="single_meta_field"><?php rwmb_the_value('author_date_of_death'); ?></p>
            </div>
            <?php if (!empty(rwmb_meta('award'))) : ?>
                <div class="book_award custom_meta_field">
                    <h4 class="book_field_label single_meta_field_label"><?php _e( 'Awards', 'boiwala' ); ?></h4>
                    <?php echo '<p class="single_meta_field">' . rwmb_meta('award') . '</p>'; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); // Load the footer template ?>
