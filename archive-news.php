<?php
/*
Template Name: Post Archive
*/

get_header();
?>

<div class="interview-listing">
    <div class="book-banner">
        <img src="http://wdstheme.com/boiwala/wp-content/uploads/2023/08/Image-07-1.jpg" alt="Interview Banner">
        <h1>News</h1>
    </div>
    <?php
    $posts_per_page = 4;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>

            <div class="interview-item">
                <div class="interview-item-left">
                    <h2><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                        </a>
                        </h2>
                    <p><?php the_excerpt(); ?></p>
                    <div class="see-more-button read_more_news">
                            <a href="<?php the_permalink(); ?>" class="see-more-link">Read More</a>
                        </div>
                </div>
                <div class="interview-item-right">
                    <!--<p class="interview-date"><?php //the_date(); ?></p>-->
                    <div class="interview-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail(); ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No interviews found.</p>';
    }
    ?>
</div>

<div class="pagination">
    <?php echo paginate_links(array('total' => $query->max_num_pages)); ?>
</div>

<?php get_footer();