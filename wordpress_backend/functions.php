<?php
/*
/ core
*/

// Add Headless Settings area
require_once 'core/acf-options.php';

// Admin modifications
require_once 'core/admin.php';

// ACF commands
require_once 'core/class-acf-commands.php';

// CORS handling
require_once 'core/cors.php';

// Frontend origin
require_once 'core/frontend-origin.php';

// Logging functions
require_once 'core/log.php';

// Add Menus
require_once 'core/menus.php';

// Customize excerpt length
require_once 'core/excerpt-length.php';


// Redis
require_once 'lib/class-redis-client.php';

// Extend REST
require_once 'lib/class-extend-restapi.php';
new Extend_Restapi();

// Extend REST
require_once 'lib/class-vacancy.php';
new Vacancy();
