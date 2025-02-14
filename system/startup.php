<?php

//------------------------------------------------------------------------------
// Error reporting settings
//------------------------------------------------------------------------------

// Error Reporting
error_reporting( E_ALL );

//------------------------------------------------------------------------------
// Globals
//------------------------------------------------------------------------------

// Register globals
if ( ini_get( 'register_globals' ) )
{

  ini_set( 'session.use_cookies', 'On' );
  ini_set( 'session.use_trans_sid', 'Off' );

  session_set_cookie_params( 0, '/' );
  session_start();

  $globals = array( $_REQUEST, $_SESSION, $_SERVER, $_FILES );

  foreach ( $globals as $global )
  {

    foreach( array_keys( $global ) as $key )
    {

      unset( ${$key} );

    }

  }

}

//------------------------------------------------------------------------------
// Process magic quotes
//------------------------------------------------------------------------------

// Magic Quotes Fix
if ( ini_get( 'magic_quotes_gpc' ) )
{

  //----------------------------------------------------------------------------

  function clean( $data )
  {

    // Test for data is an array
    if ( is_array( $data ) )
    {

      // Clean each array element
      foreach ( $data as $key => $value )
      {

        // Clean key and value
        $data[ clean( $key ) ] = clean( $value );

      }

    }
    else
    {

      // Strip slashes from the string
      $data = stripslashes( $data );

    }

    // Return cleaned data
    return $data;

  }

  //----------------------------------------------------------------------------

  // Clean GET data
  $_GET = clean( $_GET );

  // Clean POST data
  $_POST = clean( $_POST );

  // Clean REQUEST data
  $_REQUEST = clean( $_REQUEST );

  // Clean COOKIE
  $_COOKIE = clean( $_COOKIE );

}

//------------------------------------------------------------------------------
// Fix not setted timezone
// ANVILEX KM: Timezone must be retrived from user agent
//------------------------------------------------------------------------------

if ( !ini_get( 'date.timezone' ) )
{

  // Set UTC as default time zone
  date_default_timezone_set( 'UTC' );

}

//------------------------------------------------------------------------------
// Support Windows IIS
//------------------------------------------------------------------------------

// Windows IIS Compatibility
if ( !isset( $_SERVER[ 'DOCUMENT_ROOT' ] ) )
{

  if ( isset( $_SERVER[ 'SCRIPT_FILENAME' ] ) )
  {

    $_SERVER[ 'DOCUMENT_ROOT' ] = str_replace( '\\', '/', substr( $_SERVER[ 'SCRIPT_FILENAME' ], 0, 0 - strlen( $_SERVER[ 'PHP_SELF' ] ) ) );

  }

}

//------------------------------------------------------------------------------
// Check document root
// ANVILEX KM: Actualy this is error condition. Document root must be set always
//------------------------------------------------------------------------------

// Test for document root not set
if ( !isset( $_SERVER[ 'DOCUMENT_ROOT' ] ) )
{

  if ( isset( $_SERVER[ 'PATH_TRANSLATED' ] ) )
  {

    $_SERVER[ 'DOCUMENT_ROOT' ] = str_replace( '\\', '/', substr( str_replace( '\\\\', '\\', $_SERVER[ 'PATH_TRANSLATED' ] ), 0, 0 - strlen( $_SERVER[ 'PHP_SELF' ] ) ) );
  
  }

}

//------------------------------------------------------------------------------

// Test for request URI not set
if ( !isset( $_SERVER[ 'REQUEST_URI' ] ) )
{

  $_SERVER[ 'REQUEST_URI' ] = substr( $_SERVER[ 'PHP_SELF' ], 1 );

  if ( isset( $_SERVER[ 'QUERY_STRING' ] ) )
  {

    $_SERVER[ 'REQUEST_URI' ] .= '?' . $_SERVER[ 'QUERY_STRING' ];
  
  }

}

//------------------------------------------------------------------------------
// Check HTTP host
// ANVILEX KM: Actually this is error condition.
//------------------------------------------------------------------------------

// Test for HTTP host not set
if ( !isset( $_SERVER[ 'HTTP_HOST' ] ) )
{

  // Set HTTP host from envirinment
  $_SERVER[ 'HTTP_HOST' ] = getenv( 'HTTP_HOST' );

}

//------------------------------------------------------------------------------
// Include helper files
//------------------------------------------------------------------------------

require_once( DIR_SYSTEM . 'helper/general.php' );
require_once( DIR_SYSTEM . 'helper/json.php' );
require_once( DIR_SYSTEM . 'helper/utf8.php' );

//------------------------------------------------------------------------------
// Include engine files
//------------------------------------------------------------------------------

require_once( DIR_SYSTEM . 'engine/action.php' );
require_once( DIR_SYSTEM . 'engine/controller.php' );
require_once( DIR_SYSTEM . 'engine/front.php' );
require_once( DIR_SYSTEM . 'engine/loader.php' );
require_once( DIR_SYSTEM . 'engine/model.php' );
require_once( DIR_SYSTEM . 'engine/registry.php' );

//------------------------------------------------------------------------------
// Include common fies
//------------------------------------------------------------------------------

require_once( DIR_SYSTEM . 'library/db.php' );
require_once( DIR_SYSTEM . 'library/messages.php' );
require_once( DIR_SYSTEM . 'library/session.php' );
require_once( DIR_SYSTEM . 'library/log.php' );
require_once( DIR_SYSTEM . 'library/request.php' );
require_once( DIR_SYSTEM . 'library/response.php' );
require_once( DIR_SYSTEM . 'library/language.php' );
require_once( DIR_SYSTEM . 'library/location.php' );
require_once( DIR_SYSTEM . 'library/customer.php' );
require_once( DIR_SYSTEM . 'library/acl.php' );

require_once( DIR_SYSTEM . 'library/cache.php' );
require_once( DIR_SYSTEM . 'library/url.php' );
require_once( DIR_SYSTEM . 'library/config.php' );
require_once( DIR_SYSTEM . 'library/encryption.php' );
require_once( DIR_SYSTEM . 'library/image.php' );
require_once( DIR_SYSTEM . 'library/payment.php' );
require_once( DIR_SYSTEM . 'library/delivery.php' );
require_once( DIR_SYSTEM . 'library/mail.php' );
require_once( DIR_SYSTEM . 'library/pagination.php' ); // Depricated ==> To remove in the future
require_once( DIR_SYSTEM . 'library/template.php' );
require_once( DIR_SYSTEM . 'library/currency.php' );
require_once( DIR_SYSTEM . 'library/units.php' );
require_once( DIR_SYSTEM . 'library/cart.php' );
require_once( DIR_SYSTEM . 'library/warehouse.php' );


require_once( DIR_SYSTEM . 'library/tax.php' ); // Depricated ==> To remove in the future
require_once( DIR_SYSTEM . 'library/weight.php' ); // Depricated ==> To remove in the future
require_once( DIR_SYSTEM . 'library/length.php' ); // Depricated ==> To remove in the future

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>