<?php

/**
 * The template for displaying the button to process the delegation.
 *
 * This can be overridden by copying it to yourtheme/cardanopress/stake-pools/delegation.php.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

if (empty($poolHex)) {
    return;
}

if (empty($text)) {
    $text = 'Delegate';
}

?>

<button
    class="btn btn-primary"
    @click="handleDelegation('<?php echo $poolHex; ?>')"
    x-bind:disabled="isProcessing"
>
    <?php echo $text; ?>
</button>
