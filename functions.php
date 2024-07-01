/* Remove Post Type Slug */

// Modify the permalink structure for specified custom post types
function gp_modify_cpt_post_types( $post_link, $post ) {
    $cpt_with_no_slug = array( 'quy_hoach' );

    if ( in_array( $post->post_type, $cpt_with_no_slug ) && 'publish' === $post->post_status ) {
        $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
    }

    return $post_link;
}
add_filter( 'post_type_link', 'gp_modify_cpt_post_types', 10, 2 );

// Ensure the main query includes custom post types without slugs
function gp_add_cpt_post_names_to_main_query( $query ) {
    $cpt_with_no_slug = array( 'post', 'page', 'quy_hoach' );

    if ( ! $query->is_main_query() ) {
        return;
    }

    if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
        return;
    }

    if ( empty( $query->query['name'] ) ) {
        return;
    }

    $query_post_types = $query->get( 'post_type' );
    if ( ! is_array( $query_post_types ) ) {
        $query_post_types = array();
    }

    $query_post_types = array_merge( $query_post_types, $cpt_with_no_slug );
    $query->set( 'post_type', $query_post_types );
}
add_action( 'pre_get_posts', 'gp_add_cpt_post_names_to_main_query' );

/* Add entry meta for custom post type */

// Add support for entry meta in the specified custom post type
add_filter( 'generate_entry_meta_post_types', function( $types ) {
    $types[] = 'quy_hoach';

    return $types;
} );

// Add support for footer meta in the specified custom post type
add_filter( 'generate_footer_meta_post_types', function( $types ) {
    $types[] = 'quy_hoach';

    return $types;
} );
