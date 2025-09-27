<?php
require( $file . "/wp-load.php");

global $wpdb;
global $current_user;

$user = $current_user->ID;

$description = $_POST['edit-user-perfil-description'];
$nacimiento = $_POST['edit-user-perfil-nacimiento'];
$pais = $_POST['edit-user-perfil-pais'];
#Se actualiza la descripcion
// sanitize user form input

update_user_meta( $user, 'description', sanitize_text_field( $description ));
update_user_meta( $user, 'nacimiento', sanitize_text_field ($nacimiento ));
update_user_meta( $user, 'pais', sanitize_text_field( $pais ));
$respuesta = json_encode
    ( 
        array(
            'error' => false,
            'extension requerida' => get_allowed_mime_types(),
        )
    );
echo $respuesta;