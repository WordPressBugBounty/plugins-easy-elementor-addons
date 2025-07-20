<?php
/**
 * Template Item
 */
?>

<div class="elementor-template-library-template-body">
    <div class="elementor-template-library-template-screenshot">
        <div class="elementor-template-library-template-preview">
            <i class="eicon-search-bold"></i>
        </div>
        <img src="{{ thumbnail }}" alt="{{ title }}">
        <div class="elementor-template-library-template-name">{{{ title }}}</div>
    </div>
</div>
<div class="elementor-template-library-template-controls">
    <# if ( 'valid' === window.EEADData.license.status || ! pro ) { #>
    <a href="#" class="elementor-template-library-template-action eead-template-insert">
        <i class="eicon-download-circle-o"></i>
        <span class="elementor-button-title"><?php echo esc_html__('Insert', 'easy-elementor-addons'); ?></span>
    </a>
    <# } else if ( pro ) { #>
    <a href="{{{ window.EEADData.license.activateLink }}}" class="eead-template-go-pro" target="_blank">
        <i class="eicon-cart-medium"></i>
        <span class="elementor-button-title">{{{ window.EEADData.license.proMessage }}}</span>
    </a>    
    <# } #>
</div>