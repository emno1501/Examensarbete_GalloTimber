<?php
// Customize excerpt length

add_filter( 'excerpt_length', function($length) {
    return 20;
} );