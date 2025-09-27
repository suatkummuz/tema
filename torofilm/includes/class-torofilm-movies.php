<?php
class TOROFLIX_Movies{


	public static function tr_links_episodes($term_id)
	{
		$links_total = get_term_meta($term_id, 'trgrabber_tlinks', true) == '' ? 0 : get_term_meta($term_id, 'trgrabber_tlinks', true) - 1;
		$links = array();
		if (get_term_meta($term_id, 'trgrabber_tlinks', true) > 0) {
			for ($i = 0; $i <= $links_total; $i++) {
				$link = unserialize(get_term_meta($term_id, 'trglinks_' . $i, true));
				$type = $link['type'] == '' ? 1 : $link['type'];
				$lang = $link['lang'] == '' ? 0 : $link['lang'];
				$quality = $link['quality'] == '' ? 0 : $link['quality'];
				$server = $link['server'] == '' ? 0 : $link['server'];
				$linkk = $link['link'] == '' ? '' : trgrabber_base64de($link['link']);
				$date = $link['date'] == '' ? '' : $link['date'];
				if ($type == 1 and $linkk != '') {
					$links['online'][] = array(
						'i' => $i,
						'lang' => $lang,
						'quality' => $quality,
						'server' => $server,
						'link' => $linkk,
						'date' => $date
					);
				} elseif ($linkk != '') {
					$links['downloads'][] = array(
						'i' => $i,
						'lang' => $lang,
						'quality' => $quality,
						'server' => $server,
						'link' => $linkk,
						'date' => $date
					);
				}
			}
			return $links;
		}
	}


