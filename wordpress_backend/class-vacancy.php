<?php
// Kod skapad av Daniel Pihlström på Cybercom Sundsvall.
// Parametrar i labels är ändrade av mig (Emma Norgren)
class Vacancy {
    const CPT            = 'jobs';
    public function __construct() {
        add_action( 'init', [$this, 'register_post_type'] );
    }
    public function register_post_type( ) { 
        $labels = array(
            'name' => _x( 'Jobb', 'openaid-textdomain' ),
            'singular_name' => _x( 'Jobb', 'openaid-textdomain' ),
            'menu_name' => _x( 'Jobb', 'openaid-textdomain' ),
            'name_admin_bar' => _x( 'Jobb',  'openaid-textdomain' ),
            'add_new' => _x( 'Lägg till nytt', 'openaid-textdomain' ),
            'add_new_item' => __( 'Lägg till jobbannons', 'openaid-textdomain' ),
            'new_item' => __( 'Ny jobbannons', 'openaid-textdomain' ),
            'edit_item' => __( 'Redigera jobbannons', 'openaid-textdomain' ),
            'view_item' => __( 'Visa jobbannons', 'openaid-textdomain' ),
            'all_items' => __( 'Alla jobbannonser', 'openaid-textdomain' ),
            'search_items' => __( 'Sök', 'openaid-textdomain' ),
            'not_found' => __( 'Inga jobb hittades', 'openaid-textdomain' ),
            'not_found_in_trash' => __( 'Inga jobb hittades i papperskorg', 'openaid-textdomain' ),
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-media-document',
            'supports' => array( 'title'),
            'rewrite' => array( 'slug' => 'jobs' ),
            'show_in_rest' => true
        );
        register_post_type( self::CPT, $args );
    }
}