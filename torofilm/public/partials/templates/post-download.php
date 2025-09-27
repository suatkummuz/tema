<?php 

$publicLink  = get_post_meta( get_the_ID(), 'post_link_public', true );
$premiunLink = get_post_meta( get_the_ID(), 'post_link_premiun', true );

if($publicLink or $premiunLink){

?>

    <section class="section">
        <header class="section-header">
            <div class="rw alg-cr jst-sb">
                <h3 class="section-title"><?php _e('Download', 'toroflix'); ?></h3>
            </div>
        </header>

        <div class="download-post section">
            <div class="link-section">
                <?php if($publicLink){ ?>
                    <div class="d-flex plink">
                        <h3><?php _e('Public Links', 'torofilm'); ?></h3>
                        <a href="" class="btn"><?php _e('Public', 'torofilm'); ?></a>
                    </div>
                <?php } 

                if($premiunLink){ ?>
                    <div class="d-flex">
                        <h3><?php _e('Premiun Links', 'torofilm'); ?></h3>
                        <a href="" class="btn lin"><?php _e('Premiun', 'torofilm'); ?></a> 
                    </div>
                <?php } ?>
            </div>
            <div class="pass-link">
                <h4><i class="fa fa-unlock-alt" aria-hidden="true"></i> <?php _e('Password', 'torofilm'); ?>: <span>www.descargatelotodo.com</span></h4>
            </div>
        </div>
    </section>

<?php } ?>