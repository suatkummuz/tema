<?php
if (class_exists('WP_Customize_Control')) {
    class Heading_Customizer extends WP_Customize_Control{
       public $type = 'heading';
       public function render_content(){
            echo '<h2 class="customizer-heading">'.$this->label.'</h2>';
            echo '<hr>';
       } 
    }
}