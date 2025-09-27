<?php
class TOROFILM_Public
{
    private $theme_name;
    private $version;
    private $helpers;
    public function __construct($theme_name, $version)
    {
        $this->theme_name = $theme_name;
        $this->version    = $version;
    }
    public function enqueue_styles()
    {
        wp_enqueue_style(
            $this->theme_name, 
            TOROFILM_DIR_URI . 'public/css/torofilm-public.css', 
            null, 
            filemtime( TOROFILM_DIR_PATH . 'public/css/torofilm-public.css' ),
            'all'
        );
        
        if (is_author()) {
            wp_enqueue_style(
                'countries_css_public',
                TOROFILM_DIR_URI . 'helpers/countries/css/countrySelect.css',
                null,
                filemtime(TOROFILM_DIR_PATH . 'helpers/countries/css/countrySelect.css'),
                'all'
            );
        }
    }
    public function enqueue_scripts()
    {
        wp_enqueue_script('funciones_public_jquery', TOROFILM_DIR_URI . 'public/js/jquery.js',  array(), filemtime( TOROFILM_DIR_PATH . 'public/js/jquery.js' ), true);
        wp_enqueue_script('owl_carousel', TOROFILM_DIR_URI . 'public/js/owl.carousel.min.js',  array(), filemtime( TOROFILM_DIR_PATH . 'public/js/owl.carousel.min.js' ), true);
        #Comments
        if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply', 'wp-includes/js/comment-reply', array(), false, true);
        }
        if (is_author()) {
            wp_enqueue_script('countries_js_public', TOROFILM_DIR_URI . 'helpers/countries/js/countrySelect.js',  array(), filemtime( TOROFILM_DIR_PATH . 'helpers/countries/js/countrySelect.js' ), true);
        }

        $trailer = false;
        if(is_singular()){
            global $post;
            $id_ms = $post->ID;
            $trailer = mb_convert_encoding(get_post_meta($id_ms, 'field_trailer', true), 'UTF-8', 'HTML-ENTITIES');
            $firstCharTrailer = substr($trailer, 0, 1); 

            if( $firstCharTrailer == '[' ){
                if ( strpos($trailer, 'youtube.com/embed') !== false ) {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $trailer = '<iframe width="560" height="315" src="'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                } elseif ( strpos($trailer, 'watch?v=') !== false ) {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $id_nm    = str_replace('watch?v=', 'embed/', $id_nm);
                    $trailer = '<iframe width="560" height="315" src="'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                } else {
                    preg_match_all('/".*?"|\'.*?\'/', $trailer, $matches);
                    $nm       = $matches[0][0];
                    $remove[] = "'";
                    $remove[] = '"';
                    $id_nm    = str_replace($remove, "", $nm);
                    $trailer = '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$id_nm.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                }
            }
        }

        wp_enqueue_script('funciones_public_js', TOROFILM_DIR_URI . 'public/js/torofilm-public.js', array(), $this->version, true);
        #Localize Script
        $torofilm_Public = [
            'url'             => admin_url('admin-ajax.php'),
            'nonce'           => wp_create_nonce('torofilm_seg'),
            'access_error'    => __('Access error', 'torofilm'),
            'remove_favorite' => __('Removed from favorites', 'torofilm'),
            'add_favorite'    => __('Added to favorites', 'torofilm'),
            'saved'           => __('Data saved correctly', 'torofilm'),
            'warning'         => __('Image size must be less than 1MB', 'torofilm'),
            'error_upload'    => __('Upload error', 'torofilm'),
            'trailer'         => $trailer,
        ];
        wp_localize_script('funciones_public_js', 'torofilm_Public', $torofilm_Public);
        #Alternativo
        $translation_array = array('templateUrl' => get_stylesheet_directory_uri());
        wp_localize_script('funciones_public_js', 'object_name', $translation_array);
    }
}
