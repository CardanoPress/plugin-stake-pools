<?php

/**
 * Page template for displaying all stake pools.
 *
 * This can be overridden by copying it to yourtheme/archive-stake-pool.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

cardanoPress()->compatibleHeader();

?>

<div class="container py-5">
    <ul x-data="cardanoPressStakePools">
        <?php while (have_posts()) : ?>
            <?php
            the_post();

            $poolData = cpStakePools()->getPoolData(get_the_ID());
            $fullData = $poolData->toArray();
            $poolHex  = $fullData['hex'];
            ?>

            <li>
                <h2 class="d-flex align-items-center">
                    <a href="<?php the_permalink(); ?>" class="me-2"><?php the_title(); ?></a>
                    <?php cpStakePools()->template('delegation', compact('poolHex')); ?>
                </h2>

                <pre><?php print_r($fullData); ?></pre>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php

cardanoPress()->compatibleFooter();
