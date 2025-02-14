<?php

//------------------------------------------------------------------------------
// Frontside configuration
//------------------------------------------------------------------------------

define( 'SECURE_SERVER', false );

// Base document directory
//define( 'DIR_BASE', 'C:/Program Files/Apache24/htdocs/' );
define( 'DIR_BASE', 'C:/xampp/htdocs/' );
//define( 'DIR_BASE', '/var/www/html/' );

// Define HTTP path
define( 'HTTP_PATH', 'shop/' );

// HTTP server domain
//define( 'HTTP_SERVER_DOMAIN', '192.168.3.13/' );
define( 'HTTP_SERVER_DOMAIN', 'localhost/' );

//------------------------------------------------------------------------------
// HTTP
//------------------------------------------------------------------------------

define( 'HTTP_SERVER', 'http://' . HTTP_SERVER_DOMAIN . HTTP_PATH );
define( 'HTTP_IMAGE', 'http://' . HTTP_SERVER_DOMAIN . HTTP_PATH . 'image/' );
define( 'HTTP_ADMIN', 'http://' . HTTP_SERVER_DOMAIN . HTTP_PATH . 'admin/' );

//------------------------------------------------------------------------------
// HTTPS
//------------------------------------------------------------------------------

define( 'HTTPS_SERVER', 'https://' . HTTP_SERVER_DOMAIN . HTTP_PATH );
define( 'HTTPS_IMAGE', 'https://' . HTTP_SERVER_DOMAIN . HTTP_PATH . 'image/' );
define( 'HTTPS_ADMIN', 'https://' . HTTP_SERVER_DOMAIN . HTTP_PATH . 'admin/' );

//------------------------------------------------------------------------------
// System directories
//------------------------------------------------------------------------------

define( 'DIR_SYSTEM', DIR_BASE . HTTP_PATH . 'system/' );
define( 'DIR_CONFIG', DIR_BASE . HTTP_PATH . 'config/' );
define( 'DIR_DATABASE', DIR_BASE . HTTP_PATH . 'system/database/' );
define( 'DIR_CACHE', DIR_BASE . HTTP_PATH . 'cache/' );
define( 'DIR_LOGS', DIR_BASE . HTTP_PATH . 'logs/' );

//------------------------------------------------------------------------------
// Application local directories
//------------------------------------------------------------------------------

define( 'DIR_APPLICATION', DIR_BASE . HTTP_PATH . 'catalog/' );
define( 'DIR_LANGUAGE', DIR_BASE . HTTP_PATH . 'catalog/language/' );
define( 'DIR_TEMPLATE', DIR_BASE . HTTP_PATH . 'catalog/view/template/' );
define( 'DIR_STYLESHEET_OLD', 'catalog/view/stylesheet/' );
define( 'DIR_STYLESHEET', DIR_BASE . HTTP_PATH . 'catalog/view/stylesheet/' );
define( 'DIR_IMAGE', DIR_BASE . HTTP_PATH . 'image/' );

define( 'DIR_CLIENT_STYLESHEET', 'catalog/view/stylesheet/' );

//------------------------------------------------------------------------------
// Database configuration
//------------------------------------------------------------------------------

// Online database
//define( 'DB_DRIVER', 'mysqli' );
//define( 'DB_HOSTNAME', '37.120.186.160' );
//define( 'DB_USERNAME', 'shop' );
//define( 'DB_PASSWORD', 'e100cf1aA55aA1FC001E' );
//define( 'DB_DATABASE', 'online' );
//define( 'DB_PREFIX', '' );

// Local database
define( 'DB_DRIVER', 'mysqli' );
define( 'DB_HOSTNAME', '192.168.3.13' );
define( 'DB_USERNAME', 'shop' );
define( 'DB_PASSWORD', 'e100cf1aA55aA1FC001E' );
define( 'DB_DATABASE', 'online' );
define( 'DB_PREFIX', '' );

// VDC global database
define( 'DB_VDC_DRIVER', 'mysqli' );
define( 'DB_VDC_HOSTNAME', '37.120.186.160' );
define( 'DB_VDC_USERNAME', 'vdc_admin' );
define( 'DB_VDC_PASSWORD', 'F4SOT5q55eYaJ4g8KO47Qiz4Le87PA' );
define( 'DB_VDC_DATABASE', 'vdc_database' );
define( 'DB_VDC_PREFIX', '' );

//------------------------------------------------------------------------------
// Mail server configuration
//------------------------------------------------------------------------------

define( 'MAIL_PROTOCOL', 'smtp' );
define( 'MAIL_PARAMETER', '' );
define( 'MAIL_HOSTNAME', 'ssl://mail.anvilex.com' );
define( 'MAIL_USERNAME', 'mail.sender@anvilex.com' );
define( 'MAIL_PASSWORD', '2S4Ehz26Q33SR4_j6Z' );
define( 'MAIL_PORT', 465 );
define( 'MAIL_TIMEOUT', 5 );

//------------------------------------------------------------------------------
// Development
//------------------------------------------------------------------------------

define( 'DEVELOPMENT_SHOW_MESSAGES_SECTION', false );
define( 'DEVELOPMENT_SHOW_LOGGER_SECTION', true );

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>