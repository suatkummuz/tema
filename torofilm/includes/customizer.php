<?php
require_once TOROFILM_DIR_PATH . 'admin/customizer/class-torofilm-multiple-checkbox.php';
require_once TOROFILM_DIR_PATH . 'includes/customizer/customizer-heading.php';

function my_customize_register($wp_customize)
{
    function theme_slug_sanitize_select($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
    function sanitize_multiple_checkbox($values)
    {
        $multi_values = !is_array($values) ? explode(',', $values) : $values;
        return !empty($multi_values) ? array_map('sanitize_text_field', $multi_values) : array();
    }
    function theme_slug_sanitize_checkbox($input)
    {
        return ((isset($input) && true == $input) ? true : false);
    }
    function theme_slug_sanitize_radio($input, $setting)
    {
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control($setting->id)->choices;
        return (array_key_exists($input, $choices) ? $input : $setting->default);
    }
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    /*Generate Menu Toroflix*/
    $wp_customize->add_panel('toroflix_options', array(
        'title' => 'Torofilm',
        'priority' => 30,
        'capability' => 'edit_theme_options',
    ));
        $wp_customize->add_section('header_option', array(
            'title'      => 'Header Option',
            'panel'      => 'toroflix_options',
            'priority'   => 1,
            'capability' => 'edit_theme_options',
        ));
            $wp_customize->add_setting('header_sticky', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('header_sticky', array(
                'label'    => 'Enabled Sticky Header',
                'section'  => 'header_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
            #Slider Checkbox
            $wp_customize->add_setting('header_login', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'theme_slug_sanitize_checkbox',
                'transport'         => 'refresh'
            ));
            $wp_customize->add_control('header_login', array(
                'label'    => 'Enabled Login User',
                'section'  => 'header_option',
                'priority' => 2,
                'type'     => 'checkbox'
            ));
        #Block Home
        $wp_customize->add_section('block_home', array(
            'title' => __('Home', 'torofilm'),
            'panel' => 'toroflix_options',
            'priority' => 1,
            'capability' => 'edit_theme_options',
        ));
    $wp_customize->add_setting('disable_image_header', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_image_header', array(
        'label'    => 'Disable Image on Header',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('setting_image_header', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_header_control', array(
        'label'     => 'Header Image',
        'settings'  => 'setting_image_header',
        'section'   => 'block_home',
        'priority' => 2,
    )));
    //Image Header - hotlink 
    $wp_customize->add_setting('setting_image_header_hotlink', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('setting_image_header_hotlink', array(
        'label'    => 'Image Header URL external',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('disable_image_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_image_footer', array(
        'label'    => 'Disble Image on Footer',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('setting_image_footer', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'image_footer_control', array(
        'label'     => 'Footer Image',
        'settings'  => 'setting_image_footer',
        'section'   => 'block_home',
        'priority' => 2,
    )));
    //Image Footer - hotlink 
    $wp_customize->add_setting('setting_image_footer_hotlink', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('setting_image_footer_hotlink', array(
        'label'    => 'Image Footer URL external',
        'section'  => 'block_home',
        'priority' => 2,
        'type'     => 'text',
    ));
    #MOVIES
    $wp_customize->add_section('section_movies', array(
        'title' => 'Movies',
        'panel' => 'toroflix_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));

        /* Sizes Images header */
        $wp_customize->add_setting('size_image_header_movies', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_header_movies', array(
            'label'    => 'Size of image on header (by default is high)',
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
        $wp_customize->add_setting('size_image_footer_movies', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_footer_movies', array(
            'label'    => 'Size of image on footer (by default is high)',
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));


        $wp_customize->add_setting('disable_movies_social', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_checkbox',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('disable_movies_social', array(
            'label'    => 'Disabled social share',
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'checkbox'
        ));


        /* related movies */
        $wp_customize->add_setting('heading_related_movies');
        $wp_customize->add_control(new Heading_Customizer($wp_customize, 
            'heading_related_movies', array(
                'settings' => 'heading_related_movies',
                'section'  => 'section_movies',
                'label'    => __( 'Related movies', 'torofilm' ),
                'priority' => 2,
            )
        ));

        $wp_customize->add_setting( 'disable_related_movies', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        ));
        $wp_customize->add_control('disable_related_movies', array(
            'label' => __( 'Disable related movies', 'torofilm' ),
            'section' => 'section_movies',
            'priority' => 2,
            'type' => 'checkbox'
        ));

        $wp_customize->add_setting( 'title_related_movies', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('title_related_movies', array(
            'label'    => __( 'Title', 'torofilm' ),
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'related_movies_number', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('related_movies_number', array(
            'label'    => __( 'Number items', 'torofilm' ),
            'section'  => 'section_movies',
            'priority' => 2,
            'type'     => 'text'
        ));

       
    #SERIES
    $wp_customize->add_section('section_series', array(
        'title'      => 'Series',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
        /* Sizes Images header */
        $wp_customize->add_setting('size_image_header_series', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_header_series', array(
            'label'    => 'Size of image on header (by default is high)',
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));
        $wp_customize->add_setting('size_image_footer_series', array(
            'type'              => 'option',
            'default'           => 'right',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('size_image_footer_series', array(
            'label'    => 'Size of image on footer (by default is high)',
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'select',
            'choices'  => array(
                'thumbnail' => 'Low',
                'medium'    => 'Medium',
                'original'  => 'High',
                'none'      => 'None',
            )
        ));

        $wp_customize->add_setting('disable_series_social', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_checkbox',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('disable_series_social', array(
            'label'    => 'Disabled social share',
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'checkbox'
        ));

        /* related series */
        $wp_customize->add_setting('heading_related_series');
        $wp_customize->add_control(new Heading_Customizer($wp_customize, 
            'heading_related_series', array(
                'settings' => 'heading_related_series',
                'section'  => 'section_series',
                'label'    => __( 'Related series', 'torofilm' ),
                'priority' => 2,
            )
        ));

        $wp_customize->add_setting( 'disable_related_series', array(
            'type' => 'option',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_checkbox'
        ));
        $wp_customize->add_control('disable_related_series', array(
            'label' => __( 'Disable related series', 'torofilm' ),
            'section' => 'section_series',
            'priority' => 2,
            'type' => 'checkbox'
        ));

        $wp_customize->add_setting( 'title_related_series', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('title_related_series', array(
            'label'    => __( 'Title', 'torofilm' ),
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'related_series_number', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('related_series_number', array(
            'label'    => __( 'Number items', 'torofilm' ),
            'section'  => 'section_series',
            'priority' => 2,
            'type'     => 'text'
        ));
        
    #EPISODES
    $wp_customize->add_section('section_episodes', array(
        'title'      => 'Episodes',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    #Related Activation
    $wp_customize->add_setting('disable_related_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_related_episodes', array(
        'label'    => 'Disabled Related',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('disable_thumbs_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_thumbs_episodes', array(
        'label'    => 'Disabled Thumbs',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('title_related_episodes', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('title_related_episodes', array(
        'label'    => 'Title of Section',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('related_episodes_number', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint'
    ));
    $wp_customize->add_control('related_episodes_number', array(
        'label'    => 'Number Items',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'number',
    ));

    $wp_customize->add_setting('disable_episodes_share', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('disable_episodes_share', array(
        'label'    => 'Disabled social share',
        'section'  => 'section_episodes',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    #Player
    $wp_customize->add_section('player_toroflix', array(
        'title'      => 'Player',
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));

    $wp_customize->add_setting( 'enable_tab_lang', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('enable_tab_lang', array(
        'label'    => __( 'Enable tabs by language' ),
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));


    $wp_customize->add_setting('player_encrypt', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_encrypt', array(
        'label'    => 'Disabled Player Encrypt',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_advertising', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_advertising', array(
        'label'    => 'Disabled Player Advertising',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_fake', array(
        'label'    => 'Disabled Player Fake',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake_blank', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_checkbox',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('player_fake_blank', array(
        'label'    => 'Disabled Player Fake blank',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'checkbox'
    ));
    $wp_customize->add_setting('player_fake_url', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('player_fake_url', array(
        'label'    => 'Player Fake url',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('player_advertising_code', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
    ));
    $wp_customize->add_control('player_advertising_code', array(
        'label'    => 'Advertising code',
        'section'  => 'player_toroflix',
        'priority' => 2,
        'type'     => 'textarea',
    ));
    #Sidebar
    $wp_customize->add_section('sidebar_toroflix', array(
        'title' => 'Sidebar',
        'panel' => 'toroflix_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));
    #Slider Type
    $wp_customize->add_setting('sidebar_type', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type', array(
        'label'    => 'Sidebar Home',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_setting('sidebar_type_movies_series', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type_movies_series', array(
        'label'    => 'Sidebar Movies and Series',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_setting('sidebar_type_category', array(
        'type'              => 'option',
        'default'           => 'right',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'theme_slug_sanitize_select',
        'transport'         => 'refresh'
    ));
    $wp_customize->add_control('sidebar_type_category', array(
        'label'    => 'Sidebar Category',
        'section'  => 'sidebar_toroflix',
        'priority' => 2,
        'type'     => 'select',
        'choices'  => array(
            'side-right' => 'Right',
            'side-left'  => 'Left',
            'side-none'  => 'Hide',
        )
    ));
    $wp_customize->add_section('poster_option', array(
        'title'      => __('Poster Option', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    $wp_customize->add_setting('poster_option_views', array(
        'type'              => 'option',
        'default'           => array('popular', 'movies', 'series', 'season', 'episode'),
        'sanitize_callback' => 'sanitize_multiple_checkbox',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control(new TOROFLIX_multiple_checbox($wp_customize, 'poster_option_views', array(
        'label'       => __('Poster Option View', 'torofilm'),
        'description' => __('Select options to show in poster of series and movies', 'torofilm'),
        'section'     => 'poster_option',
        'choices'     => array(
            'year' => 'Year',
            'lang' => 'Language',
            'qual' => 'Quality',
        ),
        'priority' => 2,
    )));

    /* ADS SECTION */
    $wp_customize->add_section('ads_section', array(
        'title'      => __('ADS', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));

        $wp_customize->add_setting('ads_top_player', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options'
        ));
        $wp_customize->add_control('ads_top_player', array(
            'label'    => __('Top player', 'torofilm'),
            'section'  => 'ads_section',
            'priority' => 2,
            'type'     => 'textarea',
        ));

        $wp_customize->add_setting('ads_bottom_player', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('ads_bottom_player', array(
            'label'    => __('Bottom player', 'torofilm'),
            'section'  => 'ads_section',
            'priority' => 2,
            'type'     => 'textarea',
        ));

    #Footer
    $wp_customize->add_section('footer_section', array(
        'title'      => __('Footer', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
    #Footer Text
    $wp_customize->add_setting('text_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('text_footer', array(
        'label'    => __('Text', 'torofilm'),
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('text_footer', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('text_footer', array(
        'label'    => __('Text', 'torofilm'),
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_facebook', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_facebook', array(
        'label'    => 'Social Facebook',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_twitter', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_twitter', array(
        'label'    => 'Social Twitter',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('social_instagram', array(
        'type'              => 'option',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control('social_instagram', array(
        'label'    => 'Social Instagram',
        'section'  => 'footer_section',
        'priority' => 2,
        'type'     => 'text',
    ));
    $wp_customize->add_setting('logo_footer', array(
        //default value
        'capability'        => 'edit_theme_options',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_footer_control', array(
        'label'     => 'Logo Footer',
        'settings'  => 'logo_footer',
        'section'   => 'footer_section',
        'priority' => 2,
    )));
    #Analityc Section 
    $wp_customize->add_section('section_analityc', array(
        'title'      => __('Analityc', 'torofilm'),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));
        $wp_customize->add_setting('analityc_code', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
        ));
        $wp_customize->add_control('analityc_code', array(
            'label'    => __('Analityc code', 'torofilm'),
            'section'  => 'section_analityc',
            'priority' => 2,
            'type'     => 'textarea',
        ));
        $wp_customize->add_setting('analityc_position', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_select'
        ));
        $wp_customize->add_control('analityc_position', array(
            'label'       => __('Analityc position', 'torofilm'),
            'section'     => 'section_analityc',
            'priority'    => 2,
            'type'        => 'select',
            'description' => 'By default is header',
            'choices'     => array(
                'header' => 'Header',
                'footer' => 'Footer',
            )
        ));

    $wp_customize->add_section( 'section_comment' , array(
        'title'      => __( 'Comments', 'torofilm' ),
        'panel'      => 'toroflix_options',
        'priority'   => 1,
        'capability' => 'edit_theme_options',
    ));

        /* DISQUS comment */
        $wp_customize->add_setting('enable_disqus', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'theme_slug_sanitize_checkbox',
            'transport'         => 'refresh'
        ));
        $wp_customize->add_control('enable_disqus', array(
            'label'    => 'Enabled Disqus',
            'section'  => 'section_comment',
            'priority' => 2,
            'type'     => 'checkbox'
        ));

        $wp_customize->add_setting('disqus_code', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
        ));
        $wp_customize->add_control('disqus_code', array(
            'label'    => __('Disqus code', 'torofilm'),
            'section'  => 'section_comment',
            'priority' => 2,
            'type'     => 'textarea',
        ));
    
    $wp_customize->add_section( 'section_language' , array(
        'title' => __( 'Language', 'torofilm' ),
        'panel' => 'toroflix_options',
        'priority' => 1,
        'capability' => 'edit_theme_options',
    ));

        $wp_customize->add_setting( 'txt_options', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_options', array(
            'label'    => __( 'OPTIONS', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        $wp_customize->add_setting( 'txt_option', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_option', array(
            'label'    => __( 'OPTION', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        $wp_customize->add_setting( 'txt_search', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_search', array(
            'label'    => __( 'Search', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_previous', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_previous', array(
            'label'    => __( 'Previous', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_next', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_next', array(
            'label'    => __( 'Next', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_seasons', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_seasons', array(
            'label'    => __( 'Seasons', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));


        $wp_customize->add_setting( 'txt_oops', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_oops', array(
            'label'    => __( 'Oops!...', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_the_page_you_are_looking', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_the_page_you_are_looking', array(
            'label'    => __( 'The page you are looking for does not exist...', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_back_to_home', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_back_to_home', array(
            'label'    => __( 'Back to Home', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_movies', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_movies', array(
            'label'    => __( 'Movies', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_series', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_series', array(
            'label'    => __( 'Series', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_episodes', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_episodes', array(
            'label'    => __( 'Episodes', 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_you_havent_written', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_you_havent_written', array(
            'label'    => __( "You haven't written anything about yourself", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_favorites', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_favorites', array(
            'label'    => __( "Favorites", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_settings', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_settings', array(
            'label'    => __( "Settings", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_favorites_movies', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_favorites_movies', array(
            'label'    => __( "Favorites Movies", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_favorites_episodes', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_favorites_episodes', array(
            'label'    => __( "Favorites Episodes", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));
        
        $wp_customize->add_setting( 'txt_favorites_series', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_favorites_series', array(
            'label'    => __( "Favorites Series", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_no_results', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_no_results', array(
            'label'    => __( "No results", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_edit_profile', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_edit_profile', array(
            'label'    => __( "Edit profile", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_country', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_country', array(
            'label'    => __( "Country", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_select_your_country', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_select_your_country', array(
            'label'    => __( "Select your country", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_date_of_birth', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_date_of_birth', array(
            'label'    => __( "Date of birth", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_about_you', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_about_you', array(
            'label'    => __( "About you", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_save_changes', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_save_changes', array(
            'label'    => __( "Save Changes", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_change_password', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_change_password', array(
            'label'    => __( "Change password", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_current_password', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_current_password', array(
            'label'    => __( "Current password", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_new_password', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_new_password', array(
            'label'    => __( "New password", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_repeat_password', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_repeat_password', array(
            'label'    => __( "Repeat password", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

        $wp_customize->add_setting( 'txt_update_password', array(
            'type'              => 'option',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
        ));
        $wp_customize->add_control('txt_update_password', array(
            'label'    => __( "Update password", 'torofilm' ),
            'section'  => 'section_language',
            'priority' => 2,
            'type'     => 'text'
        ));

}
add_action('customize_register', 'my_customize_register');
