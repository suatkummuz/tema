<?php
#LOGO
if (!function_exists('header_logo')) {
	function header_logo()
	{ ?>
		<?php
		if (!is_front_page() or wp_is_mobile()) {
			if (get_custom_logo()) { ?>
				<figure class="logo fg1 cl0c">
					<?php the_custom_logo(); ?>
				</figure>
			<?php } else { ?>
				<figure class="logo fg1 cl0c">
					<a href="<?php echo esc_url(home_url()); ?>">
						<img src="<?php echo TOROFILM_DIR_URI; ?>public/img/cnt/torofilm.svg">
					</a>
				</figure>
		<?php }
		}
	}
}
add_action('header_content', 'header_logo', 10);
#NAV
if (!function_exists('header_navigation')) {
	function header_navigation()
	{
		global $current_user;
		$login = get_option('header_login', false);
		?>
		<nav id="menu" class="hdd dfxc fg1 jst-sb alg-cr">
			<?php if ($login) {  ?>
				<ul class="rw dv">
					<?php if (is_user_logged_in()) { ?>
						<li class="cl1 cl0c">
							<div class="user-menu aa-drp left">
								<button class="btn aa-lnk lnk rnd blk">
									<span class="dfx alg-cr">
										<span class="avatar fa-user">
											<?php echo get_avatar(get_current_user_id()); ?>
										</span>
										<span class="user-name hddc">
											<span><span><?php _e('Welcome', 'torofilm'); ?></span> <?php echo $current_user->nickname; ?></span>
										</span>
									</span>
								</button>
								<ul class="aa-cnt sub-menu">
									<li class="fa-user"><a href="<?php echo esc_url(home_url()); ?>/author/<?php echo $current_user->user_nicename; ?>"><?php _e('My account', 'torofilm'); ?></a></li>
									<li class="fa-power-off"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e('Logout', 'torofilm'); ?></a></li>
								</ul>
							</div>
						</li>
					<?php } else { ?>
						<li class="cl2 cl0c">
							<button class="btn btn-login lnk fa-user aa-mdl blk" data-mdl="mdl-login"><?php _e('Login', 'torofilm'); ?></a>
						</li>
						<li class="cl2 cl0c hddc shwd">
							<button class="btn btn-signup lin rnd aa-mdl blk" data-mdl="mdl-signup"><?php _e('Register', 'torofilm'); ?></a>
						</li>
					<?php } ?>
					<li class="cl1 cl0c or-1c shw <?php if (is_front_page()) { ?>hddc<?php } ?>">
						<form id="search" class="search full" method="get" action="<?php echo get_home_url(); ?>">
							<input id="tr_live_search_h" type="text" name="s" placeholder="<?php echo lang_torofilm('Search', 'txt_search'); ?>">
							<button type="submit" class="btn npd lnk">
								<i id="sl_home_h" class="fa-search"></i>
							</button>
							<ul id="res-sj_h" class="sub-menu"></ul>
						</form>
					</li>
				</ul>
			<?php } else { ?>
				<ul class="rw dv">
					<li class="cl1 cl0c or-1c shw <?php if (is_front_page()) { ?>hddc<?php } ?>">
						<form id="search" class="search full" method="get" action="<?php echo get_home_url(); ?>">
							<input id="tr_live_search_h" type="text" name="s" placeholder="<?php echo lang_torofilm('Search', 'txt_search'); ?>">
							<button type="submit" class="btn npd lnk">
								<i id="sl_home_h" class="fa-search"></i>
							</button>
							<ul id="res-sj_h" class="sub-menu"></ul>
						</form>
					</li>
				</ul>
			<?php }
			if (has_nav_menu('header')) {
				wp_nav_menu(
					array(
						'menu' 				=>  'Menu',
						'theme_location' 	=> 	'header',
						'container'			=> 	false,
						'items_wrap'     	=> 	'<ul class="menu dfxc dv or-1">%3$s</ul>',
					)
				);
			} ?>
		</nav>
	<?php
	}
}
add_action('header_content', 'header_navigation', 20);
#TOGGLE MENU
if (!function_exists('header_toggle')) {
	function header_toggle()
	{ ?>
		<button type="button" class="btn menu-btn npd lnk aa-tgl hddc" data-tgl="aa-wp"><i class="fa-bars"></i></button>
<?php }
}
add_action('header_content', 'header_toggle', 30);
