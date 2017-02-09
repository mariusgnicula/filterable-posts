<?php

// mn-filter section of the plugin
// easier to work with includes

// mn-filter start tag

echo '<div class="mn-filter">';

    // get mn-category ID from slug

    $mn_term = get_term_by('slug', $mn_category, 'product_cat');
    $mn_term_id = $mn_term->term_id;

    // get term children ids

    $mn_term_children = get_term_children($mn_term_id, 'product_cat');

    // check if any child terms exist

    if ( $mn_term_children ) {

        // filter loop start tag

        echo '<ul>';

            // add an 'all' category

            echo '<li class="all"><a href="#all">Toate Produsele</a></li>';

            foreach ( $mn_term_children as $mn_term_child ) {

                // get term slug for #link
                // get term name

                $child_term = get_term_by('id', $mn_term_child, 'product_cat');
                $child_term_slug = $child_term->slug;
                $child_term_name = $child_term->name;

                // item start tag

                echo '<li>';

                    // adding prefix so as to not overwrite possible classes

                    echo '<a href="#mn-filter--' . $child_term_slug . '">';

                        echo $child_term_name;

                    echo '</a>';

                // item end tag

                echo '</li>';

            }

        // filter loop end tag

        echo '</ul>';
    }

// mn-filter end tag

echo '</div>';

?>
