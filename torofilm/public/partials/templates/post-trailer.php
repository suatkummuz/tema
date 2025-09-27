<?php 

$trailer = get_post_meta( get_the_ID(), 'post_trailer', true );

if($trailer){

    $trailer = str_replace('src=', 'data-src=', $trailer);
?>


<section class="section">
    <header class="section-header">
        <div class="rw alg-cr jst-sb">
            <h3 class="section-title"><?php _e('Video', 'toroflix'); ?></h3>
        </div>
    </header>
    <div class="video-post">
        <div id="trailer" class="video-container">
            <?php echo $trailer; ?>
        </div>
    </div>
</section>


<?php } ?>