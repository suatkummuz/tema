<?php 
$loop = new TOROFLIX_Movies();
$fecha      = get_post_meta(get_the_ID(), 'field_release_year', true);
$fechas     = explode('-', $fecha);
$tmdb       = get_post_meta(get_the_ID(), 'rating', true);
$quality    = $loop->get_quality();
$lang       = $loop->get_lang();
$option     = get_option('poster_option_views', array());
$img_atts = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
?>
<article class="post dfx fcl movies">
    <header class="entry-header">
        <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>
    <div class="post-thumbnail or-1">
        <figure>
            <img class="lazy" data-src="<?php echo $img_atts; ?>" alt="<?php the_title(); ?>"> 
        </figure> 
        <span class="post-ql"> 
            <?php if (in_array('qual', $option)) { 
                if ( 'movies' == get_post_type(get_the_ID()) && $quality) { echo $quality;} 
            } ?> 
            <?php if (in_array('lang', $option)) {   
                if ( 'movies' == get_post_type(get_the_ID()) && $lang) {  ?>
                <span class="lang"><?php echo $lang; ?></span>
            <?php } } ?>
        </span> 
        <span class="watch btn sm"><?php _e('View', 'torofilm'); ?></span> 
        <span class="play fa-link"></span>
    </div> <a href="<?php the_permalink(); ?>" class="lnk-blk"></a>
</article>