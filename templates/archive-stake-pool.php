<?php

/**
 * Page template for displaying all stake pools.
 *
 * This can be overridden by copying it to yourtheme/archive-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

get_header();

?>

<ul>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
    <?php endwhile; ?>
</ul>

<?php

get_footer();
