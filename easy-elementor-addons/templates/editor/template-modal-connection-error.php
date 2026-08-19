<?php

/**
 * Templates Loader Connection Error
 *
 * Shown when the library request fails outright, as opposed to the license
 * error view which covers a valid response the license does not cover. The
 * usual cause is an editor tab left open long enough for its security token
 * to expire, which a reload fixes.
 */
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="elementor-library-error">
    <div class="elementor-library-error-message">
        <?php echo esc_html__('The template library could not be loaded.', 'easy-elementor-addons'); ?>
    </div>
    <div class="elementor-library-error-link">
        <?php echo esc_html__('Your editor session may have expired. Please reload the page and try again.', 'easy-elementor-addons'); ?>
    </div>
</div>
