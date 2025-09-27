<?php


/* TRAILER MODAL*/
if (!function_exists('trailer_single_movies')) {
    function trailer_single_movies($loop)
    {
        global $post;
        $trailer = $loop->trailer($post->ID);
        if ($trailer) { ?>
            <div class="mdl" id="mdl-trailer">
                <div class="mdl-cn anm-b">
                    <div class="video video-trailer">
                    </div>
                    <button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-trailer" type="button"><i class="fa-times"></i></button>
                </div>
                <div class="mdl-ovr aa-mdl" data-mdl="mdl-trailer"></div>
            </div>
        <?php }
    }
}
add_action('single_modal', 'trailer_single_movies', 10);


/* FAVORITE MODAL */
if (!function_exists('favorite_movie_modal')) {
    function favorite_movie_modal($loop)
    { ?>
        <div class="mdl" id="mdl-favorites">
            <div class="mdl-cn anm-b">
            </div>
            <div class="mdl-ovr aa-mdl" data-mdl="mdl-favorites"></div>
        </div>
        <?php }
}
add_action('single_modal', 'favorite_movie_modal', 20);


/* DOWNLOAD LINK MODAL */
if (!function_exists('download_link_movie_modal')) {
    function download_link_movie_modal($loop)
    {
        global $post;
        $links              = $loop->tr_links_movies(get_the_ID());
        $links['downloads'] = !empty($links['downloads']) ? $links['downloads'] : '';
        if ($links['downloads']) { ?>
            <div class="mdl" id="mdl-download">
                <div class="mdl-cn anm-b">
                    <div class="mdl-hd">
                        <div class="mdl-title"><?php _e('Download Links', 'torofilm'); ?></div>
                        <button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-download" type="button"><i class="fa-times"></i></button>
                    </div>
                    <div class="mdl-bd">
                        <div class="download-links">
                            <table>
                                <thead>
                                    <tr>
                                        <th><?php _e('Server', 'torofilm'); ?></th>
                                        <th><?php _e('Lang', 'torofilm'); ?></th>
                                        <th><?php _e('Quality', 'torofilm'); ?></th>
                                        <th><?php _e('Link', 'torofilm'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($links['downloads'] as $key => $download) {
                                        $count = $key + 1;
                                        $count = sprintf("%02d", $count);
                                        if ($download['server']) {
                                            $server_term = get_term($download['server'], 'server');
                                        }
                                        if ($download['lang']) {
                                            $lang_term = get_term($download['lang'], 'language');
                                        }
                                        if ($download['quality']) {
                                            $quality_term = get_term($download['quality'], 'quality');
                                        }  ?>
                                        <tr>
                                            <td><span class="num">#<?php echo $count; ?></span> <?php if (isset($server_term)) {                                                                                                  echo $server_term->name;
                                                                                                } ?></td>
                                            <td><?php if ($download['lang']) {
                                                    echo $lang_term->name;
                                                } else {
                                                    echo '';
                                                } ?></td>
                                            <td><span><?php if ($download['quality']) {
                                                            echo $quality_term->name;
                                                        } else {
                                                            echo 'HD';
                                                        } ?></span></td>
                                            <td><a rel="nofollow" target="_blank" href="<?php echo esc_url(home_url('/?trdownload=' . $download['i'] . '&trid=' . $post->ID));  ?>" class="btn sm rnd blk"><?php _e('Download', 'torofilm'); ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mdl-ovr aa-mdl" data-mdl="mdl-download"></div>
            </div>
        <?php } ?>
    <?php }
}
add_action('single_modal', 'download_link_movie_modal', 30);

/* DATA POST  */
if (!function_exists('single_content_data_post')) {
    function single_content_data_post($loop)
    {
        $id                 = get_the_ID();
        $categories         = $loop->categories();
        $disable_share      = get_option('disable_movies_social');
      
    ?>
        <div class="dfxc">
            <main class="main-site">
                <article class="post single-news">
                    <div class="post-thumbnail">
                        <figure><?php echo tr_theme_img(get_the_ID(), 'large', get_the_title()); ?></figure>
                    </div>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <?php if ($categories) { echo '<span class="genres">'. $categories .'</span>'; } ?>
                            <span class="date"><i class="fa-clock far"></i> <?php echo get_the_date(); ?></span>
                        </div>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                    <?php if($disable_share != 1){ ?>
                        <footer class="dfxa jst-sb alg-cr">
                            <ul class="options rw rfg1 rcl0c">
                                <li class="aa-drp">
                                    <button class="btn lnk npd lnk blk aa-lnk"><i class="fa-share-alt"></i> <span>Share</span></button>
                                    <ul class="aa-cnt sub-menu">
                                        <li class="fa-facebook-f fab"><a href="#" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');">Facebook</a></li>
                                        <li class="fa-twitter fab"><a href="#" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');">Twitter</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </footer>
                    <?php } ?>
                </article>
                <?php comments_template(); ?>
                <?php if (is_front_page() or is_home()) {
                    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-home')) : endif;
                } ?>
            </main>
            <?php get_sidebar(); ?>
        </div>
    <?php }
}
add_action('single_post', 'single_content_data_post', 10);

/* DATA MOVIE */
if (!function_exists('single_content_data_movie')) {
    function single_content_data_movie($loop)
    {
        $links = $loop->tr_links_movies(get_the_ID());
        $links['online'] = !empty($links['online']) ? $links['online'] : '';
        $links['downloads'] = !empty($links['downloads']) ? $links['downloads'] : '';
        $id                 = get_the_ID();
        $image              = $loop->image($id, 'thumbnail');
        $categories         = $loop->categories();
        $duration           = $loop->duration();
        $year               = $loop->year();
        $views              = $loop->views();
        $director           = $loop->director();
        $cast               = $loop->casts();
        $rating             = $loop->rating_term($id);
        $trailer            = $loop->trailer($id);
        $user_id            = get_current_user_id();
        $isFavorito         = get_user_meta($user_id, 'favorito', true);
        $disable_share      = get_option('disable_movies_social');
        $id_post            = $id;
        if ($isFavorito) {
            if (in_array($id_post, $isFavorito)) {
                $statusf = 'favorito';
                $classf = '';
            } else {
                $statusf = 'nofavorito';
                $classf = 'far';
            }
        } else {
            $statusf = 'nofavorito';
            $classf = 'far';
        }   ?>
        <article class="post single">
            <div class="dfxb alg-cr">
                <div class="post-thumbnail alg-ss">
                    <figure><?php echo $image; ?></figure>
                </div>
                <aside class="fg1">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                        <div class="entry-meta">
                            <?php if ($categories) { ?>
                                <span class="genres"><?php echo $categories; ?></span>
                            <?php } ?>

                            <span class="tag fa-tag"><?php echo $loop->get_tags(); ?></span>

                            <?php if ($duration) { ?>
                                <span class="duration fa-clock far"><?php echo $duration; ?></span>
                            <?php } ?>
                            <?php if ($year) { ?>
                                <span class="year fa-calendar far"><?php echo $year; ?></span>
                            <?php } ?>
                            <?php if ($views) { ?>
                                <span class="views fa-eye far"><span><?php echo $views; ?></span> <?php _e('views', 'torofilm'); ?></span>
                            <?php } ?>
                        </div>
                    </header>
                    <div class="description">
                        <?php the_content(); ?>
                    </div>
                    <ul class="cast-lst dfx fwp">
                        <?php if ($director) { ?>
                            <li>
                                <span><?php _e('Director', 'torofilm'); ?></span>
                                <p><?php echo $director; ?></p>
                            </li>
                        <?php }
                        if ($cast) { ?>
                            <li>
                                <span><?php _e('Cast', 'torofilm'); ?></span>
                                <p><?php echo $cast; ?></p>
                            </li>
                        <?php } ?>
                    </ul>
                </aside>
            </div>
            <footer class="dfxa jst-sb alg-cr">
                <div class="vote-cn">
                    <span class="vote fa-star"><span class="num"><?php echo $rating; ?></span><span>TMDB</span></span>
                </div>
                <ul class="options rw rfg1 rcl0c">
                    <?php if ($trailer) { ?>
                        <li><button class="btn lnk npd blk aa-mdl" data-mdl="mdl-trailer"><i class="fa-youtube fab"></i> <span><?php _e('Trailer', 'torofilm'); ?></span></button></li>
                    <?php } ?>
                    <?php if ($links['downloads']) { ?>
                        <li><button class="btn lnk npd blk aa-mdl" data-mdl="mdl-download"><i class="fa-cloud-download-alt"></i> <span><?php _e('Download', 'torofilm'); ?></span></button></li>
                    <?php } ?>
                    <?php if (is_user_logged_in()) { ?>
                        <li><button id="add-to-favorito" data-id="<?php the_ID(); ?>" data-status="<?php echo $statusf; ?>" class="btn lnk npd blk aa-mdl" data-mdl="mdl-favorites"><i class="fa-heart <?php echo $classf; ?>"></i> <span><?php _e('Favorites', 'torofilm'); ?></span></button></li><?php } ?>
                    <?php if($disable_share != 1){ ?>
                        <li class=""><button class="btn lnk npd blk aa-mdl" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-facebook-f fab"></i><span>Facebook</span></button></li>
                        <li><button class="btn lnk npd blk aa-mdl" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-twitter fab"></i><span>Twitter</span></button></li>
                    <?php } ?>
                </ul>
            </footer>
        </article>
        <?php }
}
add_action('single_content', 'single_content_data_movie', 10);



/* PLAYER MOVIE */
if (!function_exists('single_content_player_movie')) {
    function single_content_player_movie($loop)
    {
        global $post;
        $backdrop         = $loop->backdrop_tmdb(get_the_ID(), 'w780');
        $fake             = get_option('player_fake', false);
        $fake_blank       = (bool) !get_option('player_fake_blank', false);
        $fake_url         = get_option('player_fake_url', '');
        $unencrypt        = get_option('player_encrypt', false);
        $advertising      = get_option('player_advertising', false);
        $advertising_code = get_option('player_advertising_code', false);
        $links            = $loop->tr_links_movies(get_the_ID());
        $links['online']  = !empty($links['online']) ? $links['online'] : '';
        $tagiframe        = 'iframe';
        $enable_tab_lang = get_option('enable_tab_lang', false);
        if ($links['online']) {  
            
            /* ADS For player */
            $ads_top    = get_option( 'ads_top_player' );
            $ads_bottom = get_option( 'ads_bottom_player' );
            
            ?>

            <?php if($ads_top){ ?>
                <div class="d-flex-ch j-center">
                    <?php echo $ads_top; ?>
                </div>
            <?php } ?>

            <section class="section player dfxc jst-sb episode">
                <aside class="video-player aa-cn" id="aa-options">
                    <?php foreach ($links['online'] as $key => $online) {
                        if (!$unencrypt) {
                            if ($key == 0) { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd on">
                                    <?php if (!$fake) { ?>
                                        <div class="plyrbg">
                                            <?php echo $backdrop; ?>
                                            <a class="fa-play play-video" id="playback" <?php echo (!empty($fake_url)) ? 'data-href="' . $fake_url . '"' : ''; ?> <?php echo ($fake_blank) ? 'data-target="_blank"' : ''; ?>></a>
                                            <div class="plyr-op">
                                                <span class="plyr-progress"><span><span class="screen-reader-text">10% progress</span></span></span>
                                                <aside>
                                                    <span class="btn"><i class="fa-play"><span class="screen-reader-text">play</span></i></span>
                                                    <span class="btn"><i class="fa-volume-up"><span class="screen-reader-text">volume</span></i></span>
                                                    <span class="btn time" id="playback-time">0:00 / 1:52:20</span>
                                                </aside>
                                                <aside>
                                                    <span class="btn"><i class="fa-cog"><span class="screen-reader-text">settings</span></i></span>
                                                    <span class="btn"><i class="fa-expand"><span class="screen-reader-text">full</span></i></span>
                                                </aside>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (!$advertising) { ?>
                                        <?php echo $advertising_code; ?>
                                    <?php } ?>
                                    <iframe src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $post->ID)) . '&trtype=1';  ?>" data-src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $post->ID)) . '&trtype=1';  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                                </div>
                            <?php } else { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd">
                                    <?php if (!$advertising) { ?>
                                        <?php echo $advertising_code; ?>
                                    <?php } ?>
                                    <iframe data-src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $post->ID)) . '&trtype=1';  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                                </div>
                            <?php }
                        } else {
                            if ($key == 0) { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd on">
                                    <?php if (!$fake) { ?>
                                        <div class="plyrbg">
                                            <?php echo $backdrop; ?>
                                            <a class="fa-play play-video" id="playback" <?php echo (!empty($fake_url)) ? 'data-href="' . $fake_url . '"' : ''; ?> <?php echo ($fake_blank) ? 'data-target="_blank"' : ''; ?>></a>
                                            <div class="plyr-op">
                                                <span class="plyr-progress"><span><span class="screen-reader-text">10% progress</span></span></span>
                                                <aside>
                                                    <span class="btn"><i class="fa-play"><span class="screen-reader-text">play</span></i></span>
                                                    <span class="btn"><i class="fa-volume-up"><span class="screen-reader-text">volume</span></i></span>
                                                    <span class="btn time" id="playback-time">0:00 / 1:52:20</span>
                                                </aside>
                                                <aside>
                                                    <span class="btn"><i class="fa-cog"><span class="screen-reader-text">settings</span></i></span>
                                                    <span class="btn"><i class="fa-expand"><span class="screen-reader-text">full</span></i></span>
                                                </aside>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if (!$advertising) echo $advertising_code;
                                    if (filter_var($online['link'], FILTER_VALIDATE_URL)) { ?>
                                        <<?php echo $tagiframe; ?> src="<?php echo $online['link'];  ?>" data-src="<?php echo $online['link']; ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></<?php echo $tagiframe; ?>>
                                    <?php } else {
                                        preg_match('/src="([^"]+)"/', htmlspecialchars_decode($online['link']), $match);
                                        $urlvideo = $match[1];
                                    ?>
                                        <<?php echo $tagiframe; ?> src="<?php echo $urlvideo; ?>" data-src="<?php echo $urlvideo; ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></<?php echo $tagiframe; ?>>
                                    <?php
                                    } ?>
                                </div>
                            <?php } else { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd altvideo">
                                    <?php if (!$advertising) echo $advertising_code;
                                    if (filter_var($online['link'], FILTER_VALIDATE_URL)) { ?>
                                        <<?php echo $tagiframe; ?> data-src="<?php echo $online['link']; ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></<?php echo $tagiframe; ?>>
                                    <?php } else {
                                        preg_match('/src="([^"]+)"/', htmlspecialchars_decode($online['link']), $match);
                                        $urlvideo = $match[1]; ?>
                                        <<?php echo $tagiframe; ?> data-src="<?php echo $urlvideo; ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></<?php echo $tagiframe; ?>>
                                    <?php
                                    } ?>
                                </div>
                    <?php }
                        }
                    } ?>
                </aside>
                <aside class="video-options">
                    <div class="title hdd shwc"><?php echo lang_torofilm('OPTIONS', 'txt_options'); ?></div>
                    
                    <div class="d-flex-ch">
                        <?php if($enable_tab_lang){  
                            $players_enable = $links['online']; 
                            $lang_pl = array();

                            foreach($players_enable as $k => $player) {
                                if( $player['lang'] && $player['lang']!= '' ){
                                    $lng = $player['lang'];
                                } else { $lng = 'Undefined'; }
                                
                                if ( !in_array($lng, $lang_pl) ) {
                                    $lang_pl[] = $lng;
                                }
                            } ?>

                            <?php if( count($lang_pl) > 0 ){ ?>

                                <div class="d-flex-ch mb-10 btr">
                                    <?php foreach($lang_pl as $k => $lpl){ 
                                        if($lpl == 'Undefined'){
                                            $lng_term_name = 'Undefined';
                                        } else {
                                            $lng_term = get_term( $lpl, 'language' ); 
                                            $lng_term_name = $lng_term->name;
                                        }
                                        if($k == 0){ ?>
                                            <span tab="<?php echo 'ln' . $k;  ?>"  class="btn active rtg"><?php echo $lng_term_name; ?></span>
                                        <?php } else { ?>
                                            <span tab="<?php echo 'ln' . $k;  ?>" class="btn rtg inactive" ><?php echo $lng_term_name; ?></span>
                                        <?php }
                                    } ?>
                                </div>

                                <?php foreach($lang_pl as $k => $lpl){ 
                                    ?>
                                    <div id="<?php echo 'ln' . $k;  ?>" class="lrt <?php if($k == 0){ echo 'active'; } ?>">
                                        
                                        <ul class="aa-tbs aa-tbs-video" data-tbs="aa-options">
                                            <?php foreach ($links['online'] as $key => $online) {

                                                if($lpl == 'Undefined'){
                                                    if(!$online['lang']) {
                                                    $count = $key + 1;
                                                    //Server
                                                    if ($online['server']) {
                                                        $server_term = get_term($online['server'], 'server');
                                                    }
                                                    // lang
                                                    if ($online['lang']) {
                                                        $lang_term = get_term($online['lang'], 'language');
                                                    }
                                                    // quality
                                                    if ($online['quality']) {
                                                        $quality_term = get_term($online['quality'], 'quality');
                                                    }
                                                    if ($key == 0) { ?>
                                                        <li>
                                                            <a class="btn on" href="#options-<?php echo $key; ?>">
                                                            <?php echo lang_torofilm('OPTION', 'txt_option'); ?> <span><?php echo $count; ?></span> 
                                                                <span class="server"><?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                                    <?php if ($online['lang'] && $online['lang'] != '') {
                                                                        echo '-' . $lang_term->name;
                                                                    } else {
                                                                        echo '';
                                                                    } ?>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    <?php } else { ?>
                                                        <li>
                                                            <a class="btn" href="#options-<?php echo $key; ?>"><?php echo lang_torofilm('OPTION', 'txt_option'); ?> 
                                                                <span><?php echo $count; ?></span> 
                                                                <span class="server">
                                                                    <?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                                    <?php if ($online['lang'] && $online['lang'] != '') { echo '-' . $lang_term->name; } else { echo ''; } ?>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    <?php } 
                                                    } 
                                                } else {


                                                    if($online['lang'] == $lpl) {
                                                        $count = $key + 1;
                                                        //Server
                                                        if ($online['server']) {
                                                            $server_term = get_term($online['server'], 'server');
                                                        }
                                                        // lang
                                                        if ($online['lang']) {
                                                            $lang_term = get_term($online['lang'], 'language');
                                                        }
                                                        // quality
                                                        if ($online['quality']) {
                                                            $quality_term = get_term($online['quality'], 'quality');
                                                        }
                                                        if ($key == 0) { ?>
                                                            <li>
                                                                <a class="btn on" href="#options-<?php echo $key; ?>">
                                                                    <?php echo lang_torofilm('OPTION', 'txt_option'); ?> <span><?php echo $count; ?></span> 
                                                                    <span class="server"><?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                                        <?php if ($online['lang'] && $online['lang'] != '') {
                                                                            echo '-' . $lang_term->name;
                                                                        } else {
                                                                            echo '';
                                                                        } ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php } else { ?>
                                                            <li>
                                                                <a class="btn" href="#options-<?php echo $key; ?>"><?php echo lang_torofilm('OPTION', 'txt_option'); ?> 
                                                                    <span><?php echo $count; ?></span> 
                                                                    <span class="server">
                                                                        <?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                                        <?php if ($online['lang'] && $online['lang'] != '') { echo '-' . $lang_term->name; } else { echo ''; } ?>
                                                                    </span>
                                                                </a>
                                                            </li>
                                                        <?php } 
                                                    } 
                                           


                                                } 
                                            } ?>
                                        </ul>


                                    </div>
                                <?php } ?>


                            <?php } ?>

                        <?php } else { ?>
                        
                            <ul class="aa-tbs aa-tbs-video" data-tbs="aa-options">
                                <?php foreach ($links['online'] as $key => $online) {
                                    $count = $key + 1;
                                    //Server
                                    if ($online['server']) {
                                        $server_term = get_term($online['server'], 'server');
                                    }
                                    // lang
                                    if ($online['lang']) {
                                        $lang_term = get_term($online['lang'], 'language');
                                    }
                                    // quality
                                    if ($online['quality']) {
                                        $quality_term = get_term($online['quality'], 'quality');
                                    }
                                    if ($key == 0) { ?>
                                        <li>
                                            <a class="btn on" href="#options-<?php echo $key; ?>">
                                                <?php echo lang_torofilm('OPTION', 'txt_option'); ?> <span><?php echo $count; ?></span> 
                                                <span class="server"><?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                    <?php if ($online['lang'] && $online['lang'] != '') {
                                                        echo '-' . $lang_term->name;
                                                    } else {
                                                        echo '';
                                                    } ?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php } else { ?>
                                        <li>
                                            <a class="btn" href="#options-<?php echo $key; ?>"><?php echo lang_torofilm('OPTION', 'txt_option'); ?> 
                                                <span><?php echo $count; ?></span> 
                                                <span class="server">
                                                    <?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?>
                                                    <?php if ($online['lang'] && $online['lang'] != '') { echo '-' . $lang_term->name; } else { echo ''; } ?>
                                                </span>
                                            </a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>

                        <?php } ?>
                            
                    
                    </div>

                </aside>


                

                
            </section>
           
            <?php if($ads_bottom){ ?>
                <div class="d-flex-ch j-center">
                    <?php echo $ads_bottom; ?>
                </div>
            <?php } ?>
            
        <?php } else {
            get_template_part('public/partials/template/movies/noplayer');
        }
    }
}
add_action('single_content', 'single_content_player_movie', 20);
if (!function_exists('single_comment')) {
    function single_comment()
    {
        comments_template();
    }
}
add_action('single_content', 'single_comment', 30);



/* RECOMEND MOVIE */
if (!function_exists('single_content_recommend_movie')) {
    function single_content_recommend_movie()
    {
        $title_related    = get_option('title_related_movies', __('Recommended Movies', 'torofilm'));
        $number_related   = get_option('related_movies_number', 5);
        $disabled_related = get_option('disable_related_movies', false);

        $custom_taxterms = wp_get_object_terms(get_the_ID(), 'category', array('fields' => 'ids'));
        $args = array(
            'post_type'      => 'movies',
            'post_status'    => 'publish',
            'posts_per_page' => $number_related,
            'orderby'        => 'rand',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'id',
                    'terms'    => $custom_taxterms
                )
            ),
            'post__not_in' => array(get_the_ID()),
        );
        $the_related = new WP_Query($args);


        if (!$disabled_related && $the_related->have_posts()) { ?>
            <section class="section episodes">
                <header class="section-header">
                    <div class="rw alg-cr jst-sb">
                        <h3 class="section-title"><?php echo $title_related; ?></h3>
                    </div>
                </header>
                <div class="owl-carousel owl-theme carousel">
                    <?php  
                    while ($the_related->have_posts()) : $the_related->the_post();
                        get_template_part('public/partials/template/movies', 'related');
                    endwhile;
                    wp_reset_query(); ?>
                </div>
            </section>
<?php }
    }
}
add_action('single_content', 'single_content_recommend_movie', 40);
