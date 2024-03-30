<?php
/*
Plugin Name: Mostrar Paginas hermanas
Description: Plugin para listar páginas hermanas (hijas de misma página superior)
*/

// Creating the widget
class SPP_Widget extends WP_Widget
{
   public function __construct() {
      parent::__construct(
         'spp_widget',
         'Paginas Hermanas'
      );
   }
   // Front-End
   public function widget($args, $instance) {
      $title = apply_filters('widget_title', $instance['title']);

      echo $args['before_widget'];
         echo $args['before_title'] . $title . $args['after_title'];

      global $post;

      if(has_post_parent($post)) {
         $parent = intval($post->post_parent);
         $current_id = intval($post->ID);
         
         echo '<h3>' . get_the_title($parent) . '</h3>';

         $args = array(
            'child_of'     => $parent,
            'exclude'      => $current_id
         );

         $pages = get_pages($args);

         if(count($pages) > 0):
            echo '<ul>';
            foreach ($pages as $page) {
               echo '<li><i class="fa-solid fa-caret-right"></i> <a href="' . get_page_link($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
            }
            echo '</ul>';
         endif;
      }
      
      echo $args['after_widget'];
   }
}

function spp_register_widget() {
   register_widget( 'spp_widget' );
}

add_action('widgets_init', 'spp_register_widget');