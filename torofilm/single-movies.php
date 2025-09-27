<?php get_header();
	if(have_posts()) : while(have_posts()) : the_post();
		$loop = new TOROFLIX_Movies(); ?>
		<div class="bd">
			<?php do_action( 'single_content', $loop ); 
				#10: DATA MOVIE
				#20: PLAYER MOVIE
				#30: RECOMEND MOVIE ?>
		</div>
	<?php endwhile; endif; 
get_footer(); 
do_action( 'single_modal', $loop );
	#10: TRAILER MODAL
	#20: FAVORITE MODAL
	#30: DOWNLOAD LINK MODAL ?>