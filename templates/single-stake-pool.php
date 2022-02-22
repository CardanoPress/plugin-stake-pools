<?php

/**
 * Page template for displaying a stake pool.
 *
 * This can be overridden by copying it to yourtheme/single-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

use PBWebDev\CardanoPress\StakePools\PoolData;

get_header();

?>

<?php while (have_posts()) : ?>
    <?php
    the_post();

    $poolData = new PoolData(get_the_ID());
    $poolDetails = $poolData->toArray();
    ?>

    <h2><?php the_title(); ?></h2>

    <pre><?php print_r(get_post_meta(get_the_ID(), 'pool_data', true)); ?></pre>
    <pre><?php print_r($poolDetails); ?></pre>
<?php endwhile; ?>

<?php

get_footer();
