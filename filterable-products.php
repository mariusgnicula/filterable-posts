<?php
/*
* Plugin Name: MN Filterable Products
* Plugin URI: https://github.com/mariusgnicula/filterable-products
* Description: A custom widget to filter products.
* Version: 0.1
* Author: Marius Nicula
* Author URI: https://www.linkedin.com/in/mariusgnicula
*/

// filterable products function start

function mn_filterable_products($atts) {

    // set variables
    // default number of posts is -1, but can also be set
    // (to do) if a number of posts is set, we can also make it paged
    // (to do) if custom image size is entered
    // add that image size and regenerate the thumbnails
    // (to do) figure out if the attribute is custom

    $a = shortcode_atts([
        'number' => -1,
        'category' => 'unset',
        'paged' => false,
        'image-size' => 'shop_catalog',
        'attribute' => 'pa_tip-lemn',
        'link-text' => 'Vezi produs'
    ], $atts );

    // saving the values into custom variables

    $mn_number = (int)$a['number'];
    $mn_category = $a['category'];
    $mn_paged = $a['paged'];
    $mn_image_size = $a['image-size'];
    $mn_attribute = $a['attribute'];
    $mn_link_text = $a['link-text'];
    $mn_attribute = $a['attribute'];

    // query args

    $mn_args = [
        'post_type'  => 'product',
        'posts_per_page' => $mn_number
    ];

    // if the specific category is set, show products only from that category
    // if it isn't, show all products

    if ( $mn_category !== 'unset' ) {
        $mn_args['tax_query'] = [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => [ $mn_category ]
		]];
    } else {
        $mn_args['tax'] = 'product_cat';
    }

    // WP_Query declaration

    $mn_filter_query = new WP_Query( $mn_args );

    // query start

    if ( $mn_filter_query->have_posts() ) {

        // if posts are found, echo product archive start tag

    	echo '<div class="mn-product__container">';

            // loop through each product

        	while ( $mn_filter_query->have_posts() ) {

        		$mn_filter_query->the_post();

        		// echo product start tag

                echo '<div class="mn-product">';

                    // get product image and alt text and echo it with link

                    $id = get_the_id();
                    $feature = get_post( get_post_thumbnail_id( $id ) );
                    $feature_id = $feature->ID;
                    $feature_link = wp_get_attachment_image_src( $feature_id, $mn_image_size );
                    $feature_link = $feature_link[0];
                    $feature_alt = get_post_meta( $feature_id, '_wp_attachment_image_alt', true);

                    echo '<div class="mn-product__image">';

                        echo '<a href="'. get_permalink() .'">';

                            echo '<img src="' . $feature_link . '" alt="' . $feature_alt . '">';

                        echo '</a>';

                    echo '</div>';

                    // product details
                    // in this case it's the title, a custom attribute and a link

                    echo '<div class="mn-product__details">';

                        the_title('<h2>', '</h2>');

                        // get the attributes
                        // only taking the first value for now

                        $mn_attribute_single = get_the_terms(get_the_ID(), $mn_attribute);
                        $mn_attribute_single = $mn_attribute_single[0];
                        $mn_attribute_single = $mn_attribute_single->name;

                        echo '<h3>Lemn de ' . $mn_attribute_single  . '</h3>';

                        echo '<a class="mn-product__more" href="' . get_permalink() . '">';

                            echo $mn_link_text;

                        echo '</a>';

                    echo '</div>';

                // echo product end tag
                echo '</div>';
        	}

        // echo product archive end tag

    	echo '</div>';

    	// Restore original Post Data

    	wp_reset_postdata();

    } else {
    	// no posts found
    }

}

add_shortcode('mn_filterable_products', 'mn_filterable_products');

?>
