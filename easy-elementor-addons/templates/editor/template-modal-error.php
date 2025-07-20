<?php

/**
 * Templates Loader Error
 */
use EEADElements\Templates;
?>
<div class="elementor-library-error">
    <div class="elementor-library-error-message">
        <?php
        echo esc_html__('Template couldn\'t be loaded. Please activate you license key before.', 'easy-elementor-addons');
        ?>
    </div>
    <div class="elementor-library-error-link">
        <?php
        printf(
            '<a class="template-library-activate-license" href="%1$s" target="_blank">%2$s %3$s</a>', Templates\eead_elementor_templates()->config->get('license_page'), '<i class="eicon-editor-external-link" aria-hidden="true"></i>', Templates\eead_elementor_templates()->config->get('pro_message')
        );
        ?>
    </div>
</div>