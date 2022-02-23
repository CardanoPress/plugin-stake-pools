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
        $fullData = $poolData->toArray();
        ?>

        <h2><?php the_title(); ?></h2>

        <button
            type="button"
            @click="handleDelegation('<?php echo $fullData['hex']; ?>')"
            x-bind:disabled='isProcessing'
        >
            Delegate
        </button>
        <pre><?php print_r($fullData); ?></pre>
    <?php endwhile; ?>
</div>

<?php

get_footer();
