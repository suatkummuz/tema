<?php
global $wpdb;

$_details = wp_get_theme('torofilm');

#Version
define('TOROFILM_VERSION',  $_details['Version']);
$dir_path = (substr(get_template_directory(),     -1) === '/') ? get_template_directory()     : get_template_directory()     . '/';
$dir_uri  = (substr(get_template_directory_uri(), -1) === '/') ? get_template_directory_uri() : get_template_directory_uri() . '/';
define('TOROFILM_DIR_PATH', $dir_path);
define('TOROFILM_DIR_URI',  $dir_uri);
#Toroplay Origin
define('TR_GRABBER_MOVIES', 1); // Activate module movies
define('TR_GRABBER_SERIES', 1); // Activate module series
define('TR_MINIFY', true);

#Clase General
function activate_torofilm()
{
    require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-activator.php';
    TOROFILM_Activator::activate();
}
add_action('after_switch_theme', 'activate_torofilm');
require_once TOROFILM_DIR_PATH . 'includes/class-torofilm-master.php';
function run_torofilm_master()
{
    $bcpg_master = new TOROFILM_Master;
    $bcpg_master->run();
}
run_torofilm_master();
function add_menuclass($ulclass)
{
    $a = 'How are you?';
    if (strpos($ulclass, 'dfx fwp jst-cr') !== false) {
        return preg_replace('/<a/', '<a class="btn lin sm rnd light"', $ulclass, -1);
    } else {
        return $ulclass;
    }
}
add_filter('wp_nav_menu', 'add_menuclass');
add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_category() or is_tax()) {
            $query->set('post_type', array('movies', 'series'));
        }
        if ($query->is_search()) {
            $query->set('post_type', array('movies', 'series'));
        }
    }
});
function pagination12($prev = 'PREV', $next = 'NEXT')
{
    $categories = wp_count_terms('episodes');
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('paged', '%#%'),
        'format' => '',
        'total' => ceil($categories / 60),
        'current' => $current,
        'prev_text' => $prev,
        'next_text' => $next,
        'type' => 'plain'
    );
    if ($wp_rewrite->using_permalinks())
        $pagination['base'] = user_trailingslashit(trailingslashit(remove_query_arg('s', get_pagenum_link(1))) . 'page/%#%/', 'paged');
    if (!empty($wp_query->query_vars['s']))
        $pagination['add_args'] = array('s' => get_query_var('s'));
    echo paginate_links($pagination);
};
load_theme_textdomain('torofilm', get_template_directory() . '/languages');
if (!isset($content_width)) $content_width = 900;
add_action('after_switch_theme', 'flush_rewrite_rules');


function lang_torofilm($text, $id_text)
{
	$text_database = get_option($id_text);
	if ($text_database) {
		$text = $text_database;
	} else {
		$text = __($text, 'torofilm');
	}
	return $text;
}