<?php
/*
* Plugin Name: MN Filterable Posts
* Plugin URI: https://github.com/mariusgnicula/filterable-products
* Description: A custom widget to display and filter posts and custom post types.
* Version: 0.4
* Author: Marius Nicula
* Author URI: https://www.linkedin.com/in/mariusgnicula
*/

// filterable products function start

function mn_filterable_posts($atts) {

    // set variables
    // default number of posts is -1, but can also be set
    // (to do) if a number of posts is set, we can also make it paged
    // (to do) if custom image size is entered
    // add that image size and regenerate the thumbnails

    $a = shortcode_atts([
        'number' => -1,
        'post-type'=> 'post',
        'taxonomy' => 'category',
        'taxonomy-term' => 'unset',
        'paged' => false,
        'image-size' => 'thumbnail',
        'link-text' => 'Vezi produs',
        'filter' => true
    ], $atts );

    // saving the values into custom variables

    $mn_number = (int)$a['number'];
    $mn_post_type = $a['post-type'];
    $mn_taxonomy = $a['taxonomy'];
    $mn_taxonomy_term = $a['taxonomy-term'];
    $mn_paged = $a['paged'];
    $mn_image_size = $a['image-size'];
    $mn_link_text = $a['link-text'];
    $mn_filter_boolean = $a['filter'];

    // query args

    $mn_args = [
        'post_type'  => $mn_post_type,
        'posts_per_page' => $mn_number
    ];

    // if the specific category is set, show products only from that category
    // if it isn't, show all products

    if ( $mn_taxonomy_term !== 'unset' ) {
        $mn_args['tax_query'] = [[
            'taxonomy' => $mn_taxonomy,
            'field'    => 'slug',
            'terms'    => [ $mn_taxonomy_term ]
		]];
    } else {
        $mn_args['tax'] = $mn_taxonomy;
    }

    // WP_Query declaration

    $mn_filter_query = new WP_Query( $mn_args );

    // include loop
    // less messy code is less messy life

    include_once('includes/mn-loop.php');

    // add script to footer of page
    // only if function was not called already

    if ( !function_exists('mn_script') ) {

        function mn_script() {
    
            echo '<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ) .'js/mn-filter.js"></script>';

        }

        add_action('wp_footer', 'mn_script');

    }

}

add_shortcode('mn_filterable_posts', 'mn_filterable_posts');

?>
