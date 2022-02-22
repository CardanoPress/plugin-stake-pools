<?php

/**
 * Page template for displaying all stake pools.
 *
 * This can be overridden by copying it to yourtheme/archive-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

use PBWebDev\CardanoPress\StakePools\PoolData;

get_header();

?>

<ul>
    <?php while (have_posts()) : ?>
        <?php
        the_post();

        $poolData = new PoolData(get_the_ID());
        $poolDetails = $poolData->toArray();
        ?>

        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <pre><?php print_r($poolDetails); ?></pre>
        </li>
    <?php endwhile; ?>
</ul>

<?php

get_footer();
