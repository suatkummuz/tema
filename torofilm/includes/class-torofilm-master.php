<?php class TOROFILM_Master
{
    protected $cargador;
    protected $theme_name;
    protected $version;
    public function __construct()
    {
        $this->theme_name = 'TOROFILM_Theme';
        $this->version = TOROFILM_VERSION;
        $this->cargar_dependencias();
        $this->cargar_instancias();
        $this->definir_admin_hooks();
        $this->definir_public_hooks();
    }
    private function cargar_dependencias()
    {
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-cargador.php';
        require_once TOROFILM_DIR_PATH . 'admin/class-torofilm-admin.php';
        require_once TOROFILM_DIR_PATH . 'public/class-torofilm-public.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_single.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_page.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_footer.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_header.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_home.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_series.php';
        require_once TOROFILM_DIR_PATH . 'public/partials/do_action/do_action_episodes.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-ajax-pubic.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-ajax-admin.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-add-theme-support.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-sidebar.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_popular.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_alphabet.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_annee.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_list_movies_series.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_list_episodes.php';
        require_once TOROFILM_DIR_PATH . 'includes/widgets/torofilm_widget_news.php';
        require_once TOROFILM_DIR_PATH . 'includes/torofilm-functions.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-movies.php';
        require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-posts.php';
        require_once TOROFILM_DIR_PATH . 'includes/customizer.php';
        require_once TOROFILM_DIR_PATH . 'admin/customizer/class-torofilm-color.php';
    }
    private function cargar_instancias()
    {
        $this->cargador                   = new TOROFILM_Cargador;
        $this->torofilm_admin             = new TOROFILM_Admin($this->get_theme_name(), $this->get_version());
        $this->torofilm_public            = new TOROFILM_Public($this->get_theme_name(), $this->get_version());
        $this->torofilm_public_ajax       = new TOROFILM_public_ajax;
        $this->torofilm_admin_ajax        = new TOROFILM_admin_ajax;
        $this->torofilm_add_theme_support = new TOROFILM_Add_Theme_Support;
        $this->torofilm_sidebar            = new TOROFILM_Sidebar;
    }
    private function definir_admin_hooks()
    {

        $this->cargador->add_action('admin_enqueue_scripts', $this->torofilm_admin, 'enqueue_styles');
        $this->cargador->add_action('admin_enqueue_scripts', $this->torofilm_admin, 'enqueue_scripts');
        $this->cargador->add_action('init', $this->torofilm_admin, 'torofilm_register_menus');
        $this->cargador->add_action('init', $this->torofilm_sidebar, 'create_sidebar_principal');
        /*FUNCIONES INICIALES*/
        $this->cargador->add_action('after_setup_theme', $this->torofilm_add_theme_support, 'torofilm_add_support');
        $this->cargador->add_action('after_setup_theme', $this->torofilm_add_theme_support, 'torofilm_remove_elements_wordpress');
        $this->cargador->add_action('wp_enqueue_scripts', $this->torofilm_add_theme_support, 'torofilm_remove_gutemberg');

        $positionAnalityc = get_option( 'analityc_position', false );
        if(!$positionAnalityc) $positionAnalityc = 'header';

        if($positionAnalityc == 'header') {
            $this->cargador->add_action('wp_head', $this->torofilm_add_theme_support, 'code_analityc');
        } else {
            $this->cargador->add_action('wp_footer', $this->torofilm_add_theme_support, 'code_analityc');
        }

    }
    private function definir_public_hooks()
    {
        /*Load Styles*/
        $this->cargador->add_action('wp_enqueue_scripts', $this->torofilm_public, 'enqueue_styles');
        $this->cargador->add_action('wp_footer', $this->torofilm_public, 'enqueue_scripts');
        /*Buscador sugerido*/
        $this->cargador->add_action('wp_ajax_nopriv_action_tr_search_suggest', $this->torofilm_public_ajax, 'tr_search_suggest');
        $this->cargador->add_action('wp_ajax_action_tr_search_suggest', $this->torofilm_public_ajax, 'tr_search_suggest');
        $this->cargador->add_action('wp_ajax_nopriv_action_tr_search_suggest_h', $this->torofilm_public_ajax, 'tr_search_suggest_h');
        $this->cargador->add_action('wp_ajax_action_tr_search_suggest_h', $this->torofilm_public_ajax, 'tr_search_suggest_h');
        $this->cargador->add_action('wp_ajax_nopriv_action_tr_movie_category', $this->torofilm_public_ajax, 'tr_movie_category');
        $this->cargador->add_action('wp_ajax_action_tr_movie_category', $this->torofilm_public_ajax, 'tr_movie_category');
        #Login and Register
        $this->cargador->add_action('wp_ajax_nopriv_action_peli_login_header', $this->torofilm_public_ajax, 'peli_login_header');
        $this->cargador->add_action('wp_ajax_action_peli_login_header', $this->torofilm_public_ajax, 'peli_login_header');
        $this->cargador->add_action('wp_ajax_nopriv_action_peli_register_header', $this->torofilm_public_ajax, 'peli_register_header');
        $this->cargador->add_action('wp_ajax_action_peli_register_header', $this->torofilm_public_ajax, 'peli_register_header');
        $this->cargador->add_action('wp_ajax_action_editor_user_perfil', $this->torofilm_public_ajax, 'editor_user_perfil');
        $this->cargador->add_action('wp_ajax_action_add_favorito', $this->torofilm_public_ajax, 'peli_add_favorito');
        $this->cargador->add_action('wp_ajax_action_add_favorito_s', $this->torofilm_public_ajax, 'peli_add_favorito_s');
        /*EPISODES BY TEMPORATE*/
        $this->cargador->add_action('wp_ajax_nopriv_action_select_season', $this->torofilm_public_ajax, 'select_season');
        $this->cargador->add_action('wp_ajax_action_select_season', $this->torofilm_public_ajax, 'select_season');
    }
    public function run()
    {
        $this->cargador->run();
    }
    public function get_theme_name()
    {
        return $this->theme_name;
    }
    public function get_cargador()
    {
        return $this->cargador;
    }
    public function get_version()
    {
        return $this->version;
    }
}
