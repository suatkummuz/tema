<?php 
$custom_logo_id = get_theme_mod( 'custom_logo' );
$image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
<div class="home-search hdd shwc"><?php if($image){ ?><figure class="logo tac"><img src="<?php echo $image[0]; ?>"></figure><?php } ?>
	<form id="form-shs" class="search full" method="get" action="<?php echo get_home_url(); ?>">
		<input id="tr_live_search" name="s" type="text" placeholder="<?php echo lang_torofilm('Search', 'txt_search'); ?>">
		<button type="submit" class="btn npd lnk"><i id="sl-home" class="fa-search"></i></button>
		<ul id="res-sj" class="sub-menu"></ul>
	</form>
</div>