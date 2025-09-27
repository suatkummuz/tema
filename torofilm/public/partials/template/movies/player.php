<?php 
 $unencrypt       = get_option('player_encrypt', false);
 $links           = $loop->tr_links_movies(get_the_ID());
 $links['online'] = !empty($links['online']) ? $links['online'] : '';
 $tagiframe       = 'iframe'; 
?>
<section class="section player dfxc jst-sb">
    <aside class="video-player aa-cn" id="aa-options">
        <?php foreach ($links['online'] as $key => $online) {
            if (!$unencrypt) {
                if ($key == 0) { ?>
                    <div id="options-<?php echo $key; ?>" class="video aa-tb hdd on">
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
                        <?php if (!$advertising) { ?>
                            <?php echo $advertising_code; ?>
                        <?php } ?>
                        <<?php echo $tagiframe; ?> src="<?php echo $online['link'];  ?>" data-src="<?php echo $online['link']; ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></<?php echo $tagiframe; ?>>
                    </div>
                <?php } else { ?>
                    <div id="options-<?php echo $key; ?>" class="video aa-tb hdd">
                        <?php if (!$advertising) { ?>
                            <?php echo $advertising_code; ?>
                        <?php } ?>
                        <iframe data-src="<?php echo $online['link'];  ?>" frameborder="0" scrolling="no" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                    </div>
        <?php }
            }
        } ?>
    </aside>
    <aside class="video-options">
        <div class="title hdd shwc"><?php echo lang_torofilm('OPTIONS', 'txt_options'); ?></div>
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
                    <li><a class="btn on" href="#options-<?php echo $key; ?>"><?php echo lang_torofilm('OPTION', 'txt_option'); ?> <span><?php echo $count; ?></span> <span class="server"><?php if ($online['server'] && $online['server'] != '') {echo $server_term->name;} ?>
                    <?php if ($online['lang'] && $online['lang'] != '') {echo '-' . $lang_term->name;} else {echo ''; } ?></span></a></li>
                <?php } else { ?>
                    <li><a class="btn" href="#options-<?php echo $key; ?>"><?php echo lang_torofilm('OPTION', 'txt_option'); ?> <span><?php echo $count; ?></span> <span class="server"><?php if ($online['server'] && $online['server'] != '') { echo $server_term->name; } ?><?php if ($online['lang'] && $online['lang'] != '') {echo '-' . $lang_term->name; } else {echo '';} ?></span></a></li>
                <?php } ?>
            <?php } ?>
        </ul>
    </aside>
</section>