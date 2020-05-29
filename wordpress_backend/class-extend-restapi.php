<?php


class Extend_Restapi {


    public function __construct() {

        add_action( 'rest_api_init', [$this, 'add_menu_routes'] );
        add_action( 'rest_api_init', [$this, 'extend_post_object'] );
        add_action( 'rest_api_init', [$this, 'custom_rest_route'] );
    }

    public function add_menu_routes(){
        $this->nav_menu_route();
        $this->nav_menu_route2();
        $this->footer_menu_route();
    }

    // Main menu
    public function nav_menu_route( ) { 

        register_rest_route( 'wp/v2', 'nav_menu', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_menu'],
        ));

    } 

    public function get_menu() {
        $items = wp_get_nav_menu_items('2');
        $navitems = array();
        foreach( $items as $key => $item ){
            $navitems[$key] = $item;
            $navitems[$key]->slug = $this->get_slug_from_id($item->object_id);
        }
        return $navitems;
    }

    // Utilities menu
    public function nav_menu_route2( ) { 

        register_rest_route( 'wp/v2', 'nav_menu2', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_menu2'],
        ));

    } 

    public function get_menu2() {
        $items = wp_get_nav_menu_items('3');
        $navitems = array();
        foreach( $items as $key => $item ){
            $navitems[$key] = $item;
            $navitems[$key]->slug = $this->get_slug_from_id($item->object_id);
        }
        return $navitems;
    }

     // Footer menu
     public function footer_menu_route( ) { 

        register_rest_route( 'wp/v2', 'footer_menu', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_footer_menu'],
        ));

    } 

    public function get_footer_menu() {
        $items = wp_get_nav_menu_items('4');
        $navitems = array();
        foreach( $items as $key => $item ){
            $navitems[$key] = $item;
            $navitems[$key]->slug = $this->get_slug_from_id($item->object_id);
        }
        return $navitems;
    }

    private function get_slug_from_id($id) {
        $post = get_post($id); 
        $slug = $post->post_name;
        return $slug;
    } 


    public function extend_post_object() {
        
        // Start page content
        register_rest_field(
            'page',
            'start_content', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_start_content' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );
        
        // Contact info
        register_rest_field(
            'page',
            'contact_meta', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_contact_meta' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Employees
        register_rest_field(
            'page',
            'employees', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_employees' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Google map
        register_rest_field(
            'page',
            'google_maps', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_google_map' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );


        // Job ads
        register_rest_field(
            'jobs',
            'content', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_jobs' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Job ad excerpt
        register_rest_field(
            'jobs',
            'excerpt', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_job_excerpt' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );

        // Kort fakta
        register_rest_field(
            'page',
            'kort_fakta', //New Field Name in JSON RESPONSEs
            array(
                'get_callback' => array( $this, 'get_short_fact' ), // custom function name
                'update_callback' => null,
                'schema' => null,
            )
        );

    }


    public function get_start_content() {
        
        $items = get_field( 'start_content');
       
        if ( empty( $items ) ) {
            return false;
        }

        $startContent = array();
        foreach( $items as $key => $item ){
            $startContent[$key] = $item;
        }
        return $startContent;

    }

    public function get_contact_meta() {
           
        $items = get_field( 'kontaktuppgifter' );
        if ( empty( $items ) ) {
            return false;
        }
        //if (basename(get_page_template($items->ID)) === 'template-contact-us.php') {

            $contactitems = array();
            foreach( $items as $key => $item ){
                $contactitems[$key] = $item; 
            }
            return $contactitems;
        /* } else {
            return null;
        } */
            
    }

    public function get_employees() {
        
        $items = get_field( 'anstalld');
       
        if ( empty( $items ) ) {
            return false;
        }

        $employees = array();
        foreach( $items as $key => $item ){
            $employees[$key] = $item;
        }
        return $employees;

    }

    public function get_google_map() {
        
        $items = get_field( 'google_maps');
       
        if ( empty( $items ) ) {
            return false;
        }

        return $items;

    }

    public function get_jobs() {
        
        $items = get_field( 'job' );
       
        if ( empty( $items ) ) {
            return false;
        }

        $jobs = array();
        foreach( $items as $key => $item ){
            $jobs[$key] = $item;
        }
        
        return $jobs;

    }

    public function get_job_excerpt() {
        
        $items = get_field( 'job_excerpt' );
       
        if ( empty( $items ) ) {
            return false;
        }

        $excerpt = array();
        foreach( $items as $key => $item ){
            $excerpt[$key] = $item;
        }
        
        return $excerpt;

    }

    public function get_short_fact() {
        
        $items = get_field( 'kort_fakta' );
       
        if ( empty( $items ) ) {
            return false;
        }

        $shortFact = array();
        foreach( $items as $key => $item ){
            $shortFact[$key] = $item;
        }
        
        return $shortFact;

    }


    // Adding route for headless settings
    public function custom_rest_route() {
        register_rest_route( 'gallotimber/v1', 'settings', array(
            'methods' => 'GET',
            'callback' => [$this, 'get_settings'],
          ) );
    }

    public function get_settings() {
        
        $items = get_fields( 'headless-settings' );
       
        if ( empty( $items ) ) {
            return false;
        }

        $settings = array();
        foreach( $items as $key => $item ){
            $settings[$key] = $item;
        }

        return $settings;

    }

}

