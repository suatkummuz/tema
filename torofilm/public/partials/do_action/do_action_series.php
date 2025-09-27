<?php
#SERIES INFO
if (!function_exists('series_info')) {
	function series_info()
	{
		$id         = get_the_ID();
		$loop               = new TOROFLIX_Movies();
		$image              = $loop->image($id, 'thumbnail');
		$categories         = $loop->categories();
		$duration           = $loop->duration();
		$year               = $loop->year();
		$views              = $loop->views();
		$director           = $loop->director();
		$cast               = $loop->casts();
		$trailer            = $loop->trailer($id);
		$number_of_seasons  = $loop->number_seasons_serie();
		$number_of_episodes = $loop->number_episodes_serie();
		$user_id            = get_current_user_id();
		$isFavorito         = get_user_meta($user_id, 'favorito', true);
		$id_post            = $id;
		$rating             = $loop->rating_term($id);
		$disable_share      = get_option('disable_series_social');
		if ($isFavorito) {
			if (in_array($id_post, $isFavorito)) {
				$statusf = 'favorito';
				$classf = '';
			} else {
				$statusf = 'nofavorito';
				$classf = 'far';
			}
		} else {
			$statusf = 'nofavorito';
			$classf = 'far';
		}
?>
		<article class="post single">
			<div class="dfxb alg-cr">
				<div class="post-thumbnail alg-ss">
					<figure><?php echo $image; ?></figure>
				</div>
				<aside class="fg1">
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<?php if (!empty($categories)) { ?>
								<span class="genres"><?php echo $categories; ?></span>
							<?php } ?>
							<span class="tag fa-tag"><?php echo $loop->get_tags(); ?></span>
							<?php if ($duration) { ?>
								<span class="duration fa-clock far"><?php echo $duration[0]; ?> min.</span>
							<?php } ?>
							<?php if ($year) { ?>
								<span class="year fa-calendar far"><?php echo $year; ?></span>
							<?php } ?>
							<?php if ($views) { ?>
								<span class="views fa-eye far"><span><?php echo $views; ?></span> <?php _e('views', 'torofilm'); ?></span>
							<?php } ?>
							<?php if ($number_of_seasons) { ?>
								<span class="seasons"><span><?php echo $number_of_seasons; ?></span> <?php _e('Seasons', 'torofilm'); ?></span>
							<?php } ?>
							<?php if ($number_of_episodes) { ?>
								<span class="episodes"><span><?php echo $number_of_episodes; ?></span> <?php _e('Episodes', 'torofilm'); ?></span>
							<?php } ?>
						</div>
					</header>
					<div class="description">
						<?php the_content(); ?>
					</div>
					<ul class="cast-lst dfx fwp">
						<?php if ($director) { ?>
							<li>
								<span><?php _e('Director', 'torofilm'); ?></span>
								<p><?php echo $director; ?></p>
							</li>
						<?php }
						if ($cast) { ?>
							<li>
								<span><?php _e('Cast', 'torofilm'); ?></span>
								<p class="loadactor"><?php echo $cast; ?></p>
							</li>
						<?php } ?>
					</ul>
				</aside>
			</div>
			<footer class="dfxa jst-sb alg-cr">
				<div class="vote-cn">
					<span class="vote fa-star"><span class="num"><?php echo $rating; ?></span><span>TMDB</span></span>
				</div>
				<ul class="options rw rfg1 rcl0c">
					<?php if ($trailer) { ?>
						<li><button class="btn lnk npd blk aa-mdl" data-mdl="mdl-trailer"><i class="fa-youtube fab"></i> <span><?php _e('Trailer', 'torofilm'); ?></span></button></li>
					<?php } ?>
					<?php if (is_user_logged_in()) { ?>
						<li><button id="add-to-favorito" data-id="<?php the_ID(); ?>" data-status="<?php echo $statusf; ?>" class="btn lnk npd blk aa-mdl" data-mdl="mdl-favorites"><i class="fa-heart <?php echo $classf; ?>"></i> <span><?php _e('Favorites', 'torofilm'); ?></span></button></li><?php } ?>
					
					<?php if(!$disable_share){ ?>
						<li class=""><button class="btn lnk npd blk aa-mdl" onclick="window.open ('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>', 'Facebook', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-facebook-f fab"></i><span>Facebook</span></button></li>
						<li><button class="btn lnk npd blk aa-mdl" onclick="javascript:window.open('https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&amp;text=<?php the_title(); ?>&amp;tw_p=tweetbutton&amp;url=<?php the_permalink(); ?>', 'Twitter', 'toolbar=0, status=0, width=650, height=450');"><i class="fa-twitter fab"></i><span>Twitter</span></button></li>
					<?php } ?>
				</ul>
			</footer>
		</article>
		<?php }
}
add_action('series_content', 'series_info', 10);
#SERIES EPISODIOS
if (!function_exists('series_episodes')) {
	function series_episodes()
	{
		$thumbs = get_option('disable_thumbs_episodes', false);
		$design = get_option('episodes_type', false);
		if (!$design) $design = 'ds1';
		if ($design == 'ds1') {
			$terms = get_terms(array(
				'taxonomy' => 'seasons',
				'orderby' => 'term_id',
				'meta_key' => 'tr_id_post',
				'meta_value' => get_the_ID()
			)); ?>
			<!-- episodes -->
			<?php if ($terms) { ?>
				<section class="section episodes">
					<header class="section-header">
						<div class="aa-drp choose-season">
							<?php  ?>
							<button class="btn lnk npd aa-lnk"><span><?php _e('choose season', 'torofilm'); ?></span><?php _e('Season', 'torofilm'); ?><dt class="n_s" style="display: inline"><?php echo get_term_meta($terms[0]->term_id, 'season_number', true); ?></dt></button>
							<ul class="aa-cnt sub-menu">
								<?php foreach ($terms as $key => $term) {
									echo '<li class="sel-temp"><a data-post="' . get_the_ID() . '" data-season="' . get_term_meta($term->term_id, 'season_number', true) . '" href="javascript:void(0)">Season ' . get_term_meta($term->term_id, 'season_number', true) . '</a></li>';
								} ?>
							</ul>
						</div>
					</header>
					<ul id="episode_by_temp" class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl8e eqcl">
						<?php $tempx = get_term_meta($terms[0]->term_id, 'season_number', true);
						$ntempx = get_term_meta($terms[0]->term_id, 'season_number', true);
						$cv    = 'value';
						if (!$tempx) {
							$tempx = 'NOT EXISTS';
							$cv = 'compare';
							$ntempx = 0;
						} ?>
						<?php $episodes = get_terms('episodes', array(
							'orderby' => 'meta_value_num',
							'order' 		=> 'ASC',
							'hide_empty' 	=> 0,
							'number' 		=> 100,
							'meta_query' => array(
								'relation' => 'AND',
								array(
									'key' => 'episode_number',
									'compare' => 'EXISTS',
								),
								array(
									'key' => 'tr_id_post',
									'value' => get_the_ID(),
								),
								array(
									'key' => 'season_number',
									$cv   => $tempx,
								)
							)
						));
						foreach ($episodes as $episode) {
							$air_date = get_term_meta($episode->term_id, 'air_date', true);
							$dat = strtotime($air_date); ?>
							<li>
								<article class="post dfx fcl episodes fa-play-circle lg">
									<?php if (!$thumbs) { ?>
										<div class="post-thumbnail">
											<figure><?php echo tr_theme_img($episode->term_id, 'episode', $episode->name, $episode->taxonomy); ?></figure>
											<span class="play fa-play"></span>
										</div>
									<?php } ?>
									<header class="entry-header">
										<span class="num-epi"><?php echo $ntempx; ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>
										<h2 class="entry-title"><?php echo $episode->name; ?></h2>
										<?php if ($dat) { ?>
											<div class="entry-meta">
												<span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ' . __('ago', 'torofilm'); ?></span>
											</div>
										<?php } ?>
										<span class="view"><?php _e('View', 'torofilm'); ?></span>
									</header>
									<a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>
								</article>
							</li>
						<?php } ?>
					</ul>
				</section>
			<?php }
		} else {
			$terms = get_terms(array(
				'taxonomy' => 'seasons',
				'orderby' => 'term_id',
				'meta_key' => 'tr_id_post',
				'meta_value' => get_the_ID()
			));  ?>
			<?php if ($terms) {
				foreach ($terms as $key => $term) { ?>
					<section class="section episodes">
						<header class="section-header">
							<div class="aa-drp choose-season">
								<?php  ?>
								<a href="<?php echo get_term_link($term); ?>" class="btn lnk npd aa-arrow-right"><?php _e('Season', 'torofilm'); ?><dt class="n_s" style="display: inline"><?php echo get_term_meta($term->term_id, 'season_number', true); ?></dt></a>
							</div>
						</header>
						<?php if ($key == 0) { ?>
							<ul id="episode_by_temp" class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl8e eqcl">
								<?php $episodes = get_terms('episodes', array(
									'orderby' => 'meta_value_num',
									'order' 		=> 'ASC',
									'hide_empty' 	=> 0,
									'number' 		=> 100,
									'meta_query' => array(
										'relation' => 'AND',
										array(
											'key' => 'episode_number',
											'compare' => 'EXISTS',
										),
										array(
											'key' => 'tr_id_post',
											'value' => get_the_ID()
										),
										array(
											'key' => 'season_number',
											'value' => get_term_meta($terms[0]->term_id, 'season_number', true)
										)
									)
								));
								foreach ($episodes as $episode) {
									$air_date = get_term_meta($episode->term_id, 'air_date', true);
									$dat = strtotime($air_date); ?>
									<li>
										<article class="post dfx fcl episodes fa-play-circle lg">
											<?php if (!$thumbs) { ?>
												<div class="post-thumbnail">
													<figure><?php echo tr_theme_img($episode->term_id, 'episode', $episode->name, $episode->taxonomy); ?></figure>
													<span class="play fa-play"></span>
												</div>
											<?php } ?>
											<header class="entry-header">
												<span class="num-epi"><?php echo get_term_meta($episode->term_id, 'season_number', true); ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>
												<h2 class="entry-title"><?php echo $episode->name; ?></h2>
												<?php if ($dat) { ?>
													<div class="entry-meta">
														<span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ' . __('ago', 'torofilm'); ?></span>
													</div>
												<?php } ?>
												<span class="view"><?php _e('View', 'torofilm'); ?></span>
											</header>
											<a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>
										</article>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>
					</section>
		<?php }
			}
		}
	}
}
add_action('series_content', 'series_episodes', 20);
/*======================================================
=            MOSTRAR EPISODIOS NUEVO METODO            =
======================================================*/
if (!function_exists('series_episodes_new')) {
	function series_episodes_new()
	{
		$terms = get_terms(array(
			'taxonomy' => 'seasons',
			'orderby' => 'term_id',
			'meta_key' => 'tr_id_post',
			'meta_value' => get_the_ID()
		));  ?>
		<?php if ($terms) {
			foreach ($terms as $key => $term) { ?>
				<section class="section episodes">
					<header class="section-header">
						<div class="aa-drp choose-season">
							<?php  ?>
							<a href="<?php echo get_term_link($term); ?>" class="btn lnk npd aa-arrow-right"><?php _e('Season', 'torofilm'); ?><dt class="n_s" style="display: inline"><?php echo get_term_meta($term->term_id, 'season_number', true); ?></dt></a>
						</div>
					</header>
					<?php if ($key == 0) { ?>
						<ul id="episode_by_temp" class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl8e eqcl">
							<?php $episodes = get_terms('episodes', array(
								'orderby' => 'meta_value_num',
								'order' 		=> 'ASC',
								'hide_empty' 	=> 0,
								'number' 		=> 100,
								'meta_query' => array(
									'relation' => 'AND',
									array(
										'key' => 'tr_id_post',
										'value' => get_the_ID()
									),
									array(
										'key' => 'season_number',
										'value' => get_term_meta($terms[0]->term_id, 'season_number', true)
									)
								)
							));
							foreach ($episodes as $episode) {
								$air_date = get_term_meta($episode->term_id, 'air_date', true);
								$dat = strtotime($air_date); ?>
								<li>
									<article class="post dfx fcl episodes fa-play-circle lg">
										<header class="entry-header">
											<span class="num-epi"><?php echo get_term_meta($episode->term_id, 'season_number', true); ?>x<?php echo get_term_meta($episode->term_id, 'episode_number', true); ?></span>
											<h2 class="entry-title"><?php echo $episode->name; ?></h2>
											<div class="entry-meta">
												<span class="time"><?php echo human_time_diff($dat, current_time('timestamp')) . ' ' . __('ago', 'torofilm'); ?></span>
											</div>
										</header>
										<a href="<?php echo get_term_link($episode); ?>" class="lnk-blk"></a>
									</article>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</section>
			<?php }
		}
	}
}
add_action('xxxseries_content', 'series_episodes_new', 25);
/*=====  End of MOSTRAR EPISODIOS NUEVO METODO  ======*/
if (!function_exists('series_comment')) {
	function series_comment()
	{
		comments_template();
	}
}
add_action('series_content', 'series_comment', 30);
#SERIES RECOMENDADOS
if (!function_exists('series_recomended')) {
	function series_recomended()
	{
		$title_related    = get_option('title_related_series', __('Recommended Series', 'torofilm'));
		$number_related   = get_option('related_series_number', 5);
		$disabled_related = get_option('disable_related_series', false);
		$custom_taxterms = wp_get_object_terms(get_the_ID(), 'category', array('fields' => 'ids'));
		$args = array(
			'post_type'      => 'series',
			'post_status'    => 'publish',
			'posts_per_page' => $number_related,
			'orderby'        => 'rand',
			'tax_query'      => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $custom_taxterms
				)
			),
			'post__not_in' => array(get_the_ID()),
		);
		$the_related = new WP_Query($args);
		if (!$disabled_related && $the_related->have_posts()) { ?>
			<section class="section episodes">
				<header class="section-header">
					<div class="rw alg-cr jst-sb">
						<h3 class="section-title"><?php echo $title_related; ?></h3>
					</div>
				</header>
				<div class="owl-carousel owl-theme carousel">
					<?php 
						while ($the_related->have_posts()) : $the_related->the_post();
							get_template_part('public/partials/template/movies', 'related');
						endwhile;
					wp_reset_query(); ?>
				</div>
			</section>
<?php }
	}
}
add_action('series_content', 'series_recomended', 40);
