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
use ThemePlate\Enqueue;

Enqueue::asset('script', 'cp-stake-pools-script');

get_header();

?>

<div x-data="cardanoPressStakePools">
    <?php while (have_posts()) : ?>
        <?php
        the_post();

        $poolData = new PoolData(get_the_ID());
        ?>

        <h2><?php the_title(); ?></h2>

        <pre><?php print_r($poolData->toArray()); ?></pre>
    <?php endwhile; ?>
</div>

<?php

get_footer();
