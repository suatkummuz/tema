		<footer class="ft tac">
			<nav class="top dfxc alg-cr">
				<?php $logo_footer = get_theme_mod( 'logo_footer' ); 
				if($logo_footer){ ?>
					<figure class="logo"><img src="<?php echo $logo_footer; ?>"></figure>
				<?php } 
				if ( has_nav_menu( 'footer' ) ) {
				    wp_nav_menu(
						array(
							'menu' 				=>  'Menu', 
							'theme_location' 	=> 	'footer',
							'container'			=> 	false,
							'items_wrap'     	=> 	'<ul class="menu dfx fwp fg1 jst-cr">%3$s</ul>',
						)
					);
				} 
				$facebook = get_option( 'social_facebook', false );
				$twitter        = get_option( 'social_twitter', false );
				$instagram      = get_option( 'social_instagram', false ); 
				if($facebook or $twitter or $instagram){ ?>
					<ul class="social rw jst-cr">
						<?php if($facebook){ ?>
							<li><a target="_blank" href="<?php echo $facebook;?>" class="fa-facebook fab"></a></li>
						<?php } if($twitter){ ?>
							<li><a target="_blank" href="<?php echo $twitter; ?>" class="fa-twitter fab"></a></li>
						<?php } if($instagram){ ?>
							<li><a target="_blank" href="<?php echo $instagram; ?>" class="fa-instagram fab"></a></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</nav>
			<?php if(get_option( 'text_footer' )){ ?>
				<p class="copy"><?php echo get_option( 'text_footer' ); ?></p>
			<?php } ?>
			<nav class="kw">
				<?php if ( has_nav_menu( 'tags' ) ) {
				    wp_nav_menu(
						array(
							'menu' 				=>  'Menu', 
							'theme_location' 	=> 	'tags',
							'container'			=> 	false,
							'items_wrap'     	=> 	'<ul class="dfx fwp jst-cr">%3$s</ul>',
						)
					);
				} ?>
		   </nav>
		</footer>
		<?php do_action( 'footer_images' ); 
				#10: footer_images_theme ?>
		
	</div>
	<?php do_action( 'footer_modal' ); 
		# 10: FOOTER LOGIN 
		# 20: FOOTER REGISTER
		# 30: FOOTER RECOVERY ?>
<?php wp_footer();

$disqus_enable = get_option('enable_disqus');
if($disqus_enable) echo '<script>' . get_option('disqus_code') . '</script>';
?>



</body>
</html>