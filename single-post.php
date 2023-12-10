<?php get_header(); // Load the header template ?>

<div class="single_news-content-container">
    <div class="single_news-main-content">
        <?php
        while (have_posts()) {
            the_post();
            ?>

     <div class="news-post-container">
        <h1 class="news-post-title"><?php the_title(); ?></h1>
        <div class="news-post-info">
            <div class="news-author-name"><?php the_author(); ?></div>
            <div class="news-published-date"><?php the_date(); ?></div>
        </div>
        <div class="news-post-content">
            <?php the_content(); ?>
        </div>
        <?php
        $post_ids = rwmb_meta( 'post_q3hho6zozad' );

        // Check if the select field has a value
        if ( ! empty( $post_ids ) ) :
        ?>
        <h3 class="related_books_title"><?php _e( 'Related News', 'boiwala' ); ?></h3>
        <ul class="related_news">
            <?php foreach ( $post_ids as $post_id ) : ?>
                <li>
                    <div class="popular_book_col popular_book_title">
                        <a href="<?= get_permalink( $post_id ) ?>"><?= get_the_title( $post_id ); ?></a>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <?php
        endif; // End of if statement
        ?>
     </div>

            <?php
        }
        ?>
    </div>
</div>

<?php get_footer(); // Load the footer template ?>