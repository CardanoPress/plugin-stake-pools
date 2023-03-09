<?php

/**
 * Page template for displaying a stake pool.
 *
 * This can be overridden by copying it to yourtheme/single-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

$postId = get_the_ID();

get_header();

?>

<div id="stake-pool-<?php echo esc_attr($postId); ?>" class="py-5">
    <div class="container">
        <div x-data="cardanoPressStakePools">
            <?php while (have_posts()) : ?>
                <?php
                the_post();

                $poolData = cpStakePools()->getPoolData($postId);
                $fullData = $poolData->toArray();
                $poolHex  = $fullData['hex'];
                ?>

                <h2 class="d-flex align-items-center">
                    <span class="me-2"><?php the_title(); ?></span>
                    <?php cpStakePools()->template('delegation', compact('poolHex')); ?>
                </h2>

                <?php the_content(); ?>
                <pre><?php print_r($fullData); ?></pre>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php

get_footer();
