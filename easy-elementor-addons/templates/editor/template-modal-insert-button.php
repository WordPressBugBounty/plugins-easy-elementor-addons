<?php
/**
 * Template Insert Button
 */
?>
<# if ( '' != url ) { #>
<a class="elementor-button elementor-button-live-preview" href="{{{ url }}}" target="_blank">
    <?php esc_html_e('Live Preview', 'easy-elementor-addons'); ?>
    <i class="eicon-editor-external-link"></i>
</a>
<# } #>

<# if ( 'valid' === window.EEADData.license.status || ! pro ) { #>
<button class="eead-template-insert elementor-button elementor-button-success">
    <i class="eicon-download-circle-o"></i>
    <span class="elementor-button-title"><?php esc_html_e('Insert', 'easy-elementor-addons'); ?></span>
</button>
<# } else { #>
<a class="elementor-button elementor-button-go-pro" href="{{{ window.EEADData.license.activateLink }}}" target="_blank">
    <i class="eicon-cart-medium"></i>
    <span class="elementor-button-title">{{{ window.EEADData.license.proMessage }}}</span>
</a>
<# } #>