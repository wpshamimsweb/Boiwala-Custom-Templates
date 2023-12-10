<?php
/**
 * Template Name: Publisher Archive
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="book-banner">
            <img src="http://wdstheme.com/boiwala/wp-content/uploads/2023/08/blog-single-img-10-1.jpg" alt="Interview Banner">
            <h1><?php _e( 'Publishers', 'boiwala' ); ?></h1>
        </div>


        <?php if ( have_posts() ) : ?>

            <?php
            // Get all the categories assigned to the custom post type
            $categories = get_terms( array(
                'taxonomy' => 'publishers-category',
                'hide_empty' => false,
            ) );

            // Loop through the categories
            foreach ( $categories as $category ) :
                // Get the posts for the current category
                $posts = new WP_Query( array(
                    'post_type' => 'publisher',
                    'posts_per_page' => 10,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'publishers-category',
                            'field' => 'slug',
                            'terms' => $category->slug,
                        ),
                    ),
                ) );
                ?>

                <div class="book_category_section clearfix equal_height">
                    <h2 class="book_category_title" style="color: blue;"><a href="<?php echo get_term_link( $category->term_id ); ?>"><?php echo $category->name; ?></a></h2>

                   <!--  <div class="row"> -->
                        <?php
                        $post_count = 0;
                        while ( $posts->have_posts() && $post_count < 3 ) : $posts->the_post();
                            $post_count++;
                            ?>
                            <div class="book_column">
                                 <?php
                                $thumbnail = get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
                                if ( $thumbnail ) {
                                    echo '<div class="book_thumbnail">' . $thumbnail . '</div>';
                                }
                                ?>
                                <h4 class="book_post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <!-- <div class="post-content"><?php //the_content(); ?></div> -->
                            </div>
                        <?php endwhile; ?>
                    <!-- </div> -->

                    <?php if ( $posts->found_posts > 3 ) : ?>
                        <div class="see-more-button">
                            <a href="<?php echo get_term_link( $category->term_id ); ?>" class="see-more-link"><?php _e( 'See More', 'boiwala' ); ?></a>
                        </div>
                    <?php endif; ?>

                </div>

                <?php
                // Reset the post data for the next category
                wp_reset_postdata();
            endforeach;
            ?>

        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>

    </main><!-- #main -->
</div><!-- #primary -->



<?php get_footer(); ?>