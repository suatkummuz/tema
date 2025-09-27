<div id="comments" class="comments-area widget">
<div class="comments-title widget-title"><?php _e('Comments', 'torofilm' ); ?></div>
	<div id="disqus_thread">
		<?php if ( have_comments() ) : ?>
			
			<nav class="navigation pagination comments-nav"><?php paginate_comments_links(); ?></nav>
			<ul class="comment-list">
				<?php
					wp_list_comments( array(
						'style'       => 'ol',
						'format'      => 'html5',
						'short_ping'  => true,
						'avatar_size' => 50,
					) );
				?>
			</ul>
			<nav class="navigation pagination comments-nav"><?php the_comments_navigation(); ?></nav>
		<?php endif; ?>
		<?php
			if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="no-comments"><?php _e('Comments are closed.', 'torofilm' ); ?></p>
		<?php endif; ?>
		<?php
			comment_form( array(
				'title_reply_before' => '<div id="reply-title" class="comments-title comment-reply-title widget-title">',
				'title_reply_after'  => '</div>',
			) );
		?>
	</div>
</div>