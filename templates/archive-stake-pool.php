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

<ul x-data="cardanoPressStakePools">
    <?php while (have_posts()) : ?>
        <?php
        the_post();

        $poolData = cpStakePools()->getPoolData(get_the_ID());
        $fullData = $poolData->toArray();
        ?>

        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <button
                type="button"
                @click="handleDelegation('<?php echo $fullData['hex']; ?>')"
                x-bind:disabled="isProcessing"
            >
                Delegate
            </button>
            <pre><?php print_r($fullData); ?></pre>
        </li>
    <?php endwhile; ?>
</ul>

<?php

get_footer();
