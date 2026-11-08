<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$eead_general_settings = get_option('eead_general_settings');
$eead_gmap_access_token = isset($eead_general_settings['gmap_access_token']) && $eead_general_settings['gmap_access_token'] ? $eead_general_settings['gmap_access_token'] : '';
$eead_gmap_map_id = isset($eead_general_settings['gmap_map_id']) && $eead_general_settings['gmap_map_id'] ? $eead_general_settings['gmap_map_id'] : '';
$eead_weather_api_key = isset($eead_general_settings['weather_api_key']) && $eead_general_settings['weather_api_key'] ? $eead_general_settings['weather_api_key'] : '';

$eead_all_widgets = eead_get_all_widgets_list();

?>

<div class="eead-wrap">

    <div class="eead-admin-header-section">
        <div class="eead-admin-brand">
            <span class="eead-admin-logo" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160.64 160.67" fill="currentColor">
                <path d="M74.55 14.94A14.93 14.93 0 0 0 59.64 0H14.91A14.93 14.93 0 0 0 0 14.94v44.73a14.93 14.93 0 0 0 14.91 14.91h44.73a14.93 14.93 0 0 0 14.91-14.91Zm0 86.09a14.92 14.92 0 0 0-14.91-14.91H14.91A14.92 14.92 0 0 0 0 101v44.73a14.93 14.93 0 0 0 14.91 14.91h44.73a14.93 14.93 0 0 0 14.91-14.91Zm86.09 0a14.92 14.92 0 0 0-14.91-14.91H101A14.9 14.9 0 0 0 86.09 101v44.73A14.92 14.92 0 0 0 101 160.67h44.73a14.93 14.93 0 0 0 14.91-14.91ZM133.8 4.33a14.81 14.81 0 0 0-20.92 0l-22.5 22.5a14.79 14.79 0 0 0 0 20.91l22.5 22.5a14.79 14.79 0 0 0 20.92 0l22.49-22.5a14.77 14.77 0 0 0 0-20.9z" />
            </svg>
            </span>
            <div>
                <h2 class="eead-admin-header-text">
                    <?php echo esc_html__('Easy Elementor Addons', 'easy-elementor-addons'); ?>
                    <span class="eead-admin-version">v<?php echo esc_html(EEAD_VERSION); ?></span>
                </h2>
                <p class="eead-admin-subtitle"><?php esc_html_e('Turn widgets on or off and add the API keys some of them need.', 'easy-elementor-addons'); ?></p>
            </div>
        </div>
        <div class="eead-doc-link">
            <a href="https://demo.hashthemes.com/easy-elementor-addons/" target="_blank" rel="noopener noreferrer">
                <span class="mdi-eye-outline"></span>
                <?php echo esc_html__('View Demos', 'easy-elementor-addons'); ?>
            </a>
            <a href="https://hashthemes.com/documentation/easy-elementor-addons-documentation/" target="_blank" rel="noopener noreferrer" class="eead-doc-primary">
                <span class="mdi-text-box-multiple-outline"></span>
                <?php echo esc_html__('Documentation', 'easy-elementor-addons'); ?>
            </a>
        </div>
    </div>

    <div class="wrap">
    <h1></h1>
    </div>

    <nav class="eead-nav-tab-wrapper">
        <a href="javascript:void(0)" class="nav-tab-active eead-tab" data-tab="eead-widgets-section-content" data-tohide="tab-content">
            <i class="mdi-widgets-outline"></i>
            <?php esc_html_e('Widgets', 'easy-elementor-addons'); ?>
        </a>

        <a href="javascript:void(0)" class="eead-tab" data-tab="eead-api-settings-content" data-tohide="tab-content">
            <i class="mdi-cog"></i>
            <?php esc_html_e('Settings', 'easy-elementor-addons'); ?>
        </a>

        <a href="javascript:void(0)" class="eead-tab" data-tab="eead-about-section-content" data-tohide="tab-content">
            <i class="mdi-file-document-multiple-outline"></i>
            <?php esc_html_e('About', 'easy-elementor-addons'); ?>
        </a>

        <?php do_action('eead_admin_tabs'); ?>
    </nav>

    <div class="eead-tab-contents">
        <div id="eead-widgets-section-content" class="tab-content">
            <div class="eead-widget-toolbar">
                <div class="eead-widget-toolbar-filters">
                    <?php do_action('eead_before_admin_widgets'); ?>
                </div>

                <div class="eead-widget-action-buttons">
                    <button class="eead-widget-action-btn eead-widget-enable-all">
                        <i class="mdi-check-circle-outline"></i><?php esc_html_e('Enable All', 'easy-elementor-addons') ?>
                    </button>
                    <button class="eead-widget-action-btn eead-widget-disable-all">
                        <i class="mdi-close-circle-outline"></i><?php esc_html_e('Disable All', 'easy-elementor-addons') ?>
                    </button>
                </div>
            </div>

            <form id="eead-widget-selection-form">
                <?php
                // Group the widgets by category, in the categories' order; unknown or
                // missing categories still show, in their own groups at the end.
                $eead_categories = eead_get_widget_categories();
                $eead_groups = array_fill_keys(array_keys($eead_categories), array());
                foreach ($eead_all_widgets as $eead_key => $eead_val) {
                    $eead_cat = !empty($eead_val['category']) ? $eead_val['category'] : 'other';
                    $eead_groups[$eead_cat][$eead_key] = $eead_val;
                }

                foreach (array_filter($eead_groups) as $eead_cat => $eead_widgets) {
                    if (isset($eead_categories[$eead_cat])) {
                        $eead_label = $eead_categories[$eead_cat];
                    } else {
                        $eead_label = 'other' === $eead_cat ? __('Other', 'easy-elementor-addons') : ucwords(str_replace('-', ' ', $eead_cat));
                    }
                    ?>
                    <div class="eead-widget-group" data-category="<?php echo esc_attr($eead_cat); ?>">
                        <div class="eead-widget-group-header">
                            <h3 class="eead-widget-group-title">
                                <?php echo esc_html($eead_label); ?>
                                <span class="eead-widget-group-count"><?php echo esc_html(count($eead_widgets)); ?></span>
                            </h3>
                            <div class="eead-widget-group-actions">
                                <button type="button" class="eead-widget-group-btn eead-enable" data-checked="1"><i class="mdi-check-circle-outline" aria-hidden="true"></i><?php esc_html_e('Enable All', 'easy-elementor-addons'); ?></button>
                                <button type="button" class="eead-widget-group-btn eead-disable" data-checked="0"><i class="mdi-close-circle-outline" aria-hidden="true"></i><?php esc_html_e('Disable All', 'easy-elementor-addons'); ?></button>
                            </div>
                        </div>
                        <div class="eead-widget-section-inner-wrap">
                            <?php
                            foreach ($eead_widgets as $eead_key => $eead_val) {
                                $this->get_widget_field($eead_val['name'], $eead_key, $eead_val['icon'], $eead_val['demo_url'], isset($eead_val['premium']) && $eead_val['premium'], $eead_cat);
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="eaad-save-button-wrap">
                    <button name="eead-widget-enable" id="eead-widget-selection-btn" class="eead-save-button">
                        <i class="mdi-content-save"></i><?php esc_html_e('Save', 'easy-elementor-addons'); ?>
                        <span class="eead-loader"></span>
                    </button>
                </div>
            </form>
        </div>

        <div id="eead-api-settings-content" class="tab-content" style="display: none;">
            <form id="eead-general-settings-form">
                <div class="eead-settings-intro">
                    <h3 class="eead-widget-group-title"><?php esc_html_e('API Keys', 'easy-elementor-addons'); ?></h3>
                    <p><?php esc_html_e('A few widgets use third-party services. Add a key only for the widgets you use; everything else works without one.', 'easy-elementor-addons'); ?></p>
                </div>

                <div class="eead-google-api-key">
                    <div class="eead-settings-field">
                        <label><?php esc_html_e('Google Map Access Token', 'easy-elementor-addons') ?></label>
                        <div class="eead-settings-input-field">
                            <input type="text" name="gmap_access_token" placeholder="<?php esc_attr_e('Enter Your Gmap Access Token', 'easy-elementor-addons'); ?>" value="<?php echo esc_attr($eead_gmap_access_token); ?>">
                        </div>
                        <div class="eead-desc">
                            <?php esc_html_e('Tutorial to create ', 'easy-elementor-addons'); ?> <a href="https://hashthemes.com/articles/create-a-google-maps-api-key/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Google Map Access Token', 'easy-elementor-addons'); ?></a>
                        </div>
                    </div>

                    <div class="eead-settings-field">
                        <label><?php esc_html_e('Google Map ID', 'easy-elementor-addons') ?></label>
                        <div class="eead-settings-input-field">
                            <input type="text" name="gmap_map_id" placeholder="<?php esc_attr_e('Enter Your Google Map ID (optional)', 'easy-elementor-addons'); ?>" value="<?php echo esc_attr($eead_gmap_map_id); ?>">
                        </div>
                        <div class="eead-desc">
                            <?php esc_html_e('Optional. Required for Advanced Markers (replacement of the deprecated legacy markers). With a Map ID, map styling is managed in Google Cloud and the widget\'s Snazzy Style option is ignored. Can be overridden per widget.', 'easy-elementor-addons'); ?> <a href="https://developers.google.com/maps/documentation/get-map-id" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Create a Map ID', 'easy-elementor-addons'); ?></a>
                        </div>
                    </div>

                    <div class="eead-settings-field">
                        <label><?php esc_html_e('Weather API Key', 'easy-elementor-addons') ?></label>
                        <div class="eead-settings-input-field">
                            <input type="text" name="weather_api_key" placeholder="<?php esc_attr_e('Enter Your API Key', 'easy-elementor-addons'); ?>" value="<?php echo esc_attr($eead_weather_api_key); ?>">
                        </div>
                        <div class="eead-desc">
                            <?php esc_html_e('To get the api key click', 'easy-elementor-addons') ?> <a href="https://weatherstack.com/quickstart" target="_blank" rel="noopener noreferrer"><?php esc_html_e('here', 'easy-elementor-addons'); ?></a>
                        </div>
                    </div>
                </div>

                <div class="eaad-save-button-wrap">
                    <button class="eead-save-button" id="eead-general-settings-save">
                        <i class="mdi-content-save"></i>
                        <?php esc_html_e('Save', 'easy-elementor-addons'); ?>
                        <span class="eead-loader"></span></button>
                </div>
            </form>
        </div>

        <div id="eead-about-section-content" class="tab-content" style="display: none;">
            <?php
            $eead_description = eead_get_all_widgets_desc();
            $eead_about_groups = array();
            foreach ($eead_all_widgets as $eead_key => $eead_val) {
                $eead_about_groups[!empty($eead_val['category']) ? $eead_val['category'] : 'other'][$eead_key] = $eead_val;
            }
            ?>
            <div class="eead-about-intro">
                <div class="eead-about-intro-text">
                    <h3><?php esc_html_e('About Easy Elementor Addons', 'easy-elementor-addons'); ?></h3>
                    <p><?php esc_html_e('An all-in-one widget pack for the Elementor page builder. Every widget is fully editable, works with any theme, and loads its scripts only on the pages that use it, so your site stays fast.', 'easy-elementor-addons'); ?></p>
                    <div class="eead-about-links">
                        <a href="https://demo.hashthemes.com/easy-elementor-addons/" target="_blank" rel="noopener noreferrer" class="eead-about-btn eead-about-btn-primary"><span class="mdi-eye-outline"></span><?php esc_html_e('See All Demos', 'easy-elementor-addons'); ?></a>
                        <a href="https://hashthemes.com/documentation/easy-elementor-addons-documentation/" target="_blank" rel="noopener noreferrer" class="eead-about-btn"><span class="mdi-text-box-multiple-outline"></span><?php esc_html_e('Documentation', 'easy-elementor-addons'); ?></a>
                        <a href="https://hashthemes.com/" target="_blank" rel="noopener noreferrer" class="eead-about-btn"><span class="mdi-lifebuoy"></span><?php esc_html_e('Get Support', 'easy-elementor-addons'); ?></a>
                    </div>
                </div>
                <ul class="eead-about-stats">
                    <li><strong><?php echo esc_html(count($eead_all_widgets)); ?></strong><?php esc_html_e('Widgets', 'easy-elementor-addons'); ?></li>
                    <li><strong><?php echo esc_html(count($eead_about_groups)); ?></strong><?php esc_html_e('Categories', 'easy-elementor-addons'); ?></li>
                    <li><strong><?php esc_html_e('Any', 'easy-elementor-addons'); ?></strong><?php esc_html_e('Theme', 'easy-elementor-addons'); ?></li>
                </ul>
            </div>

            <h3 class="eead-about-heading"><?php esc_html_e('Widgets in the Plugin', 'easy-elementor-addons'); ?></h3>
            <?php
            $eead_categories = eead_get_widget_categories();
            foreach (array_merge(array_intersect_key($eead_categories, $eead_about_groups), array_diff_key($eead_about_groups, $eead_categories)) as $eead_cat => $eead_unused) {
                $eead_label = isset($eead_categories[$eead_cat]) ? $eead_categories[$eead_cat] : ('other' === $eead_cat ? __('Other', 'easy-elementor-addons') : ucwords(str_replace('-', ' ', $eead_cat)));
                ?>
                <div class="eead-about-group">
                    <h4><?php echo esc_html($eead_label); ?></h4>
                    <ul class="eead-about-widgets">
                        <?php foreach ($eead_about_groups[$eead_cat] as $eead_key => $eead_val) { ?>
                            <li>
                                <?php
                                // Add-on widgets have no page on the free demo site, so the name is
                                // only linked when the widget actually declares a demo URL.
                                if (!empty($eead_val['demo_url'])) {
                                    ?>
                                    <a href="<?php echo esc_url($eead_val['demo_url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($eead_val['name']); ?></a>
                                    <?php
                                } else {
                                    echo '<span class="eead-about-widget-name">' . esc_html($eead_val['name']) . '</span>';
                                }
                                if (!empty($eead_description[$eead_key])) {
                                    echo '<span class="eead-about-widget-desc">' . esc_html($eead_description[$eead_key]) . '</span>';
                                }
                                ?>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php
            }
            ?>

            <div class="eead-about-cards">
                <div class="eead-about-card">
                    <h4><span class="mdi-puzzle-check-outline"></span><?php esc_html_e('Compatibility', 'easy-elementor-addons'); ?></h4>
                    <p><?php esc_html_e('Easy Elementor Addons is compatible with all types of free and premium WordPress themes. The only thing is that you will need to install Elementor Plugin.', 'easy-elementor-addons'); ?></p>
                </div>
                <div class="eead-about-card">
                    <h4><span class="mdi-lifebuoy"></span><?php esc_html_e('Support', 'easy-elementor-addons'); ?></h4>
                    <p><?php esc_html_e('If you have any issues while using our plugin, feel free to contact us for support. Our support team will be more than happy to help you resolve your issue. You can chat with us or email us at our website', 'easy-elementor-addons'); ?> <a href="https://hashthemes.com/" target="_blank" rel="noopener noreferrer"><?php esc_html_e('here', 'easy-elementor-addons'); ?></a>.</p>
                </div>
            </div>
        </div>

        <?php do_action('eead_admin_tab_contents'); ?>

        <div class="eead-admin-notificn" style="display: none;"></div>
    </div>
</div>