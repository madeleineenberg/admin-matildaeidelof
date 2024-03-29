<?php

/**
 * Plugin Name: Custom API
 * Description: Custom endpoints for Matilda Eidelof website
 * version: 1.0
 * Author: Madeleine Enberg
 * Author URL: https://www.madeleineenberg.com
 */


 //en anpassad endpoint för 'post' och som specificerar hur 'post-datan' ska se ut.

 function me_posts(){
     $args = [
         'numberposts' => 99999,
         'post_type' => 'post' 
     ];
     
     $posts = get_posts($args);

     $data = [];
     $i = 0;

     foreach($posts as $post){
         $data[$i]['id'] = $post->ID;
         $data[$i]['title'] = $post->post_title;
         $data[$i]['content'] = $post->post_content;
         $data[$i]['slug'] = $post->post_name;
         $data[$i]['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'thumbnail');
        $i++;

     }
     return $data;
 };


 function me_add_post(WP_REST_Request $request) {
   
   
   global $wpdb;
   $data = array();

   $parameters = $request->get_params();

   $the_content = $parameters['the_content'];
   $post_title = $parameters['post_title'];

   $my_post = array(
      'post_title' => wp_strip_all_tags( $post_title),
      'post_content' => $the_content,
      'post_status' => 'publish',
   );
   $new_post_id = wp_insert_post($my_post);

   if ($new_post_id) {
      $data['status']='Post added Successfully.';  
  }
  else{
   $data['status']='post failed..';
 } 
  return $data;

   // update_field('me_add_post', $content);
 }




//funktion för att hitta rätt 'post' med 'slug
 function me_post($slug){
    $args = [
        'name' => $slug['slug'],
        'post_type' => 'post' 
    ];

    $post = get_posts($args);
    

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['slug'] = $post[0]->post_name;
    $data['featured_image']['thumbnail'] = get_the_post_thumbnail_url($post[0]->ID, 'thumbnail');

    return $data;

 }


 //Anpassad endpoint för att hämta custom post types för FAQ

 function me_faqs(){
    $args = [
        'numberposts' => 99999,
        'post_type' => 'faq',
        'order' => 'ASC'
    ];
        $posts = get_posts($args);

        $data = [];
        $i = 0;
   
        foreach($posts as $post){
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
            $data[$i]['content'] = $post->post_content;
            $data[$i]['slug'] = $post->post_name;
            $data[$i]['heading'] = get_field('heading', $post->ID);
            $data[$i]['info_text'] = get_field('info_text', $post->ID);
           $i++;
   
        }
        return $data;
 }


 //Anpassad enpoint för portfolio 'grid'
 function me_portfolio(){
    $args = [
        'numberposts' => 99999,
        'post_type' => 'portfolio',
        'order' => 'ASC'
    ];
        $posts = get_posts($args);

        $data = [];
        $i = 0;
   
        foreach($posts as $post){
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
            $data[$i]['class'] = get_field('grid_design', $post->ID);
            $data[$i]['grid'] = get_field('grid', $post->ID);

           $i++;
   
        }
        return $data;
 }
//  //Anpassad enpoint för products
 function me_products(){
    $args = [
        'numberposts' => 99999,
        'post_type' => 'products',
        'order' => 'ASC'
    ];
        $posts = get_posts($args);

        $data = [];
        $i = 0;
   
        foreach($posts as $post){
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
            $data[$i]['product'] = get_field('title', $post->ID);
            $data[$i]['price'] = get_field('price', $post->ID);
            $data[$i]['stock'] = get_field('stock', $post->ID);
            $data[$i]['description'] = get_field('description', $post->ID);
            $data[$i]['image'] = get_field('image', $post->ID);

           $i++;
   
        }
        return $data;
 }

//anpassad endpoint för 'pages'

 function me_pages(){
    $args = [
        'numberposts' => 99999,
        'post_type' => 'page'
    ];
        $posts = get_posts($args);

        $data = [];
        $i = 0;
   
        foreach($posts as $post){
            $data[$i]['id'] = $post->ID;
            $data[$i]['title'] = $post->post_title;
            $data[$i]['content'] = $post->post_content;
            $data[$i]['slug'] = $post->post_name;
            $data[$i]['acf'] = get_fields( $post->ID);
           $i++;
   
        }
        return $data;
 }

//anpassad endpoint för 'pages' via 'slug'
 function me_page_slug($slug){
    $args = [
        'name' => $slug['slug'],
        'post_type' => 'page' 
    ];

    $post = get_posts($args);
    

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['slug'] = $post[0]->post_name;
    $data['acf'] = get_fields($post[0]->ID);

    return $data;

 }


 //anpassad endpoint för 'pages' via id
 function me_page_id($id){
   
    $args = [
        'p' => $id['id'],
        'post_type' => 'page' 
    ];

    $post = get_posts($args);
    

    $data['id'] = $post[0]->ID;
    $data['title'] = $post[0]->post_title;
    $data['content'] = $post[0]->post_content;
    $data['slug'] = $post[0]->post_name;
    $data['acf'] = get_fields($post[0]->ID);

    return $data;


 }

  //anpassad endpoint för footer-settings
//   function me_footer_slug($slug){
//    $args = [
//        'name' => $slug['slug'],
//        'post_type' => 'page' 
//    ];

//    $post = get_posts($args);
   

//    $data['id'] = $post[0]->ID;
//    $data['slug'] = $post[0]->post_name;
//    $data['title'] = get_field('footer_title', $post[0]->ID);
//    $data['email'] = get_field('email', $post[0]->ID);
//    $data['phone'] = get_field('phone', $post[0]->ID);
//    $data['icon_1'] = get_field( 'icon_1', $post[0]->ID);
//    $data['icon_2'] = get_field( 'icon_2', $post[0]->ID);
//    $data['icon_3'] = get_field('icon_3', $post[0]->ID);


//    return $data;

// }
  function me_footer_id($id){
   $args = [
       'p' => $id['id'],
       'post_type' => 'page' 
   ];

   $post = get_posts($args);
   

   $data['id'] = $post[0]->ID;
   $data['slug'] = $post[0]->post_name;
   $data['title'] = get_field('footer_title', $post[0]->ID);
   $data['email'] = get_field('email', $post[0]->ID);
   $data['phone'] = get_field('phone', $post[0]->ID);
   $data['icon_1'] = get_field( 'icon_1', $post[0]->ID);
   $data['icon_2'] = get_field( 'icon_2', $post[0]->ID);
   $data['icon_3'] = get_field('icon_3', $post[0]->ID);


   return $data;

}


 
 //registerar nya custom endpoints för mitt api
 
 add_action('rest_api_init', function(){
     register_rest_route('me/v1', 'posts', [
        'methods' => 'GET, POST',
        'callback' => 'me_posts',
        'permission_callback' => '__return_true'
     ]);

     register_rest_route('me/v1', 'posts/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'me_post',
        'permission_callback' => '__return_true'
     ));

     register_rest_route('me/v1', 'faq', [
        'methods' => 'GET',
        'callback' => 'me_faqs',
        'permission_callback' => '__return_true'
     ]);

     register_rest_route('me/v1', 'portfolio', [
        'methods' => 'GET',
        'callback' => 'me_portfolio',
        'permission_callback' => '__return_true'
     ]);

     register_rest_route('me/v1', 'products', [
        'methods' => 'GET',
        'callback' => 'me_products',
        'permission_callback' => '__return_true'
     ]);

     register_rest_route('me/v1', 'pages', [
        'methods' => 'GET',
        'callback' => 'me_pages',
        'permission_callback' => '__return_true'
     ]);

     register_rest_route('me/v1', 'pages/title/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'me_page_slug',
        'permission_callback' => '__return_true'
     ));

     register_rest_route('me/v1', 'pages/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'me_page_id',
        'permission_callback' => '__return_true'
     ));
     
     register_rest_route('me/v1', 'footer-settings', array(
        'methods' => 'GET',
        'callback' => 'me_footer_slug',
        'permission_callback' => '__return_true'
     ));

     register_rest_route('me/v1', 'footer-settings/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'me_footer_id',
        'permission_callback' => '__return_true'
     ));


     register_rest_route('me/v1', 'posts/add', array(
      'methods' => 'POST',
      'callback' => 'me_add_post',
      'permission_callback' => '__return_true'
      
    ));


 });






