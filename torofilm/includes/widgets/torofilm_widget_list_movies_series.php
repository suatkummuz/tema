<?php
add_action( 'widgets_init', function(){
    register_widget( 'widget_list_movies_series' );
});
class widget_list_movies_series extends WP_Widget {
    #Sets up the widgets name etc
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_list_movies_series movies',
            'description' => 'Widget list movies and series',
        );
        parent::__construct( 'widget_list_movies_series', 'Torofilm: List of movies and series', $widget_ops );
    }
    # Display frontend
    public function widget( $argus, $instance ) {
        echo $argus['before_widget'];
       /* if ( ! empty( $instance['title'] ) ) {
            echo $argus['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $argus['after_title'];
        }*/ ?>
		<?php 
		$url    = ( ! empty( $instance['url'] ) ) ? $instance['url'] : false;
		$cat    = ( ! empty( $instance['categories'] ) ) ? $instance['categories'] : false;
		$type   = isset( $instance['type'] ) ? (int) $instance['type'] : 1;
		$filter = ( ! empty( $instance['filter'] ) ) ? (int)( $instance['filter'] ) : 0;
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if($type == 0) {
			$t = array('movies', 'series');
			$r = 'movies-series';
		} elseif($type == 1) {
			$t = array('movies');
			$r='movies';
		}elseif($type == 2) {
			$t = array('series');
			$r='series';
		}else {
			$t = array('movies', 'series');
			$r = 'movies-series';
		} 
		if($cat){
			$categories = explode(',', $cat); 
		} else {
			$categories = array('tf_all');	
		} ?>
		
		<header class="section-header">
			<div class="rw alg-cr jst-sb">
				<h3 class="section-title"><?php echo $instance['title']; ?></h3>
				<?php if($url){ ?>
					<ul class="rw">
						<li><a href="<?php echo $url; ?>" class="btn lnk more fa-plus"><?php _e('View more', 'torofilm'); ?></a></li>
					</ul>
				<?php } ?>
			</div>
			<?php if( count($categories) > 1 ) { ?>
				<ul class="aa-tbs ax-tbs" data-tbs="<?php echo $this->id; ?>-aa-movies">
					<?php if ( ! empty( $categories ) ) {
						
						
						foreach ( $categories as $key => $group_value ) {
							if($group_value != 'tf_all'){

								$id   = $group_value;
								$cate = get_term_by( 'id', $id, 'category' );

							?>
								<li><a <?php if($key == 0) echo 'class="on"'; ?> data-mode="1" data-category="<?php echo $id; ?>" data-limit="<?php echo $number; ?>" data-post="<?php echo $r; ?>" href="#<?php echo $this->id; ?>-<?php echo $cate->slug; ?>"><?php echo $cate->name; ?></a></li>
							<?php } else {
								echo '<li><a class="on" data-category="" data-limit="'.$number.'" data-post="movies-series" href="#'.$this->id.'-all">'. __('All', 'torofilm') ,'</a></li>';
							}
						}
					} ?>
				</ul>
			<?php } ?>
		</header>
		<div class="aa-cn" id="<?php echo $this->id; ?>-aa-movies">

			<?php 
			if ( ! empty( $categories ) ) {
	    		foreach ( $categories as $key => $group_value ) {

	    			if($key == 0){
		    			if($group_value == 'tf_all'){ ?>
		    				
		    				<div id="<?php echo $this->id; ?>-all" class="aa-tb hdd on">
								<ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e">
									<?php 
									if($filter == 0){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
									    ); 
									} elseif($filter == 1){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'title',
											'order'               => 'ASC', 
									    );
									} elseif($filter == 2){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'rand',
									    );
									} elseif($filter == 3){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'comment_count',
											'order'               => 'DESC', 
									    );
									} elseif($filter == 4){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'meta_key'            => 'views', 
											'orderby'             => 'meta_value_num', 
											'order'               => 'DESC'
									    );
									} elseif($filter == 5){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'meta_key'            => 'rating', 
											'orderby'             => 'meta_value_num', 
											'order'               => 'DESC'
									    );
									}
								    $the_query = new WP_Query( $args );
								    if ( $the_query->have_posts() ) :
								        while ( $the_query->have_posts() ) : $the_query->the_post(); 
								        	get_template_part( 'public/partials/template/movies', 'main' );
										endwhile;
									else: ?>
										<p class="no-results"><?php _e('No results found', 'torofilm'); ?></p>
									<?php endif; wp_reset_query(); ?>
								</ul>
							</div>
		    			
		    			<?php } else { 

		    				$id   = $group_value;
							$cate = get_term_by( 'id', $id, 'category' ); ?>

		    				<div id="<?php echo $this->id; ?>-<?php echo $cate->slug; ?>" class="aa-tb hdd on">
								<ul class="post-lst rw sm rcl2 rcl3a rcl4b rcl3c rcl4d rcl6e">
									<?php 
									if($filter == 0){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
									    ); 
									} elseif($filter == 1){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'title',
											'order'               => 'ASC', 
									    );
									} elseif($filter == 2){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'rand',
									    );
									} elseif($filter == 3){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'orderby'             => 'comment_count',
											'order'               => 'DESC', 
									    );
									} elseif($filter == 4){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'meta_key'            => 'views', 
											'orderby'             => 'meta_value_num', 
											'order'               => 'DESC'
									    );
									} elseif($filter == 5){
										$args = array(
											'post_type'           => $t,
											'posts_per_page'      => $number,
											'post_status'         => 'publish',
											'no_found_rows'       => true,
											'ignore_sticky_posts' => true,
											'meta_key'            => 'rating', 
											'orderby'             => 'meta_value_num', 
											'order'               => 'DESC'
									    );
									}
									$args['category__in'] = $group_value;
								    $the_query = new WP_Query( $args );
								    if ( $the_query->have_posts() ) :
								        while ( $the_query->have_posts() ) : $the_query->the_post(); 
								        	get_template_part( 'public/partials/template/movies', 'main' );
										endwhile;
									else: ?>
										<p class="no-results"><?php _e('No results found', 'torofilm'); ?></p>
									<?php endif; wp_reset_query(); ?>
								</ul>
							</div>
		    				

		    			<?php }

		    		} else { 

		    			if($group_value == 'tf_all'){ ?>
		    				<div id="<?php echo $this->id; ?>-all" class="aa-tb hdd"></div>
		    			<?php } else { 

							$id   = $group_value;
							$cate = get_term_by( 'id', $id, 'category' ); ?>

							<div id="<?php echo $this->id; ?>-<?php echo $cate->slug; ?>" class="aa-tb hdd"></div>

		    			<?php } 
		    		} 
	    		}
	    	} ?>
		</div>
        <?php echo $argus['after_widget'];
    }
    #Parameters Form of Widget
    public function form( $instance ) {
		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$number     = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$url        = ! empty( $instance['url'] ) ? $instance['url'] : ''; 
		$type       = isset( $instance['type'] ) ? (int) $instance['type'] : 1;
		$filter     = isset( $instance['filter'] ) ? (int) $instance['filter'] : 0;
		$categories = isset($instance['categories']) ? $instance['categories'] :false;
		
		?>

		<div class="wdgt-tt">
	        <div>
	            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'torofilm'); ?>:</label>
	            <div class="fr-input">
                    <span class="dashicons dashicons-edit-large"></span>
	            	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
	            </div>
	        </div>
		    <div>
		        <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e('Number of movies/series', 'torofilm'); ?>:</label>
		        <div class="fr-input">
                    <span class="dashicons dashicons-shortcode"></span>
					<input style="width: 100px;" class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
				</div>
			</div>
			<div>
			    <label for="<?php echo $this->get_field_id( 'url' ); ?>">URL</label>
			    <div class="fr-input">
                    <span class="dashicons dashicons-admin-links"></span>
			    	<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>">
			    </div>
			</div>
			<div>
			    <label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type', 'torofilm'); ?></label>
			    <div class="fr-input">
                    <span class="dashicons dashicons-video-alt2"></span>
				    <select id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				        <option<?php selected($type, 1 ); ?> value="1"><?php _e('Movies', 'torofilm'); ?></option>
				        <option<?php selected($type, 2 ); ?> value="2"><?php _e('Series', 'torofilm'); ?></option>
				       
				    </select>
				</div> 
			</div>
			<div>
			    <label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Filter by', 'torofilm'); ?></label>
			    <div class="fr-input">
                    <span class="dashicons dashicons-sort"></span>
				    <select id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>">
				        <option<?php selected($filter, 0 ); ?> value="0"><?php _e('Latest', 'torofilm'); ?></option>
				        <option<?php selected($filter, 1 ); ?> value="1"><?php _e('Title', 'torofilm'); ?></option>
				        <option<?php selected($filter, 2 ); ?> value="2"><?php _e('Random', 'torofilm'); ?></option>
				        <option<?php selected($filter, 3 ); ?> value="3"><?php _e('Comments', 'torofilm'); ?></option>
				        <option<?php selected($filter, 4 ); ?> value="4"><?php _e('Views', 'torofilm'); ?></option>
				        <option<?php selected($filter, 5 ); ?> value="5"><?php _e('Popular', 'torofilm'); ?></option>
				    </select>
				</div>       
			</div>
			<div class="select-cats">
				<label class="show-hide-cat" for="<?php echo $this->get_field_id('categories'); ?>"><?php _e('Category', 'torofilm'); ?> <span class="dashicons dashicons-sort"></span></label>
				<div class="fr-input-cat hide">
					 <ul class="s-cat">
					 	
			            <?php
			            $ar='';
		                $ar=explode(',', $categories);

		                foreach ($ar as &$value) {
		                    $lst[$value] = $value;
		                } 
		                ?>


		                <li>
					 		<label>
					 			<input <?php if(isset($lst['tf_all'])){checked( $lst['tf_all'], 'tf_all'); } ?> type="checkbox" class="checkbox" name="<?php echo $this->get_field_name('categories'); ?>[]" value="tf_all"> <?php _e('All', 'torofilm'); ?>
					 		</label>
					 	</li>


		                <?php $categories = get_categories('hide_empty=1');
		                foreach ($categories as $category) {
			            ?>
			            <li>
			                <label><input <?php if(isset($lst[$category->term_id])){checked( $lst[$category->term_id], $category->term_id); } ?> type="checkbox" class="checkbox" name="<?php echo $this->get_field_name('categories'); ?>[]" value="<?php echo $category->term_id; ?>"  />
			                <?php echo $category->cat_name ?></label><br />
			            </li>
			            <?php
			                }
			            ?>
			        </ul>
				</div>
			</div>    
	    </div>
        <?php
    }
    #Save Data
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        foreach( $new_instance as $key => $value )
        {
            $updated_instance[$key] = sanitize_text_field($value);
        }
        if(isset($new_instance['categories'])){
        	$updated_instance['categories'] = strip_tags(implode(',', $new_instance['categories']));
        }
        return $updated_instance;
    }
}