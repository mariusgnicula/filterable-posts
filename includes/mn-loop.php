<?php
// query start// check if posts are found

if ( $mn_filter_query->have_posts() ) {
    // if posts are found, check if filter is true    // some may only want to display products, and not have the filter    // if filter is true, load includes/mn-filter.php
    if ( $mn_filter_boolean === true ) {
        include_once('mn-filter.php');
    }
    // if posts are found, echo product archive start tag
    echo '<div class="mn-filter-post__container">';
        // loop through each product
        while ( $mn_filter_query->have_posts() ) {
            $mn_filter_query->the_post();
            // get category classes to use filter with            // get the post categories
            $mn_post_cats = get_the_terms(get_the_ID(), $mn_taxonomy);
            // loop through categories
            $mn_classes = '';
            foreach ( $mn_post_cats as $mn_post_cat ) {
                // add prefix to class to not overwrite other code                // add each to $classes string
                $mn_post_cat_class = ' mn-filter--' . $mn_post_cat->slug;                $mn_classes .= $mn_post_cat_class;

            }
            // echo product start tag            // include $classes
            echo '<div class="mn-filter-post' . $mn_classes . '">';
                // get product image and alt text and echo it with link
                $id = get_the_id();                $feature = get_post( get_post_thumbnail_id( $id ) );                $feature_id = $feature->ID;                $feature_link = wp_get_attachment_image_src( $feature_id, $mn_image_size );                $feature_link = $feature_link[0];                $feature_alt = get_post_meta( $feature_id, '_wp_attachment_image_alt', true);
                echo '<div class="mn-filter-post__image">';
                    echo '<a href="'. get_permalink() .'">';
                        echo '<img src="' . $feature_link . '" alt="' . $feature_alt . '">';
                    echo '</a>';
                echo '</div>';
                // product details                // in this case it's the title, a custom attribute and a link
                echo '<div class="mn-filter-post__details">';
                    the_title('<h2>', '</h2>');
                    // get the attributes                    // only taking the first value for now
                    $mn_attribute_single = get_the_terms(get_the_ID(), $mn_attribute);                    $mn_tag_single = get_the_tags(get_the_ID());
                    if ( $mn_attribute_single ) {
                        $mn_attribute_single = $mn_attribute_single[0];                        $mn_attribute_single = $mn_attribute_single->name;
                        echo '<h3>Lemn de ' . $mn_attribute_single  . '</h3>';
                    } elseif ( $mn_tag_single ) {
                        $mn_tag_single = $mn_tag_single[0];                        $mn_tag_single = $mn_tag_single->name;
                        echo '<h3>' . $mn_tag_single  . '</h3>';
                    } else {
                    }
                    echo '<a class="mn-filter-post__more" href="' . get_permalink() . '">';
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
?>
