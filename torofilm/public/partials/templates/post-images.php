<?php 

$array = rwmb_meta( 'post_images', array( 'size' => 'medium' ) );
$array_hotlink = get_post_meta( get_the_ID(), 'images_tmdb', true );

if($array){

?>

    <section class="section">
        <header class="section-header">
            <div class="rw alg-cr jst-sb">
                <h3 class="section-title"><?php _e('Images', 'torofilm'); ?></h3>
            </div>
        </header>
        <div class="images-post">
           <div class="swiper-container gall mgt2">
                <div class="swiper-wrapper">
                    
                    <?php foreach ( $array as $key => $variable ) { ?>
                        <div class="swiper-slide">
                            <div class="pctr brd2">
                                <figure>
                                    <img class="lazy" data-src="<?php echo $variable['url']; ?>">
                                    <a class="lnk-blk glightbox" href="<?php echo $variable['full_url']; ?>"></a>
                                </figure>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>

<?php } elseif($array_hotlink){ 
    $arr = explode(PHP_EOL, $array_hotlink); ?>

    <section class="section">
        <header class="section-header">
            <div class="rw alg-cr jst-sb">
                <h3 class="section-title"><?php _e('Images', 'torofilm'); ?></h3>
            </div>
        </header>
        <div class="images-post">
           <div class="swiper-container gall mgt2">
                <div class="swiper-wrapper">
                    
                    <?php foreach ( $arr as $key => $variable ) { ?>
                        <div class="swiper-slide">
                            <div class="pctr brd2">
                                <figure>
                                    <img class="lazy" data-src="<?php echo $variable; ?>">
                                    <a class="lnk-blk glightbox" href="<?php echo $variable; ?>"></a>
                                </figure>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </section>

<?php } ?>