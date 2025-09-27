<?php get_header(); ?>
<div class="bd cont">
	<div class="oops fa-sad-tear far">
		<h1 class="oops-title"><?php echo lang_torofilm('Oops!...', 'txt_oops'); ?></h1>
		<p><?php echo lang_torofilm('The page you are looking for does not exist...', 'txt_the_page_you_are_looking'); ?></p>
		<a href="<?php echo esc_url( home_url() ); ?>" class="btn"><?php echo lang_torofilm('Back to Home', 'txt_back_to_home'); ?></a>
	</div>
</div>
<?php get_footer(); ?>