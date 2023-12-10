<?php
/*
Template Name: Books Category Taxonomy Archive
*/


get_header(); 

// Get the current term (category)
$current_term = get_queried_object(); 

// Get the category image (featured image)
$category_image = get_term_meta($current_term->term_id, 'category_image_meta_key', true); // Replace 'category_image_meta_key' with the actual meta key for your category images.

?>
<span property="itemListElement" typeof="ListItem"><a property="item" typeof="WebPage" title="Go to the %title% Books category archives." href="%link%" class="%type%" bcn-aria-current><span property="name">%htitle%</span></a><meta property="position" content="%position%"></span>
<div class="category-banner book-banner">

        <img src="http://wdstheme.com/boiwala/wp-content/uploads/2023/08/Image-07-1.jpg" alt="<?php echo esc_attr($current_term->name); ?>">
    <h1><?php echo esc_html($current_term->name); ?></h1>
</div>

<div class="post-grid">
    <?php
    $posts_per_page = 30;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type'      => 'book', 
        'posts_per_page' => $posts_per_page,
        'paged'          => $paged,
        'tax_query'      => array(
            array(
                'taxonomy' => $current_term->taxonomy,
                'field'    => 'slug',
                'terms'    => $current_term->slug,
            ),
        ),
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ?>

            <div class="post-grid-item">
                <a class="archive_post_thumbnail" href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                    <h2 class="archive_post_title"><?php the_title(); ?></h2></a>
                    <p class="archive_post_meta archive_post_meta1"><?php rwmb_the_value( 'book_author_name' ); ?></p>
                <?php
                $year_published = rwmb_meta( 'year_publsihed' ); // Get the value of the 'year_published' field

                if ( ! empty( $year_published ) ) {
                ?>
                <p class="archive_post_meta archive_post_meta2">Published: <?php echo $year_published; ?></p>
                <?php    
                }
                ?>

                
            </div>

            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No posts found.</p>';
    }
    ?>
</div>

<div class="pagination">
    <?php echo paginate_links(array('total' => $query->max_num_pages)); ?>
</div>

<script>
window.addEventListener("load", function () {
  // Get all post elements
  const posts = document.querySelectorAll(".post-grid-item");

  // Calculate the maximum height
  let maxHeight = 0;
  for (const post of posts) {
    maxHeight = Math.max(maxHeight, post.clientHeight);
  }

  // Set the same height for all posts
  for (const post of posts) {
    post.style.height = maxHeight + "px";
  }
});
</script>
<?php get_footer(); 
