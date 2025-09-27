<?php 
add_filter( 'rwmb_meta_boxes', 'mbi_create_field' );
function mbi_create_field( $meta_boxes ) {
    
    $meta_boxes[] = array(
        'id'         => 'field_post_film', 
        'title'      => 'FilmAffinity', 
        'post_types' => array('post'),
        'context'    => 'advanced',
        'priority'   => 'default',
        'autosave'   => false,
        'fields'     => array(

            array(
                'id'   => 'fa_url',
                'type' => 'text',
                'name' => 'URL Film Affinity',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_title_original',
                'type' => 'text',
                'name' => 'Title original',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_year',
                'type' => 'text',
                'name' => 'Year',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_duration',
                'type' => 'text',
                'name' => 'Duration',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_country',
                'type' => 'text',
                'name' => 'Country',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_direccion',
                'type' => 'text',
                'name' => 'Director',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_guion',
                'type' => 'text',
                'name' => 'Guion',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_musica',
                'type' => 'text',
                'name' => 'Música',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_fotografia',
                'type' => 'text',
                'name' => 'Fotografia',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_reparto',
                'type' => 'text',
                'name' => 'Reparto',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_productora',
                'type' => 'text',
                'name' => 'Productora',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_generos',
                'type' => 'text',
                'name' => 'Géneros',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_grupos',
                'type' => 'text',
                'name' => 'Grupos',
                'size' => 60,
            ),

            array(
                'id'   => 'fa_desc',
                'type' => 'textarea',
                'name' => 'Description',
                'rows' => '4',
            ),

        ),
    );

    $meta_boxes[] = array(
        'id'         => 'field_post', 
        'title'      => 'Data Post', 
        'post_types' => array('post'),
        'context'    => 'advanced',
        'priority'   => 'default',
        'autosave'   => false,
        'fields'     => array(

            array(
                'id'   => 'post_tmdb',
                'type' => 'text',
                'name' => 'TMDB',
                'size' => 20,
            ),

            array(
                'id'          => 'type_tmdb',
                'name'        => 'Type',
                'type'        => 'radio',
                'placeholder' => 'Placeholder',
                'inline'      => true,
                'options'     => array(
                    'movie' => 'Movie',
                    'serie' => 'Serie',
                ),
            ),  

            array(
                'type' => 'button',
                'name' => 'Generate',
                'id'   => 'post_generate',
            ),

            array(
                'type' => 'divider',
            ),

            array(
                'type' => 'heading',
                'name' => 'TMDB data',
            ),

            array(
                'id'   => 'post_date',
                'type' => 'text',
                'name' => 'Date',
                'size' => '60',
            ),

            array(
                'id'   => 'post_runtime',
                'type' => 'text',
                'name' => 'Duration(min)',
                'size' => '60',
            ),
            
            array(
				'id'                => 'post_trailer',
				'type'              => 'textarea',
				'name'              => 'Trailer',
				'rows'              => '4',
				'sanitize_callback' => 'none',
				'desc'              => 'Put iframe of video'
            ), 

            array(
                'id'   => 'backdrop_tmdb',
                'type' => 'textarea',
                'name' => 'Backdrop',
                'size' => '60',
            ),

            array(
                'id'   => 'images_tmdb',
                'type' => 'textarea',
                'name' => 'Images',
                'rows' => '4',
            ),

            array(
            	'type' => 'heading',
            	'name' => 'Links',
            ),

            

            array(
            	'id'   => 'post_link_public',
            	'type' => 'text',
            	'name' => 'Public Link',
            	'size' => 60,
            ),

            array(
            	'id'   => 'post_link_premiun',
            	'type' => 'text',
            	'name' => 'Premiun Link',
            	'size' => 60,
            ), 

            array(
            	'type' => 'heading',
            	'name' => 'Images',
            ), 

            array(
            	'id'               => 'post_images',
            	'type'             => 'image_advanced',
            	'name'             => 'Images',
            ),
        ),
    );
    return $meta_boxes;
}