<?php
#POST SINGLE
if (!function_exists('series_single')) {
    function series_single($data)
    {
        $loop               = $data['loop'];
        $term               = $data['term'];
        $term_id            = $data['term_id'];
        $year               = $loop->year_term($term);
        $serie_id           = $loop->serie_tax($term);
        $categories         = $loop->categories_term($term);
        $duration           = $loop->duration_term($term);
        $description        = $loop->description_term($term);
        $dir                = $loop->director_term($term);
        $cas                = $loop->casts_term($term);
        $rating             = $loop->rating_term($serie_id);
        $links              = tr_links_episodes($term_id);
        $links['downloads'] = !empty($links['downloads']) ? $links['downloads']: '';
        $user_id            = get_current_user_id();
        $isFavorito         = get_user_meta($user_id, 'favorito-s', true);
        $disable_share      = get_option('disable_episodes_share');

        $id_post            = $term_id;
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
        }
?>
        <!-- single -->
        <article class="post single">
            <div class="dfxb alg-cr">
                <div class="post-thumbnail alg-ss">
                    <figure><?php echo tr_theme_img($serie_id, 'thumbnail', get_the_title()); ?></figure>
                </div>
                <aside class="fg1">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php single_term_title(); ?></h1>
                        <div class="entry-meta">
                            <?php if ($categories) { ?>
                                <span class="genres"><?php echo $categories; ?></span><?php } ?>
                            <?php if ($duration) { ?>
                                <span class="duration fa-clock far"><?php echo $duration; ?></span><?php } ?>
                            <?php if ($year) { ?>
                                <span class="year fa-calendar far"><?php echo $year; ?></span><?php } ?>
                        </div>
                    </header>
                    <?php if ($description) { ?>
                        <div class="description">
                            <?php echo $description; ?>
                        </div><?php } ?>
                    <?php if ($dir or $cas) { ?>
                        <ul class="cast-lst dfx fwp">
                            <?php if ($dir) { ?>
                                <li>
                                    <span><?php _e('Director', 'torofilm'); ?></span>
                                    <p><?php echo $dir; ?></p>
                                </li><?php } ?>
                            <?php if ($cas) { ?>
                                <li>
                                    <span><?php _e('Cast', 'torofilm'); ?></span>
                                    <p style="color:#fff;"><?php echo $cas; ?></p>
                                </li><?php } ?>
                        </ul><?php } ?>
                </aside>
            </div>
            <footer class="dfxa jst-sb alg-cr">
                <div class="vote-cn">
                    <?php if ($rating) { ?>
                        <span class="vote fa-star"><span class="num"><?php echo get_post_meta($serie_id, 'rating', true); ?></span><span>TMDB</span></span><?php } ?>
                </div>
                <ul class="options rw rfg1 rcl0c">
                    <?php if ($links['downloads']) { ?>
                        <li><button class="btn lnk npd blk aa-mdl" data-mdl="mdl-download"><i class="fa-cloud-download-alt"></i> <span><?php _e('Download', 'torofilm'); ?></span></button></li><?php } ?>
                    <?php if (is_user_logged_in()) { ?>
                        <li><button id="add-to-favorito-s" data-id="<?php echo $term_id; ?>" data-status="<?php echo $statusf; ?>" class="btn lnk npd blk aa-mdl" data-mdl="mdl-favorites"><i class="fa-heart <?php echo $classf; ?>"></i> <span><?php _e('Favorites', 'torofilm'); ?></span></button></li><?php } ?>
                    <?php if($disable_share != 1){ ?>
                        <li class=""><button class="btn lnk npd blk aa-mdl" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php echo get_term_link($term, 'episodes'); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-facebook-f fab"></i><span>Facebook</span></button></li>
                        <li><button class="btn lnk npd blk aa-mdl" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php echo get_term_link($term, 'episodes'); ?>&amp;text=<?php echo $term->name; ?>&amp;tw_p=tweetbutton&amp;url=<?php echo get_term_link($term, 'episodes'); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-twitter fab"></i><span>Twitter</span></button></li>
                    <?php } ?>
                </ul>
            </footer>
        </article>
    <?php }
}
add_action('episodes_content', 'series_single', 10);


