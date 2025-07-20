<?php
/**
 * Templates Keywords Filter
 */
?>
<#
if ( ! _.isEmpty( widgets ) ) {
#>
<div id="elementor-template-library-filter">
    <label><?php echo esc_html__('Filter by', 'easy-elementor-addons'); ?></label>
    <select id="elementor-template-library-filter-subtype" class="elementor-template-library-filter-select eead-library-widgets" data-elementor-filter="subtype">
        <option value=""><?php echo esc_html__('All Widgets/Addons', 'easy-elementor-addons'); ?></option>
        <# _.each( widgets, function( title, slug ) { #>
        <option value="{{ slug }}">{{ title }}</option>
        <# } ); #>
    </select>
</div>
<#
}
#>