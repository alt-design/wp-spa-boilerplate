<?php

class AltAdminBranding
{

    function __construct()
    {

        /**
         * Login functionality
         */
        add_action('login_enqueue_scripts', array($this, 'altLoginStyles'), 10);
        add_filter('login_headerurl', array($this, 'altLoginLogoUrl'));
        add_filter('login_errors', array($this, 'altFailedLogin'));

        /**
         * General functionality
         */
        add_action('admin_init', array($this, 'altAddColorScheme'));
        add_action('admin_enqueue_scripts', array($this, 'altAdminStyles'));

        /**
         * Dashboard functionality
         */
        add_filter('screen_layout_columns', array($this, 'altScreenLayoutColumns'));
        add_filter('get_user_option_screen_layout_dashboard', array($this, 'altScreenLayoutDashboard'));

        /**
         * Admin bar branding
         */
        add_action('wp_before_admin_bar_render', array($this, 'altRemoveWpLogo'), 0);
        add_filter('admin_bar_menu', array($this, 'altReplaceHowdy'), 25);

        /**
         * Footer branding
         */
        add_filter('admin_footer_text', array($this, 'altCustomAdminFooter'));
        add_filter('update_footer', array($this, 'altChangeFooterVersion'), 9999);

    }

    /**
     * Custom login styles
     */
    function altLoginStyles()
    {
        wp_enqueue_style('alt-admin-login', get_template_directory_uri() . '/lib/alt-admin/css/admin-login.css', false);
    }

    /**
     * Custom login logo link url
     */
    function altLoginLogoUrl()
    {
        return 'http://www.alt-design.net/';
    }

    /**
     * Change login failed message
     */
    function altFailedLogin()
    {
        return 'The login information you have entered is incorrect.';
    }

    /**
     * Add Alt Design colour scheme
     */
    function altAddColorScheme()
    {
        wp_admin_css_color(
            'alt-design',
            __('Alt Design', 'alt-design-color-scheme'),
            get_template_directory_uri() . '/lib/alt-admin/css/admin-color-scheme.css',
            array('#25282b', '#363b3f', '#ff6600', '#ff6600')
        );
    }

    /**
     * Register custom styles & javascripts
     */
    function altAdminStyles()
    {
        global $wp_styles;

        wp_enqueue_style('alt-admin-footer', get_template_directory_uri() . '/lib/alt-admin/css/admin-footer.css');

        $color_scheme = get_user_option('admin_color');

        if ( 'alt-design' === $color_scheme || in_array(get_current_screen()->base, array('profile', 'profile-network')) ) {
            $wp_styles->registered['colors']->deps[] = 'colors-fresh';
        }
    }

    /**
     * Single column dashboard
     */
    function altScreenLayoutColumns($columns)
    {
        $columns['dashboard'] = 1;
        return $columns;
    }

    function altScreenLayoutDashboard()
    {
        return 1;
    }

    /**
     * Remove WordPress logo from admin bar
     */
    function altRemoveWpLogo()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }

    /**
     * Replace 'Howdy' message.
     */
    function altReplaceHowdy($wp_admin_bar)
    {
        $my_account = $wp_admin_bar->get_node('my-account');
        $newtitle = str_replace('How are you,', 'Ay&apos;up', $my_account->title);
        $wp_admin_bar->add_node(array(
            'id' => 'my-account',
            'title' => $newtitle,
        ));
    }

    /**
     * Custom admin footer
     */
    function altCustomAdminFooter()
    {
        echo '<strong>' . get_bloginfo('name') . ', </strong>a site by <a style="color:#f60" href="http://www.alt-design.net/" title="Alt Design" target="_blank">Alt</a>';
    }

    /**
     * Custom admin footer version
     */
    function altChangeFooterVersion()
    {
        return '<a href="http://alt-design.net" target="_blank" class="alt-footer-logo">Alt</a>';
    }

}

new AltAdminBranding();