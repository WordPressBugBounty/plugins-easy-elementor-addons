<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

$eead_general_settings = get_option('eead_general_settings');
$eead_widgets = get_option('eead_widgets');
$eead_extenders = get_option('eead_extenders');
$gmap_access_token = isset($eead_general_settings['gmap_access_token']) && $eead_general_settings['gmap_access_token'] ? $eead_general_settings['gmap_access_token'] : '';
$weather_api_key = isset($eead_general_settings['weather_api_key']) && $eead_general_settings['weather_api_key'] ? $eead_general_settings['weather_api_key'] : '';

$eead_all_widgets = eead_get_all_widgets_list();

?>

<div class="eead-wrap">

    <div class="eead-admin-header-section">
        <h1 class="eead-admin-header-text">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160.64 160.67" fill="#111">
                <path d="M74.55 14.94A14.93 14.93 0 0 0 59.64 0H14.91A14.93 14.93 0 0 0 0 14.94v44.73a14.93 14.93 0 0 0 14.91 14.91h44.73a14.93 14.93 0 0 0 14.91-14.91Zm0 86.09a14.92 14.92 0 0 0-14.91-14.91H14.91A14.92 14.92 0 0 0 0 101v44.73a14.93 14.93 0 0 0 14.91 14.91h44.73a14.93 14.93 0 0 0 14.91-14.91Zm86.09 0a14.92 14.92 0 0 0-14.91-14.91H101A14.9 14.9 0 0 0 86.09 101v44.73A14.92 14.92 0 0 0 101 160.67h44.73a14.93 14.93 0 0 0 14.91-14.91ZM133.8 4.33a14.81 14.81 0 0 0-20.92 0l-22.5 22.5a14.79 14.79 0 0 0 0 20.91l22.5 22.5a14.79 14.79 0 0 0 20.92 0l22.49-22.5a14.77 14.77 0 0 0 0-20.9z" />
            </svg>
            <?php echo esc_html__('Easy Elementor Addons Setttings', 'easy-elementor-addons'); ?> - V<?php echo EEAD_VERSION; ?>
        </h1>
        <div class="eead-version">
            <a href="https://hashthemes.com/documentation/easy-elementor-addons-documentation/" target="_blank">
                <span class="mdi-text-box-multiple-outline"></span>
                <?php echo esc_html__('Documentation', 'easy-elementor-addons'); ?>
            </a>
        </div>
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
    </nav>

    <div class="eead-tab-contents">
        <div id="eead-widgets-section-content" class="tab-content">
            <?php do_action('eead_before_admin_widgets'); ?>

            <div class="eead-widget-action-buttons">
                <button class="eead-widget-action-btn eead-widget-enable-all">
                    <i class="mdi-check-circle-outline"></i><?php esc_html_e('Enable All', 'easy-elementor-addons') ?>
                </button>
                <button class="eead-widget-action-btn eead-widget-disable-all">
                    <i class="mdi-close-circle-outline"></i><?php esc_html_e('Disable All', 'easy-elementor-addons') ?>
                </button>
            </div>

            <form id="eead-widget-selection-form">
                <div class="eead-widget-section-inner-wrap">
                    <?php
                    foreach ($eead_all_widgets as $key => $val) {
                        $this->get_widget_field($val['name'], $key, $val['icon'], $val['demo_url'], isset($val['premium']) && $val['premium'], isset($val['category']) ? $val['category'] : '');
                    }
                    ?>
                </div>

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
                <div class="eead-google-api-key">
                    <div class="eead-settings-field">
                        <label><?php esc_html_e('Google Map Access Token', 'easy-elementor-addons') ?></label>
                        <div class="eead-settings-input-field">
                            <input type="text" name="gmap_access_token" placeholder="<?php esc_attr_e('Enter Your Gmap Access Token', 'easy-elementor-addons'); ?>" value="<?php echo esc_attr($gmap_access_token); ?>">
                        </div>
                        <div class="eead-desc">
                            <?php esc_html_e('Tutorial to create ', 'easy-elementor-addons'); ?> <a target="_blank" href="https://hashthemes.com/articles/create-a-google-maps-api-key/" target="_blank"><?php esc_html_e('Google Map Access Token', 'easy-elementor-addons'); ?></a>
                        </div>
                    </div>

                    <div class="eead-settings-field">
                        <label><?php esc_html_e('Weather API Key', 'easy-elementor-addons') ?></label>
                        <div class="eead-settings-input-field">
                            <input type="text" name="weather_api_key" placeholder="<?php esc_attr_e('Enter Your API Key', 'easy-elementor-addons'); ?>" value="<?php echo esc_attr($weather_api_key); ?>">
                        </div>
                        <div class="eead-desc">
                            <?php esc_html_e('To get the api key click', 'easy-elementor-addons') ?> <a target="_blank" href="https://weatherstack.com/quickstart" target="_blank"><?php esc_html_e('here', 'easy-elementor-addons'); ?></a>
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
            <h3><?php esc_html_e('Description', 'easy-elementor-addons'); ?></h3>
            <p><?php esc_html_e('Easy Elementor Addons is an all in one element pack extension for Elementor page builder. It provides 50+ creative widgets to provide an outstanding look to your Elementor based WordPress website. The elements are multi concept and contain amazing features to make your website more effective by placing the spectacular widgets and enhance the engagement rate.', 'easy-elementor-addons'); ?></p>

            <p><?php esc_html_e('Easy Elementor Addons is a highly editable addon for Elementor with limitless possibilities. You can easily customize each element as per your preference and build a beautiful website beyond your imagination. The plugin has an intuitive UI where you can easily drag drop any elements of your choice and start the configuration. Also, you can follow the drag and drop process to reorder or shuffle any elements.', 'easy-elementor-addons'); ?></p>

            <p><?php esc_html_e('Easy Elementor Addons is built using all the modern trends and is well optimized with speed and SEO. So, you can be assured that the extension won’t make any impact on the SEO or the speed of your WordPress website.', 'easy-elementor-addons'); ?></p>

            <p><a href="https://demo.hashthemes.com/easy-elementor-addons/" target="_blank"><?php esc_html_e('See Demos of All Elementor Widgets', 'easy-elementor-addons'); ?></a></p>

            <h3><?php esc_html_e('Elements Available in the Extension:', 'easy-elementor-addons'); ?></h3>

            <?php
            $description = eead_get_all_widgets_desc();
            $count = 0;
            foreach ($eead_all_widgets as $key => $val) {
                $count++;
                ?>
                <p><?php echo esc_html($count); ?>) <a href="https://demo.hashthemes.com/easy-elementor-addons/<?php echo esc_attr($key); ?>/" target="_blank"><?php echo esc_html($val['name']); ?></a> - <?php echo isset($description[$key]) ? esc_html($description[$key]) : ''; ?></p>
                <?php
            }
            ?>

            <p><?php esc_html_e('More Coming', 'easy-elementor-addons'); ?></p>

            <h3><?php esc_html_e('Compatibility:', 'easy-elementor-addons'); ?></h3>
            <p><?php esc_html_e('Easy Elementor Addons is compatible with all types of free and premium WordPress themes. The only thing is that you will need to install Elementor Plugin.', 'easy-elementor-addons'); ?></p>

            <h3><?php esc_html_e('Support:', 'easy-elementor-addons'); ?></h3>
            <p><?php esc_html_e('If you have any issues while using our plugin, feel free to contact us for support. Our support team will be more than happy to help you resolve your issue. You can chat with us or email us at our website', 'easy-elementor-addons'); ?> <a href="https://hashthemes.com/" target="_blank"><?php esc_html_e('here', 'easy-elementor-addons'); ?></a>.</p>

            <p style="height:40px;"></p>
        </div>

        <div class="eead-admin-notificn" style="display: none;"></div>
    </div>
</div>