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
        'post_type' => 'faq'
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
        'post_type' => 'portfolio'
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


 
 //registerar nya custom endpoints för mitt api
 
 add_action('rest_api_init', function(){
     register_rest_route('me/v1', 'posts', [
        'methods' => 'GET',
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

 });







