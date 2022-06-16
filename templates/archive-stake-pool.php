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

<div class="container py-5">
    <ul x-data="cardanoPressStakePools">
        <?php while (have_posts()) : ?>
            <?php
            the_post();

            $poolData = cpStakePools()->getPoolData(get_the_ID());
            $fullData = $poolData->toArray();
            $poolId   = $fullData['pool_id'];
            ?>

            <li>
                <h2 class="d-flex align-items-center">
                    <a href="<?php the_permalink(); ?>" class="me-2"><?php the_title(); ?></a>
                    <?php cpStakePools()->template('delegation', compact('poolId')); ?>
                </h2>

                <pre><?php print_r($fullData); ?></pre>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php

get_footer();
