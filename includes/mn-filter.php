<?php

// mn-filter section of the plugin
// easier to work with includes

// mn-filter start tag

echo '<div class="mn-filter">';

    // get mn-category ID from slug

    // check if taxonomy-term is set

    if ( $mn_taxonomy_term !== 'unset' ) {

        $mn_term = get_term_by('slug', $mn_taxonomy_term, $mn_taxonomy);
        $mn_term_id = $mn_term->term_id;
        $mn_term_children = get_term_children($mn_term_id, $mn_taxonomy);

    } else {

        $mn_terms = get_terms();

        $mn_term_children = [];

        foreach ( $mn_terms as $mn_term ) {
            if ( $mn_term->parent === 0 && $mn_term->taxonomy === $mn_taxonomy ) {
                array_push($mn_term_children, $mn_term->term_id);
            }
        }

    }

    // check if any child terms exist

    if ( $mn_term_children ) {

        // filter loop start tag

        echo '<ul>';

            // add an 'all' category

            echo '<li class="all"><a href="#all">Toate Produsele</a></li>';

            foreach ( $mn_term_children as $mn_term_child ) {

                // get term slug for #link
                // get term name

                $child_term = get_term_by('id', $mn_term_child, $mn_taxonomy);
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
