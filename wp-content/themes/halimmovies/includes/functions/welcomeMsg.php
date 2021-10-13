<?php

/**
 * Custom welcome panel function
 *
 * @access      public
 * @since       1.0
 * @return      void
 */
function halim_wp_welcome_panel()
{ ?>
    <div class="welcome-panel-content halim-rssfeed">
        <h2><?php _e('Welcome to HaLimMovie!'); ?></h2>
        <p class="about-description"><?php _e('We’ve assembled some links to get you started', 'halimthemes'); ?></p>
        <div class="welcome-panel-column-container">
            <div class="welcome-panel-column">
                <h4><?php _e('Get Started'); ?></h4>
                <?php printf( '<a href="%s" class="button button-primary button-hero load-customize hide-if-no-customize">' . __( 'Customize Your Site' ) . '</a>', admin_url( 'admin.php?page=halim_options' ) ); ?>
                <h4><?php _e( 'Next Steps'); ?></h4>
                <ul>
                    <li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Add a new movie', 'halimthemes' ) . '</a>', admin_url( 'post-new.php' ) ); ?></li>
                    <li><?php printf( '<a href="%s" class="welcome-icon welcome-add-page">' . __( 'Add additional pages' ) . '</a>', admin_url( 'post-new.php?post_type=page' ) ); ?></li>
                    <li><div class="welcome-icon welcome-widgets-menus"><?php _e( 'Manage', 'halimthemes' ); ?> <?php printf( '<a href="%s">' . __( 'widgets' ) . '</a>', admin_url( 'widgets.php' ) ); ?> <?php _e( 'or', 'halimthemes' ); ?> <?php printf( '<a href="%s">' . __( 'menus' ) . '</a>', admin_url( 'nav-menus.php' ) ); ?></div></li>
                    <li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site" target="_blank">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?></li>
                </ul>
            </div>
            <div class="welcome-panel-column rssfeed">
                <div id="halim-changelogs-ajax">Loading...</div>
                <a class="more-change-logs" href="https://halimthemes.com/items/halimmovies-pro/" target="_blank"><?php _e('See full changelogs', 'halimthemes'); ?></a>
            </div>
        </div>
    </div>
<?php
}

remove_action( 'welcome_panel', 'wp_welcome_panel' );
add_action( 'welcome_panel', 'halim_wp_welcome_panel' );

function halim_welcome_init() {
    global $wpdb;
    $wpdb->update($wpdb->usermeta, array('meta_value' => 1), array('meta_key' => 'show_welcome_panel'));
}
add_action('admin_init','halim_welcome_init');
add_action('after_switch_theme','halim_welcome_init');


add_action( 'admin_enqueue_scripts', 'halimmovies_pointer_header' );
function halimmovies_pointer_header() {
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'halimmovie_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'halimmovies_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }
}

function halimmovies_pointer_footer() {
    $pointer_content = '<h3>'.__('Awesomeness!', 'halimthemes').'</h3>';
    $pointer_content .= '<p>'.__('You have just Installed HaLimMovie WordPress Theme by HaLimThemes.', 'halimthemes').'</p>';
	$pointer_content .= '<p>'.__('You can Trigger The Awesomeness using Amazing Option Panel in <b>Theme Options</b>.', 'halimthemes').'</p>';
    $pointer_content .= '<p>'.__('If you face any problem, head over to', 'halimthemes').' <a href="http://halimthemes.com/docs" target="_blank">'.__('Knowledge Base', 'halimthemes').'</a></p>';
?>
    <script>
    // <![CDATA[
        jQuery(document).ready(function($) {
            $('#menu-appearance').pointer({
                content: '<?php echo $pointer_content; ?>',
                position: {
                    edge: 'left',
                    align: 'center'
                },
                close: function() {
                    $.post( ajaxurl, {
                        pointer: 'halimmovie_pointer',
                        action: 'dismiss-wp-pointer'
                    });
                }
            }).pointer('open');
        });
    // ]]>
    </script>
<?php
}