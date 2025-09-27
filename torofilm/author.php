<?php get_header();
$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));  
$favoritos = get_user_meta( $curauth->ID, 'favorito', true); 
if(!$favoritos)
	$favoritos = array();
$favoritos_s = get_user_meta( $curauth->ID, 'favorito-s', true); 
if(!$favoritos_s)
	$favoritos_s = array();
?>	
	<div class="bd">
		<section class="section profile">
			<header class="section-header dfxa alg-cr">
				<div class="user-box dfx alg-cr fg1">
					<figure class="avatar fa-user alg-ss">
						<?php echo get_avatar( $curauth->ID ); ?>
					</figure>
					<aside class="fg1">
						<h1 class="section-title"><?php echo $curauth->nickname; ?></h1>
						<?php if($curauth->description){ ?>
							<p class="about-me"><?php echo $curauth->description; ?></p>
						<?php } else { ?>
							<p class="about-me"><?php echo lang_torofilm( "You haven't written anything about yourself", 'txt_you_havent_written' ); ?></p>
						<?php } ?>
					</aside>
				</div>
				<div class="stats">
					<ul class="rw stats-li">
						<li><?php echo (count($favoritos) + count($favoritos_s)); ?> <span><?php echo lang_torofilm('Favorites', 'txt_favorites'); ?></span></li>
					</ul>
				</div>
			</header>
			<ul class="aa-tbs dfx" data-tbs="aa-profile">
				<li><a href="#profile-a" class="on"><?php echo lang_torofilm('Movies', 'txt_movies'); ?></a></li>
				<li><a href="#profile-d"><?php echo lang_torofilm('Series', 'txt_series'); ?></a></li>
				<li><a href="#profile-c"><?php echo lang_torofilm('Episodes', 'txt_episodes'); ?></a></li>
				<li><a href="#profile-b"><?php echo lang_torofilm('Settings', 'txt_settings'); ?></a></li>
			</ul>
		</section>
		<div class="aa-cn" id="aa-profile">
			<div id="profile-a" class="aa-tb anm-b hdd on">
				<!-- movies -->
				<section class="section movies">
					<header class="section-header dfx alg-cr">
						<h3 class="section-title"><?php echo lang_torofilm('Favorites Movies', 'txt_favorites_movies'); ?></h3>
					</header>
					<?php if($favoritos){ ?>
						<ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e">
							<?php 
						    $args = array(
						        'post_type' => array('movies'),
						        'post__in' => $favoritos,  
						    ); 
						    $the_query = new WP_Query( $args );
						    if ( $the_query->have_posts() ) :
						        while ( $the_query->have_posts() ) : $the_query->the_post(); 
						        	get_template_part( 'public/partials/template/movies', 'mainbig' );
								endwhile;
							else: ?>
								<p><?php echo lang_torofilm('No results', 'txt_no_results'); ?></p>
							<?php endif; wp_reset_query(); ?>
						</ul>
					<?php } else { ?>
						<p><?php echo lang_torofilm('No results', 'txt_no_results'); ?></p>
					<?php } ?>
				</section>
			</div>
			<div id="profile-d" class="aa-tb anm-b hdd">
				<!-- movies -->
				<section class="section movies">
					<header class="section-header dfx alg-cr">
						<h3 class="section-title"><?php echo lang_torofilm('Favorites Series', 'txt_favorites_series'); ?></h3>
					</header>
					<?php if($favoritos){ ?>
						<ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e">
							<?php 
						    $args = array(
						        'post_type' => array( 'series'),
						        'post__in' => $favoritos,  
						    ); 
						    $the_query = new WP_Query( $args );
						    if ( $the_query->have_posts() ) :
						        while ( $the_query->have_posts() ) : $the_query->the_post(); 
						        	get_template_part( 'public/partials/template/movies', 'mainbig' );
								endwhile;
							else: ?>
								<p><?php echo lang_torofilm('No results', 'txt_no_results'); ?></p>
							<?php endif; wp_reset_query(); ?>
						</ul>
					<?php } else { ?>
						<p><?php echo lang_torofilm('No results', 'txt_no_results'); ?></p>
					<?php } ?>
				</section>
			</div>
			<div id="profile-c" class="aa-tb anm-b hdd">
				<!-- movies -->
				<section class="section movies">
					<header class="section-header dfx alg-cr">
						<h3 class="section-title"><?php echo lang_torofilm('Favorites Episodes', 'txt_favorites_episodes'); ?></h3>
					</header>
					<?php if($favoritos_s){ ?>
						<ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e eqcl">
							<?php $episodes = get_terms( 'episodes', array(
								'include' => $favoritos_s
							) ); 
							foreach ( $episodes as $episode ) {  
								$air_date = get_term_meta( $episode->term_id, 'air_date', true );
								$dat = strtotime($air_date); ?>
								<li>
									<article class="post dfx fcl episodes fa-play-circle">
										<header class="entry-header">
											<span class="num-epi"><?php echo get_term_meta($episode->term_id, 'season_number', true); ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span> <h2 class="entry-title"><?php echo $episode->name; ?></h2>
											<div class="entry-meta">
												<span class="time"><?php echo human_time_diff( $dat, current_time('timestamp') ) . ' ago'; ?></span>
											</div>
										</header>
										<a href="<?php echo get_term_link( $episode ); ?>" class="lnk-blk"></a>
									</article>
								</li>
							<?php } ?>	
						</ul>
					<?php } else { ?>
						<p><?php echo lang_torofilm('No results', 'txt_no_results'); ?></p>
					<?php } ?>
				</section>
			</div>
			<div id="profile-b" class="aa-tb anm-b hdd">
				<section class="edit-profile">
					<header class="section-header dfxb alg-cr">
						<h3 class="section-title"><?php echo lang_torofilm('Edit profile', 'txt_edit_profile'); ?></h3>
					</header>
					<form id="editor-user-perfil" enctype="multipart/form-data">					
						
						<ul class="rw rcl1 rcl2a">
							<li>
								<p class="inp">
									<label><?php echo lang_torofilm('Country', 'txt_country'); ?></label>
									<input value="<?php echo get_user_meta($current_user->ID, 'pais', true); ?>" type="text" id="edit-user-perfil-pais" name="edit-user-perfil-pais" data-countrycodeinput="1" readonly="readonly" placeholder="<?php echo lang_torofilm('Select your country', 'txt_select_your_country'); ?>" />
								</p>
							</li>
							<li>
								<p class="inp">
									<label><?php echo lang_torofilm('Date of birth', 'txt_date_of_birth'); ?></label>
									<input name="edit-user-perfil-nacimiento" id="edit-user-perfil-nacimiento" type="date" value="<?php echo get_user_meta($current_user->ID, 'nacimiento', true); ?>">
								</p>
							</li>
						</ul>
						<p class="inp">
							<label><?php echo lang_torofilm('About you', 'txt_about_you'); ?></label>
							<textarea cols="6" name="edit-user-perfil-description" id="edit-user-perfil-description"><?php echo $current_user->user_description; ?></textarea>
						</p>
						<p><button type="submit" class="btn snd blk"><?php echo lang_torofilm('Save Changes', 'txt_save_changes'); ?></button></p>
					</form>
					<form id="editor-user-pass">
						<hr>
						<header class="section-header dfxb alg-cr">
							<h3 class="section-title"><?php echo lang_torofilm('Change password', 'txt_change_password'); ?></h3>
						</header>
						<p class="inp val-ok">
							<label><?php echo lang_torofilm('Current password', 'txt_current_password'); ?></label>
							<span class="ico">
								<input type="text" id="password current">
								<i class="fa-lock"></i>
							</span>
							<!-- <span class="val fa-check">success</span> -->
						</p>
						<p class="inp val-ok">
							<label><?php echo lang_torofilm('New password', 'txt_new_password'); ?></label>
							<span class="ico">
								<input required id="editor-user-pass-password" type="password">
								<i class="fa-lock"></i>
							</span>
							<!-- <span class="val fa-check">success</span> -->
						</p>
						<p class="inp val-no">
							<label><?php echo lang_torofilm('Repeat password', 'txt_repeat_password'); ?></label>
							<span class="ico">
								<input required id="editor-user-pass-repeat" type="password">
								<!-- <i class="fa-lock"></i> -->
							</span>
							<!-- <span class="val fa-times">error</span> -->
						</p>
						<p><button type="submit" class="btn snd blk"><?php echo lang_torofilm('Update Password', 'txt_update_password'); ?></button></p>
					</form>
				</section>
			</div>
		</div>
	</div>
<?php get_footer(); ?>