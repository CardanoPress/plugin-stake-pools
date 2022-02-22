<?php

/**
 * Page template for displaying a stake pool.
 *
 * This can be overridden by copying it to yourtheme/single-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

get_header();

?>

<?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <h2><?php the_title(); ?></h2>

    <pre><?php print_r(get_post_meta(get_the_ID(), 'pool_data', true)); ?></pre>
<?php endwhile; ?>

<?php

get_footer();
