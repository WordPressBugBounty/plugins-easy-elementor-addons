<?php
/**
 * Template Library Filter Item
 */
?>
<label class="eead-modal-template-filter-label">
    <input type="radio" value="{{ slug }}" <# if ( '' === slug ) { #> checked<# } #> name="eead-modal-template-filter">
           <span>{{ title.replace('&amp;', '&') }}</span>
</label>