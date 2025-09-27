<?php
/*=====================================
=            FOOTER IMAGES            =
=====================================*/
if ( ! function_exists( 'footer_images_theme' ) ) {
	function footer_images_theme() {
		if(is_singular()){ 
			$loop = new TOROFLIX_Movies(); 
			global $post;
			$post_id = $post->ID;

			if ( get_post_type( $post_id ) == 'movies' ) {

				$size_image_header = get_option('size_image_header_movies');
				if(!$size_image_header) $size_image_header = 'original';

				$size_image_footer = get_option('size_image_footer_movies');
				if(!$size_image_footer) $size_image_footer = 'original';
				
			} elseif ( get_post_type( $post_id ) == 'series' ) {

				$size_image_header = get_option('size_image_header_series');
				if(!$size_image_header) $size_image_header = 'original';

				$size_image_footer = get_option('size_image_footer_series');
				if(!$size_image_footer) $size_image_footer = 'original';

			}
			
			if( $loop->backdrop_tmdb($post->ID, 'thumbnail') && $loop->backdrop_tmdb(get_the_ID(), 'thumbnail')!= ''){ ?>

				<?php if($size_image_header != 'none'){ ?>
					<div class="bghd"><?php echo $loop->backdrop_tmdb($post->ID, $size_image_header); ?></div>
				<?php } 
				
				if($size_image_footer != 'none'){ ?>
					<div class="bgft"><?php echo $loop->backdrop_tmdb($post->ID, $size_image_footer); ?></div>
				<?php } 
			} ?>


		<?php } elseif( is_tax( 'seasons' ) or is_tax( 'episodes' ) ) { 
			$loop = new TOROFLIX_Movies(); 
			$term_id = get_queried_object_id(); 
			$serie_id = get_term_meta( $term_id, 'tr_id_post', true );
			if($loop->backdrop_tmdb($serie_id, 'original')){ ?>
				<div class="bghd"><?php echo $loop->backdrop_tmdb($serie_id, 'original'); ?></div>
				<div class="bgft"><?php echo $loop->backdrop_tmdb($serie_id, 'original'); ?></div>
			<?php }
		} else {
			#Image header && footer
			if(!get_option( 'disable_image_header', false )){
				$image_header         = get_theme_mod( 'setting_image_header' );
				$image_header_hotlink = get_option( 'setting_image_header_hotlink', false );
				if($image_header){ ?>
					<div class="bghd"><?php echo '<img loading="lazy" src="'.$image_header.'">'; ?></div>
				<?php } elseif($image_header_hotlink){ ?>
					<div class="bghd"><?php echo '<img loading="lazy" src="'.$image_header_hotlink.'">'; ?></div>
				<?php }	else { ?>
					<div class="bghd"><img loading="lazy" src="<?php echo TOROFILM_DIR_URI . 'public/img/poster.jpg'; ?>"></div>
				<?php }
			}
			if(!get_option( 'disable_image_footer', false )){
				$image_footer         = get_theme_mod( 'setting_image_footer' );
				$image_footer_hotlink = get_option( 'setting_image_footer_hotlink', false );
				if($image_footer){ ?>
					<div class="bgft"><?php echo '<img loading="lazy" src="'.$image_footer.'">'; ?></div>
				<?php } elseif($image_footer_hotlink){ ?> 
					<div class="bgft"><?php echo '<img loading="lazy" src="'.$image_footer_hotlink.'">'; ?></div>
				<?php } else { ?>
					<div class="bgft"><img loading="lazy" src="<?php echo TOROFILM_DIR_URI . 'public/img/poster.jpg'; ?>"></div>
				<?php }
			}
		}
		
	}
}
add_action( 'footer_images', 'footer_images_theme', 10 );
/*=====  End of FOOTER IMAGES  ======*/
# FOOTER LOGIN 
if (!function_exists('footer_modal_login')) {
	function footer_modal_login()
	{
		$login = get_option('header_login', false);
		if (!is_user_logged_in() and $login) { ?>
			<div class="mdl" id="mdl-login">
				<div class="mdl-cn anm-b">
					<div class="mdl-hd">
						<div class="mdl-title"><?php _e('Login', 'torofilm'); ?></div>
						<button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-login" type="button"><i class="fa-times"></i></button>
					</div>
					<form id="form-login-user">
						<div class="mdl-bd">
							<p class="inp">
								<span class="ico">
									<input required id="form-login-name" type="text" placeholder="<?php _e('User', 'torofilm'); ?>">
									<i class="fa-user"></i>
								</span>
							</p>
							<p class="inp">
								<span class="ico">
									<input required id="form-login-pass" type="password" placeholder="<?php _e('Password', 'torofilm'); ?>">
									<i class="fa-lock"></i>
								</span>
							</p>
							<p><a href="<?php echo wp_lostpassword_url(esc_url(home_url())); ?>"><?php _e('Forgot your password?', 'torofilm'); ?></a></p>
							<p><button type="submit" class="btn snd blk"><?php _e('Login', 'torofilm'); ?></button></p>
						</div>
					</form>
					<div class="mdl-ft tac">
						<?php _e('Dont have account?', 'torofilm'); ?> <a id="to-register" href="javascript:void(0)"><?php _e('Sign Up', 'torofilm'); ?></a>
					</div>
				</div>
				<div class="mdl-ovr aa-mdl" data-mdl="mdl-login"></div>
			</div>
		<?php }
	}
}
add_action('footer_modal', 'footer_modal_login', 10);
# FOOTER REGISTER
if (!function_exists('footer_modal_register')) {
	function footer_modal_register()
	{
		$login = get_option('header_login', false); ?>
		<!-- modal -->
		<?php if (!is_user_logged_in() and $login) { ?>
			<div class="mdl" id="mdl-signup">
				<div class="mdl-cn anm-b">
					<div class="mdl-hd">
						<div class="mdl-title"><?php _e('Register', 'torofilm'); ?></div>
						<button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-signup" type="button"><i class="fa-times"></i></button>
					</div>
					<form id="form-register-user">
						<div class="mdl-bd">
							<p class="inp">
								<span class="ico">
									<input id="form-register-names" type="text" required placeholder="User">
									<i class="fa-user"></i>
								</span>
							</p>
							<p class="inp">
								<span class="ico">
									<input id="form-register-emails" required type="text" placeholder="Email">
									<i class="fa-envelope"></i>
								</span>
							</p>
							<p class="inp">
								<span class="ico">
									<input type="password" id="form-register-passs" required placeholder="Password">
									<i class="fa-lock"></i>
								</span>
							</p>
							<p><button type="submit" class="btn snd blk"><?php _e('Signup', 'torofilm'); ?></button></p>
						</div>
					</form>
					<div class="mdl-ft tac">
						<?php _e('Already have an account?', 'torofilm'); ?> <a id="to-login" href="javascript:void(0)"><?php _e('Login', 'torofilm'); ?></a>
					</div>
				</div>
				<div class="mdl-ovr aa-mdl" data-mdl="mdl-signup"></div>
			</div>
		<?php }
	}
}
add_action('footer_modal', 'footer_modal_register', 20);
# FOOTER RECOVERY 
if (!function_exists('footer_modal_recovery')) {
	function footer_modal_recovery()
	{ ?>
		<!-- modal -->
		<?php if (!is_user_logged_in()) { ?>
			<div class="mdl" id="mdl-recovery">
				<div class="mdl-cn anm-b">
					<div class="mdl-hd">
						<div class="mdl-title"><?php _e('Forgot password?', 'torofilm'); ?></div>
						<button class="btn lnk mdl-close aa-mdl" data-mdl="mdl-recovery" type="button"><i class="fa-times"></i></button>
					</div>
					<div class="mdl-bd">
						<p class="inp">
							<span class="ico">
								<input type="text" placeholder="<?php _e('Email', 'torofilm'); ?>">
								<i class="fa-envelope"></i>
							</span>
						</p>
						<p><button type="submit" class="btn snd blk"><?php _e('Send email', 'torofilm'); ?></button></p>
					</div>
				</div>
				<div class="mdl-ovr aa-mdl" data-mdl="mdl-recovery"></div>
			</div>
<?php }
	}
}
add_action('footer_modalas', 'footer_modal_recovery', 30);