	public function tr_links_movies($post_id)
	{
		$links_total = get_post_meta($post_id, 'trgrabber_tlinks', true) == '' ? 0 : get_post_meta($post_id, 'trgrabber_tlinks', true) - 1;
		$links = array();
		
		if (get_post_meta($post_id, 'trgrabber_tlinks', true) > 0) {
			for ($i = 0; $i <= $links_total; $i++) {
				$link = unserialize(get_post_meta($post_id, 'trglinks_' . $i, true));
				$type = $link['type'] == '' ? 1 : $link['type'];
				$lang = $link['lang'] == '' ? 0 : $link['lang'];
				$quality = $link['quality'] == '' ? 0 : $link['quality'];
				$server = $link['server'] == '' ? 0 : $link['server'];
				$linkk = $link['link'] == '' ? '' : trgrabber_base64de($link['link']);
				$date = $link['date'] == '' ? '' : $link['date'];
				if ($type == 1 and $linkk != '') {
					$links['online'][] = array(
						'i' => $i,
						'lang' => $lang,
						'quality' => $quality,
						'server' => $server,
						'link' => $linkk,
						'date' => $date
					);
				} elseif ($linkk != '') {
					$links['downloads'][] = array(
						'i' => $i,
						'lang' => $lang,
						'quality' => $quality,
						'server' => $server,
						'link' => $linkk,
						'date' => $date
					);
				}
			}
			return $links;
		}
	}
	#Is movie or Serie
	public function is_serie_movie()
	{
		global $post;
		if ('movies' == get_post_type($post->ID)) {
			$type = __('Movie', 'torofilm');
		} elseif ('series' == get_post_type($post->ID)) {
			$type = __('Serie', 'torofilm');
		}
		return $type;
	}
	#Number Seasons by Serie
	public function number_seasons_serie()
	{
		global $post;
		$seasons = get_post_meta($post->ID, 'number_of_seasons', true);
		if (!$seasons)
			$seasons = 0;
		return $seasons;
	}
	#number Episodes by Serie
	public function number_episodes_serie()
	{
		global $post;
		$episodes = get_post_meta($post->ID, 'number_of_episodes', true);
		if (!$episodes)
			$episodes = 0;
		return $episodes;
	}
	#GET Quality by movies
	public function get_quality()
	{
		global $post;
		$quality_array = array();
		$qual          = false;
		if ('movies' == get_post_type($post->ID)) {
			$links = self::tr_links_movies($post->ID);
			$links['online'] = !empty($links['online']) ? $links['online'] : false;
			if(isset($links)){
				if ($links['online']) {
					foreach ($links['online'] as $key => $online) {
						if ($online['server']) {
							$quality_term = get_term($online['quality'], 'quality');
						} else {
						}
						if(isset($quality_term)){
							if (!in_array($quality_term, $quality_array)) {
								$quality_array[] = $quality_term;
							}
						}
					}
				} 
			}
		}
		foreach ($quality_array as $key => $q) {
			if ($key == 0) {
				if (isset($q->name)) {
					if ($q->name != '') {
						$qual = '<span class="Qlty">' . $q->name . '</span>';
					}
				}
			}
		}
		return $qual;
	}
	#GET Quality by movies
	public function get_lang()
	{
		global $post;
		$quality_array = array();
		$qual          = array();
		if ('movies' == get_post_type($post->ID)) {
			$links =  self::tr_links_movies($post->ID);
			$links['online'] = !empty($links['online']) ? $links['online'] : false;
			if ($links['online']) {
				foreach ($links['online'] as $key => $online) {
					$quald = false;
					if ($online['lang'] && $online['lang'] != '') {
						$quality_term = get_term($online['lang'], 'language');
					}
					if (isset($quality_term)) {
						if (!in_array($quality_term, $quality_array)) {
							$quality_array[] = $quality_term;
							$tid = $quality_term->term_id;
							$quald = get_term_meta($tid, 'image', true);
							if ($quald) {
								$qual[] = '<img loading="lazy" src="' . wp_get_attachment_url($quald) . '">';
							} else {
								$quald = get_term_meta($tid, 'image_hotlink', true);
								if ($quald) {
									$qual[] = '<img loading="lazy" src="' . $quald . '">';
								}
							}
						}
					}
				}
			}
		}
		$b = implode('', $qual);
		return $b;
	}
	public function get_categories()
	{
		global $post;
		$cats = false;
		$terms = get_the_category($post->ID);
		if (!empty($terms)) {
			$categories = array();
			foreach ($terms as $term) {
				$categories[] = '<a href="' . get_category_link($term) . '">' . $term->name . '</a>';
			}
			$cats = implode(', ', $categories);
		}
		return $cats;
	}
	public function get_tags()
	{
		global $post;

		$tags = false;
		$terms = get_the_tags($post->ID);
		if (!empty($terms)) {
			$tagges = array();
			foreach ($terms as $term) {
				$tagges[] = '<a href="' . get_tag_link($term) . '">' . $term->name . '</a>';
			}
			$tags = implode(', ', $tagges);
		}
		return $tags;
	}
	public function get_cast_by_2()
	{
		global $post;
		$cas = false;
		if ('movies' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('cast'));
		} elseif ('series' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('cast_tv'));
		}
		if ($terms) {
			$number_actor = count($terms);
			$casts = array();
			foreach ($terms as $key => $term) {
				if ($key < 2) {
					if ($term === end($terms)) {
						$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
					} else {
						$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
					}
				}
			}
			$cas = implode(', ', $casts);
		}
		if (isset($number_actor)) {
			if ($number_actor > 2) {
				$cas = $cas . ' ...';
			}
		}
		return $cas;
	}
	#List categories Series and Movies
	public function categories()
	{
		global $post;
		$terms = wp_get_post_terms($post->ID, array('category'));
		if ($terms) {
			$categories = array();
			foreach ($terms as $term) {
				$categories[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
			}
		}
		$cats = implode(', ', $categories);
		return $cats;
	}
	#Actor Series and Movies
	public function casts()
	{
		global $post;
		$cas = false;
		if ('movies' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('cast'));
		} elseif ('series' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('cast_tv'));
		}
		if (!empty($terms)) {
			$number_actor = count($terms);
			$casts = array();
			foreach ($terms as $key => $term) {
				if ($key < 5) {
					if ($term === end($terms)) {
						$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
					} else {
						$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
					}
				}
			}
		}
		if (isset($casts))
			$cas = implode(', ', $casts);
		return $cas;
	}
	#Director Movies and Series
	public function director()
	{
		global $post;
		$directors = array();
		if ('movies' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('directors'));
		} elseif ('series' == get_post_type($post->ID)) {
			$terms = wp_get_post_terms($post->ID, array('directors_tv'));
		}
		if ($terms) {
			$directors = array();
			foreach ($terms as $term) {
				if ($term === end($terms)) {
					$directors[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
				} else {
					$directors[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>,';
				}
			}
		}
		$dir = implode(' ', $directors);
		return $dir;
	}
	#Director unique - Movies and Series
	public function director_unique()
	{
		global $post;
		$director = false;
		if ('movies' == get_post_type($post->ID)) {
			$directors = wp_get_post_terms($post->ID, array('directors'));
		} elseif ('series' == get_post_type($post->ID)) {
			$directors = wp_get_post_terms($post->ID, array('directors_tv'));
		}
		if ($directors) {
			$director = '<a href="' . esc_url(get_term_link($directors[0])) . '">' . $directors[0]->name . '</a>';
		}
		return $director;
	}
	#Year of Movie and Series
	public function year()
	{
		global $post;
		if ('movies' == get_post_type($post->ID)) {
			$fecha = get_post_meta($post->ID, 'field_release_year', true);
		} elseif ('series' == get_post_type($post->ID)) {
			$fecha = get_post_meta($post->ID, 'field_date', true);
		}
		if ($fecha) {
			$fechas = explode('-', $fecha);
			return $fechas[0];
		} else {
			return false;
		}
	}
	#Duration of Movies and Series
	public function duration()
	{
		global $post;
		$duration = false;
		if ('movies' == get_post_type($post->ID)) {
			if (get_post_meta($post->ID, 'field_runtime', true))
				$duration = get_post_meta($post->ID, 'field_runtime', true);
		} elseif ('series' == get_post_type($post->ID)) {
			$dur = isset(get_post_meta($post->ID, 'field_runtime', true)[0]) ? get_post_meta($post->ID, 'field_runtime', true)[0] : false;
			if ($dur !== false) {
				$dur = str_replace(',', '-', $dur);
				$duration = $dur . ' min';
			}
		}
		return $duration;
	}
	#Number of views of movies and series
	public function views()
	{
		global $post;
		$views = false;
		$views = get_post_meta($post->ID, 'views', true);
		if (!$views) {
			$views = 0;
		}
		return $views;
	}
	#Image
	public static function image($id, $size)
	{
		if (get_the_post_thumbnail($id, $size)) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
			$return = '<img loading="lazy" src="' . $image[0] . '">';
			//$return = get_the_post_thumbnail( $id, 'thumbnail' );
		} elseif (get_post_meta($id, 'poster_hotlink', true) != '') {
			if ($size == 'thumbnail') $size = 'w185';
			if ($size == 'widget') $size = 'w92';
			if ($size == 'medium') $size = 'w342';
			if (filter_var(get_post_meta($id, 'poster_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" src="//image.tmdb.org/t/p/' . $size . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" src="' . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/dvr300.png" alt="">';
		}
		return $return;
	}
	public static function image_pglazy($id, $size)
	{
		if (get_the_post_thumbnail($id, $size)) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($id), $size);
			$return = '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimga.svg" class="imglazy" data-src="' . $image[0] . '">';
			//$return = get_the_post_thumbnail( $id, 'thumbnail' );
		} elseif (get_post_meta($id, 'poster_hotlink', true) != '') {
			if ($size == 'thumbnail') $size = 'w185';
			if ($size == 'widget') $size = 'w92';
			if ($size == 'medium') $size = 'w342';
			if (filter_var(get_post_meta($id, 'poster_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimga.svg" class="imglazy" data-src="//image.tmdb.org/t/p/' . $size . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="imglazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimga.svg" data-src="' . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = '<img loading="lazy" class="imglazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimga.svg" data-src="' . TOROFILM_DIR_URI . 'public/img/cnt/dvr300.png" alt="">';
		}
		return $return;
	}
	public static function image_lazy($id, $size)
	{
		if (get_the_post_thumbnail($id, $size)) {
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
			$return = '<img loading="lazy" class="owl-lazy" data-src="' . $image[0] . '">';
			//$return = get_the_post_thumbnail( $id, 'thumbnail',array( 'class' => 'owl-lazy' ) );
		} elseif (get_post_meta($id, 'poster_hotlink', true) != '') {
			if ($size == 'thumbnail') $size = 'w185';
			if ($size == 'widget') $size = 'w92';
			if (filter_var(get_post_meta($id, 'poster_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" class="owl-lazy" data-src="//image.tmdb.org/t/p/' . $size . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="owl-lazy" data-src="' . get_post_meta($id, 'poster_hotlink', true) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/dvr300.png" alt="">';
		}
		return $return;
	}
	#backdrop Image
	public static function backdrop($post_id, $size)
	{
		$post_id = $post_id == '' ? $post->ID : $post_id;
		$backdrop_field = get_post_meta($post_id, 'field_backdrop', true);
		$backdrop_url = get_post_meta($post_id, 'backdrop_hotlink', true);
		$url_backdrop = wp_get_attachment_image_src($backdrop_field, 'full');
		$backdrop_field = $url_backdrop == '' ? '' : '<img loading="lazy" class="TPostBg" src="' . $url_backdrop[0] . '" alt="' . __('Background', 'torofilm') . '">';
		if (filter_var(get_post_meta($post_id, 'backdrop_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
			if ($url_backdrop != '') {
				return $backdrop_field;
			} elseif (get_post_meta($post_id, 'backdrop_hotlink', true) != '') {
				return '<img loading="lazy" class="TPostBg" src="//image.tmdb.org/t/p/' . $size . '' . get_post_meta($post_id, 'backdrop_hotlink', true) . '" alt="' . __('Background', 'torofilm') . '">';
			} else {
				return '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimgb.svg" alt="">';
			}
		} else {
			return '<img loading="lazy" class="imglazy TPostBg" src="' . $backdrop_url . '">';
		}
	}
	public static function backdrop_lazy($post_id, $size)
	{
		$post_id = $post_id == '' ? $post->ID : $post_id;
		$backdrop_field = get_post_meta($post_id, 'field_backdrop', true);
		$backdrop_url = get_post_meta($post_id, 'backdrop_hotlink', true);
		$url_backdrop = wp_get_attachment_image_src($backdrop_field, 'full');
		$backdrop_field = $url_backdrop == '' ? '' : '<img loading="lazy" class="owl-lazy TPostBg" data-src="' . $url_backdrop[0] . '" alt="' . __('Background', 'torofilm') . '">';
		if (filter_var(get_post_meta($post_id, 'backdrop_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
			return '<img loading="lazy" class="owl-lazy TPostBg" data-src="//image.tmdb.org/t/p/' . $size . '' . get_post_meta($post_id, 'backdrop_hotlink', true) . '" alt="' . __('Background', 'torofilm') . '">';
		} else {
			return '<img loading="lazy" class="owl-lazy TPostBg" data-src="' . $backdrop_url . '" alt="' . __('Background', 'torofilm') . '">';
		}
	}
	public static function backdrop_tmdb($post_id, $size)
	{
		global $post;
		$post_id        = $post_id == '' ? $post->ID : $post_id;
		
		/* image of TMDB */
		$backdrop_url   = get_post_meta($post_id, 'backdrop_hotlink', true);
		
		/* image host */
		$backdrop_field = get_post_meta($post_id, 'field_backdrop', true);
		
		if( $backdrop_field ) {
			
			$url_backdrop   = wp_get_attachment_image_src($backdrop_field, $size);
			return '<img loading="lazy" class="nnn TPostBg" src="' . $url_backdrop[0]. '" alt="' . __('Background', 'torofilm') . '">';
		
		} elseif( $backdrop_url ) {

			/* Image native of TMDB */
			if( filter_var($backdrop_url, FILTER_VALIDATE_URL) === FALSE ) {

				switch ($size) {
					case 'thumbnail':
						$imag = 'w300';
						break;
					case 'medium':
						$imag = 'w780';
						break;
					case 'original':
						$imag = 'w1280';
						break;
					default :
						$imag = 'w1280';
				}
				
				return '<img loading="lazy" class="TPostBg" src="//image.tmdb.org/t/p/' . $imag . '' . $backdrop_url . '" alt="' . __('Background', 'torofilm') . '">';

			} else {

				return '<img loading="lazy" class="TPostBg" src="' . $backdrop_url . '" alt="' . __('Background', 'torofilm') . '">';

			}

		} else {
			return false;
		}


		
	}


	public static function backdrop_pglazy($post_id, $size)
	{
		$post_id = $post_id == '' ? $post->ID : $post_id;
		$backdrop_field = get_post_meta($post_id, 'field_backdrop', true);
		$backdrop_url = get_post_meta($post_id, 'backdrop_hotlink', true);
		$url_backdrop = wp_get_attachment_image_src($backdrop_field, 'full');
		$backdrop_field = $url_backdrop == '' ? '' : '<img loading="lazy" class="imglazy TPostBg" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimgb.svg" data-src="' . $url_backdrop[0] . '" alt="' . __('Background', 'torofilm') . '">';
		if (filter_var(get_post_meta($post_id, 'backdrop_hotlink', true), FILTER_VALIDATE_URL) === FALSE) {
			if ($url_backdrop != '') {
				return $backdrop_field;
			} elseif (get_post_meta($post_id, 'backdrop_hotlink', true) != '') {
				return '<img loading="lazy" class="imglazy TPostBg" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimgb.svg" data-src="//image.tmdb.org/t/p/' . $size . '' . get_post_meta($post_id, 'backdrop_hotlink', true) . '" alt="' . __('Background', 'torofilm') . '">';
			} else {
				return '<img loading="lazy" src="' . TOROFILM_DIR_URI . 'public/img/cnt/noimgb.svg" alt="">';
			}
		} else {
			return '<img loading="lazy" class="imglazy TPostBg" src="' . $backdrop_url . '">';
		}
	}
	/*=============================
	=            TERMS            =
	=============================*/
	/*Number episodes of SEASON*/
	public static function number_episodes_term($term)
	{
		$number = get_term_meta($term->term_id, 'episode_number', true);
		if (!$number) {
			$number = 0;
		}
		return $number;
	}
	public static function number_episodes_season($term)
	{
		$number = get_term_meta($term->term_id, 'number_of_episodes', true);
		if (!$number) {
			$number = 0;
		}
		return $number;
	}
	/*Number of season of SEASON*/
	public static function number_season_term($term)
	{
		$number = get_term_meta($term->term_id, 'season_number', true);
		if (!$number) {
			$number = 0;
		}
		return $number;
	}
	/*Title for SEASON*/
	public static function title_term($term)
	{
		$name = get_term_meta($term->term_id, 'name', true);
		if (!$name) {
			$name = $term->name;
		}
		return $name;
	}
	/*Date for SEASON*/
	public static function date_term($term)
	{
		$newDate = false;
		if (get_term_meta($term->term_id, 'air_date', true)) {
			$dates = get_term_meta($term->term_id, 'air_date', true);
			$newDate = date("d-m-Y", strtotime($dates));
		}
		return $newDate;
	}
	public static function duration_term($term)
	{
		$id            = $term->term_id;
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		$duration = false;
		if (get_post_meta($id_serie, 'field_runtime', true)) {
			$duration = get_post_meta($id_serie, 'field_runtime', true)[0] . 'min';
		}
		return $duration;
	}
	/*Year for SEASON*/
	public static function year_term($term)
	{
		$dates = get_term_meta($term->term_id, 'air_date', true);
		if ($dates) {
			$date_array = explode('-', $dates);
			return $date_array[0];
		} else {
			return false;
		}
	}
	/*Image term*/
	public static function image_term_episode($term, $size)
	{
		$id            = $term->term_id;
		$image_hotlink = get_term_meta($id, 'still_path_hotlink', true);
		$image         = get_term_meta($id, 'still_path', true);
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		if ($size == 'full')
			$size = 'w1280';
		if (isset($image) and !empty($image)) {
			if ($size == 'w1280') {
				$return = '<img loading="lazy" style="opacity:1;" class="imglazy" src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" style="opacity:1;" class="imglazy" src="' . wp_get_attachment_url($image) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} elseif (isset($image_hotlink) and !empty($image_hotlink)) {
			if (filter_var($image_hotlink, FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" style="opacity:1;" class="imglazy" src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" style="opacity:1;" class="imglazy" src="' . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = self::backdrop($id_serie, $size);
		}
		return $return;
	}
	public static function image_term_episode_lazy($term, $size)
	{
		$id            = $term->term_id;
		$image_hotlink = get_term_meta($id, 'still_path_hotlink', true);
		$image         = get_term_meta($id, 'still_path', true);
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		if ($size == 'full')
			$size = 'w1280';
		if (isset($image) and !empty($image)) {
			if ($size == 'w1280') {
				$return = '<img loading="lazy" class="imglazy" data-src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="imglazy" data-src="' . wp_get_attachment_url($image) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} elseif (isset($image_hotlink) and !empty($image_hotlink)) {
			if (filter_var($image_hotlink, FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" class="imglazy" data-src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="imglazy" data-src="' . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = self::backdrop_pglazy($id_serie, $size);
		}
		return $return;
	}
	public static function image_term_season($term, $size)
	{
		$id            = $term->term_id;
		$image_hotlink = get_term_meta($id, 'still_path_hotlink', true);
		$image         = get_term_meta($id, 'still_path', true);
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		if (isset($image) and !empty($image)) {
			$return = '<img loading="lazy" class="imglazy" src="' . wp_get_attachment_url($image) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
		} elseif (isset($image_hotlink) and !empty($image_hotlink)) {
			if (filter_var($image_hotlink, FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" class="imglazy" src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="imglazy" src="' . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = self::image($id_serie, $size);
		}
		return $return;
	}
	public static function image_term_season_lazy($term, $size)
	{
		$id            = $term->term_id;
		$image_hotlink = get_term_meta($id, 'still_path_hotlink', true);
		$image         = get_term_meta($id, 'still_path', true);
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		if (isset($image) and !empty($image)) {
			$return = '<img loading="lazy" class="imglazy" data-src="' . wp_get_attachment_url($image) . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
		} elseif (isset($image_hotlink) and !empty($image_hotlink)) {
			if (filter_var($image_hotlink, FILTER_VALIDATE_URL) === FALSE) {
				$return = '<img loading="lazy" class="imglazy" data-src="//image.tmdb.org/t/p/' . $size . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			} else {
				$return = '<img loading="lazy" class="imglazy" data-src="' . $image_hotlink . '" alt="' . sprintf(__('Image %s', 'torofilm'), get_the_title($id)) . '">';
			}
		} else {
			$return = self::image_pglazy($id_serie, $size);
		}
		return $return;
	}
	public static function director_term($term)
	{
		$id            = $term->term_id;
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		$directors = array();
		$terms = wp_get_post_terms($id_serie, array('directors_tv'));
		if ($terms) {
			$directors = array();
			foreach ($terms as $term) {
				if ($term === end($terms)) {
					$directors[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
				} else {
					$directors[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>,';
				}
			}
		}
		$dir = implode(' ', $directors);
		return $dir;
	}
	public static function casts_term($term)
	{
		$id            = $term->term_id;
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		$terms = wp_get_post_terms($id_serie, array('cast_tv'));
		$number_actor = count($terms);
		$cas = false;
		if ($terms) {
			$casts = array();
			foreach ($terms as $key => $term) {
				if ($term === end($terms)) {
					$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
				} else {
					$casts[] = '<a href="' . esc_url(get_term_link($term)) . '">' . esc_html($term->name) . '</a>';
				}
			}
		}
		if (isset($casts)) {
			$cas = implode(', ', $casts);
		}
		return $cas;
	}
	public static function categories_term($term)
	{
		$id            = $term->term_id;
		$id_serie      = get_term_meta($id, 'tr_id_post', true);
		$terms = wp_get_post_terms($id_serie, array('category'));
		if ($terms) {
			$categories = array();
			foreach ($terms as $term) {
				$categories[] = '<a href="' . get_term_link($term) . '">' . $term->name . '</a>';
			}
		}
		$cats = implode(', ', $categories);
		return $cats;
	}
	public function serie_tax($term)
	{
		$id = $term->term_id;
		$id_serie = get_term_meta($id, 'tr_id_post', true);
		if (!$id_serie)
			$id_serie = false;
		return $id_serie;
	}
	public function description_term($term)
	{
		$id = $term->term_id;
		$overview = get_term_meta($id, 'overview', true);
		if (!$overview)
			$overview = false;
		return $overview;
	}
	public function rating_term($post_id)
	{
		$rating = get_post_meta($post_id, 'rating', true);
		if (!$rating)
			$rating = 0;
		return $rating;
	}
	public function trailer($post_id)
	{
		$trailer = get_post_meta($post_id, 'field_trailer', true);
		if (!$trailer)
			$trailer = false;
		return $trailer;
	}
}