#SECTION PLAYER
if (!function_exists('series_player')) {
    function series_player($data)
    {
        global $post;
        $if = 'iframe';
        $fake             = get_option('player_fake', false);
        $fake_blank       = (bool) !get_option('player_fake_blank', false);
        $fake_url         = get_option('player_fake_url', '');
        $encrypt          = get_option('player_encrypt', false);
        $advertising      = get_option('player_advertising', false);
        $advertising_code = get_option('player_advertising_code', false);
        $loop             = $data['loop'];
        $term             = $data['term'];
        $term_id          = $data['term_id'];
        $trailer          = $loop->trailer($post->ID);
        $backdrop         = $loop->backdrop_tmdb(get_the_ID(), 'w780');
        $links            = tr_links_episodes($term_id);
        $links['online']  = !empty($links['online']) ? $links['online'] : '';
        $enable_tab_lang = get_option('enable_tab_lang', false);
        
        $season_number = $loop->number_season_term($term);
        $seasons = $season_number== 0 ? 'special' : $season_number;
        
        $episode_number = $loop->number_episodes_term($term);
        $episodes = $episode_number== 0 ? 0 : $episode_number;
        ?>
        <!-- player -->
        <?php if ($links['online']) { 
            
            $ads_top    = get_option( 'ads_top_player' );
            $ads_bottom = get_option( 'ads_bottom_player' ); ?>

            <?php if($ads_top){ ?>
                <div class="d-flex-ch j-center mb-30">
                    <?php echo $ads_top; ?>
                </div>
            <?php } ?>

            <section class="section player dfxc jst-sb episode">
                <aside class="video-player aa-cn" id="aa-options">
                    <?php foreach ($links['online'] as $key => $online) {
                        if (!$encrypt) {
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
                                    <<?php echo $if; ?> src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $term_id)) . '&trtype=2';  ?>" data-src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $term_id)) . '&trtype=2';  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                                </div>
                            <?php } else { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd">
                                    <?php if (!$advertising) { ?>
                                        <?php echo $advertising_code; ?>
                                    <?php } ?>
                                    <<?php echo $if; ?> data-src="<?php echo esc_url(home_url('/?trembed=' . $online['i'] . '&trid=' . $term_id)) . '&trtype=2';  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
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
                                    <?php if (!$advertising) { ?>
                                        <?php echo $advertising_code; ?>
                                    <?php } ?>
                                    <<?php echo $if; ?> src="<?php echo $online['link'];  ?>" data-src="<?php echo $online['link'];  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                                </div>
                            <?php } else { ?>
                                <div id="options-<?php echo $key; ?>" class="video aa-tb hdd">
                                    <?php if (!$advertising) { ?>
                                        <?php echo $advertising_code; ?>
                                    <?php } ?>
                                    <<?php echo $if; ?> data-src="<?php echo $online['link'];  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
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
                <div class="d-flex-ch j-center mb-30">
                    <?php echo $ads_bottom; ?>
                </div>
            <?php } ?>

            <div class="mb-30">
            <div class="epsdsnv mab1">
                    <?php

                    if ($seasons == 'special') {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes - 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_special',
                                    'compare' => '=',
                                    'value' => 1
                                )
                            )
                        );
                    } else {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes - 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_number',
                                    'compare' => '=',
                                    'value' => $seasons
                                )
                            )
                        );
                    }

                    $previous = wp_get_post_terms($post->ID, 'episodes', [
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'fields' => 'all',

                        'meta_query' => $args
                    ]);

                  

                    if ($previous && $episodes > 1) {
                        foreach ($previous as $k => $episode) {
                            $slug = esc_url(get_term_link($episode));

                            if ($k == 0) {
                                printf('<a href="%1$s" class="btn tertiary-bg mar"> <i class="fa-step-backward"></i> <span class="ttu dn sm-dib mal"> %2$s </span> </a>', $slug, lang_torofilm('Previous', 'txt_previous'));
                            }
                        }
                    } else {
                        printf('<span class="btn tertiary-bg mar off"> <i class="fa-step-backward"></i> <span class="ttu dn sm-dib mal"> %1$s </span> </span>', lang_torofilm('Previous', 'txt_previous'));
                    }

                    ?>

                    <a href="<?php the_permalink(); ?>" class="btn tertiary-bg mar">
                        <i class="fa-indent"></i>
                        <span class="ttu dn sm-dib mal"><?php echo lang_torofilm('Seasons', 'txt_seasons'); ?></span>
                    </a>

                    <?php

                    if ($seasons == 'special') {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes + 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_special',
                                    'compare' => '=',
                                    'value' => 1
                                )
                            )
                        );
                    } else {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes + 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_number',
                                    'compare' => '=',
                                    'value' => $seasons
                                )
                            )
                        );
                    }

                    $next = wp_get_post_terms($post->ID, 'episodes', [
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'fields' => 'all',

                        'meta_query' => $args
                    ]);

                    if ($next) {
                        foreach ($next as $k => $episode) {
                            $slug = esc_url(get_term_link($episode));

                            if ($k == 0) { 
                                printf('<a href="%1$s" class="btn tertiary-bg mar"> <span class="ttu dn sm-dib mar"> %2$s </span> <i class="fa-step-forward"></i> </a>', $slug, lang_torofilm('Next', 'txt_next'));
                            }
                        }
                    } else {
                        printf('<span class="btn tertiary-bg mar off"> <span class="ttu dn sm-dib mar"> %1$s </span> <i class="fa-step-forward"></i> </span>', lang_torofilm('Next', 'txt_next'));
                    }

                    ?>
                </div>
            </div>

        <?php } elseif ($trailer) { ?>
            <section class="section player dfxc jst-sb episode player-trailer">
                <aside class="video-player aa-cn" id="aa-options">
                    <div class="video">
                        <?php echo htmlspecialchars_decode($trailer); ?>
                    </div>
                </aside>
            </section>

            <div class="mb-30">
            <div class="epsdsnv mab1">
                    <?php

                    if ($seasons == 'special') {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes - 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_special',
                                    'compare' => '=',
                                    'value' => 1
                                )
                            )
                        );
                    } else {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes - 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_number',
                                    'compare' => '=',
                                    'value' => $seasons
                                )
                            )
                        );
                    }

                    $previous = wp_get_post_terms($post->ID, 'episodes', [
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'fields' => 'all',

                        'meta_query' => $args
                    ]);

                    if ($previous) {
                        foreach ($previous as $k => $episode) {
                            $slug = esc_url(get_term_link($episode));

                            if ($k == 0) { 
                                printf('<a href="%1$s" class="btn tertiary-bg mar"> <i class="fa-step-backward"></i> <span class="ttu dn sm-dib mal"> %2$s </span> </a>', $slug, lang_torofilm('Previous', 'txt_previous'));
                            }
                        }
                    } else {
                        printf('<span class="btn tertiary-bg mar off"> <i class="fa-step-backward"></i> <span class="ttu dn sm-dib mal"> %1$s </span> </span>', lang_torofilm('Previous', 'txt_previous'));
                    }

                    ?>

                    <a href="<?php the_permalink(); ?>" class="btn tertiary-bg mar">
                        <i class="fa-indent"></i>
                        <span class="ttu dn sm-dib mal"><?php echo lang_torofilm('Seasons', 'txt_seasons'); ?></span>
                    </a>

                    <?php

                    if ($seasons == 'special') {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes + 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_special',
                                    'compare' => '=',
                                    'value' => 1
                                )
                            )
                        );
                    } else {
                        $args = array(
                            array(
                                'relation' => 'AND',
                                'episode_number' => array(
                                    'key' => 'episode_number',
                                    'compare' => '=',
                                    'value' => ($episodes + 1)
                                ),
                                'season_number' => array(
                                    'key' => 'season_number',
                                    'compare' => '=',
                                    'value' => $seasons
                                )
                            )
                        );
                    }

                    $next = wp_get_post_terms($post->ID, 'episodes', [
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'fields' => 'all',

                        'meta_query' => $args
                    ]);

                    if ($next) {
                        foreach ($next as $k => $episode) {
                            $slug = esc_url(get_term_link($episode));

                            if ($k == 0) {
                                printf('<a href="%1$s" class="btn tertiary-bg mar"> <span class="ttu dn sm-dib mar"> %2$s </span> <i class="fa-step-forward"></i> </a>', $slug, lang_torofilm('Next', 'txt_next'));
                            }
                        }
                    } else {
                        printf('<span class="btn tertiary-bg mar off"> <span class="ttu dn sm-dib mar"> %1$s </span> <i class="fa-step-forward"></i> </span>', lang_torofilm('Next', 'txt_next'));
                    }

                    ?>
                </div>
            </div>
        <?php }
    }
}
add_action('episodes_content', 'series_player', 20);
# SECTION SEASON
if (!function_exists('series_episodes_ep')) {
    function series_episodes_ep($data)
    {
        $thumbs = get_option('disable_thumbs_episodes', false);
        $loop    = $data['loop'];
        $term_id = $data['term_id'];
        $nte = get_term_meta($term_id, 'season_number', true);
        if (!$nte) {
            $nte = 0;
        }
        ?>
        <!-- episodes -->
        <section class="section episodes">
            <header class="section-header">
                <div class="aa-drp choose-season">
                    <?php $terms = get_terms(array(
                        'taxonomy'   => 'seasons',
                        'meta_key'   => 'tr_id_post',
                        'meta_value' => get_term_meta($term_id, 'tr_id_post', true)
                    )); ?>
                    <button class="btn lnk npd aa-lnk"><span><?php _e('choose season', 'torofilm'); ?></span><?php _e('Seasons', 'torofilm'); ?> <dt class="n_s" style="display: inline"><?php echo $nte; ?></dt></button>
                    <ul class="aa-cnt sub-menu">
                        <?php foreach ($terms as $key => $term) {
                            echo '<li class="sel-temp"><a data-post="' . get_term_meta($term_id, 'tr_id_post', true) . '" data-season="' . get_term_meta($term->term_id, 'season_number', true) . '" href="javascript:void(0)">Season ' . get_term_meta($term->term_id, 'season_number', true) . '</a></li>';
                        } ?>
                    </ul>
                </div>
            </header>
            <ul id="episode_by_temp" class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl8e eqcl">
                <?php $tempx = get_term_meta($term_id, 'season_number', true);
                $ntempx = get_term_meta($term_id, 'season_number', true);
                $cv    = 'value';
                if (!$tempx) {
                    $tempx = 'NOT EXISTS';
                    $cv = 'compare';
                    $ntempx = 0;
                }  ?>
                <?php $episodes = get_terms('episodes', array(
                    'orderby'    => 'meta_value_num',
                    'order'      => 'ASC',
                    'hide_empty' => 0,
                    'number'     => 1000,
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'key' => 'episode_number',
                            'compare' => 'EXISTS',
                        ),
                        array(
                            'key'   => 'tr_id_post',
                            'value' => get_term_meta($term_id, 'tr_id_post', true)
                        ),
                        array(
                            'key'   => 'season_number',
                            $cv => $tempx
                        )
                    )
                ));
                foreach ($episodes as $episode) {
                    $air_date = get_term_meta($episode->term_id, 'air_date', true);
                    $dat = strtotime($air_date); ?>
                    <li>
                        <article class="post dfx fcl episodes fa-play-circle lg">
                            <?php if (!$thumbs) { ?>
                                <div class="post-thumbnail">
                                    <figure><?php echo tr_theme_img($episode->term_id, 'episode', $episode->name, $episode->taxonomy); ?></figure>
                                    <span class="play fa-play"></span>
                                </div>
                            <?php } ?>
                            <header class="entry-header">
                                <span class="num-epi"><?php echo $ntempx; ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>
                                <h2 class="entry-title"><?php echo $episode->name; ?></h2>
                                <?php if ($dat) { ?>
                                    <div class="entry-meta">
                                        <span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ' . __('ago', 'torofilm'); ?></span>
                                    </div>
                                <?php } ?>
                                <span class="view"><?php _e('View', 'torofilm'); ?></span>
                            </header>
                            <a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>
                        </article>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <?php }
}
add_action('episodes_content', 'series_episodes_ep', 30);
# SECTION RECOMEND
if (!function_exists('series_recomend')) {
    function series_recomend($data)
    {
        $loop    = $data['loop'];
        $term    = $data['term'];
        $term_id = $data['term_id'];
        $title_related    = get_option('title_related_episodes', __('Recommended Series', 'torofilm'));
        $number_related   = get_option('related_episodes_number', 5);
        $disabled_related = get_option('disable_repisodes_series', false);
        if (!$disabled_related) { ?>
            <section class="section episodes">
                <header class="section-header">
                    <div class="rw alg-cr jst-sb">
                        <h3 class="section-title"><?php echo $title_related; ?></h3>
                    </div>
                </header>
                <div class="owl-carousel owl-theme carousel">
                    <?php $custom_taxterms = wp_get_object_terms(get_term_meta($term_id, 'tr_id_post', true), 'category', array('fields' => 'ids'));
                    $args = array(
                        'post_type'      => 'series',
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
                        'post__not_in' => array(get_term_meta($term_id, 'tr_id_post', true)),
                    );
                    $the_related = new WP_Query($args);
                    if ($the_related->have_posts()) :
                        while ($the_related->have_posts()) : $the_related->the_post();
                            get_template_part('public/partials/template/movies', 'related');
                        endwhile;
                    endif;
                    wp_reset_query(); ?>
                </div>
            </section>
<?php }
    }
}
add_action('episodes_content', 'series_recomend', 40);
