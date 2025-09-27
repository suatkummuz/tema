<?php
Class TOROFILM_Sidebar {
	public function create_sidebar_principal() {
		register_sidebar( array(
	        'name'          => __( 'Sidebar', 'torofilm' ),
	        'id'            => 'sidebar-principal',
	        'before_widget' => '<section id="%1$s" class="wdgt-sidebar widget %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h3 class="widget-title">',
	        'after_title'   => '</h3>',
		) );
		register_sidebar( array(
	        'name'          => __( 'Home Widgets', 'torofilm' ),
	        'id'            => 'sidebar-home',
	        'before_widget' => '<section id="%1$s" class="wdgt-home widget section %2$s">',
	        'after_widget'  => '</section>',
	        'before_title'  => '<h3 class="widget-title">',
	        'after_title'   => '</h3>',
		) );
	}
}