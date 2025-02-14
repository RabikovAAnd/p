<?php

// Time measurement
//$tm['start'] = microtime();

/*
// ANVILEX : Load time measurement
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
*/

//------------------------------------------------------------------------------
// Include configuration
//------------------------------------------------------------------------------

require_once( 'config.php' );

//------------------------------------------------------------------------------
// Include startup code
//------------------------------------------------------------------------------

require_once( DIR_SYSTEM . 'startup.php' );

// Time measurement
//$tm['include_done'] = microtime();

//------------------------------------------------------------------------------
// Create registry
//------------------------------------------------------------------------------

// Create registry object
$registry = new Registry();

//------------------------------------------------------------------------------
// Create loader
//------------------------------------------------------------------------------

// Create loader object
$loader = new Loader( $registry );

// Register loader object
$registry->set( 'load', $loader );

// Time measurement
//$tm['loader_done'] = microtime();

//------------------------------------------------------------------------------
// Create database
//------------------------------------------------------------------------------

// Create database object
$db = new DB( DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE );
//$db = new DB( DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, null );
$db_vdc = new DB( DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, 'vdc_database' );

// Register database object
$registry->set( 'db', $db );
$registry->set( 'db_vdc', $db_vdc );

// Time measurement
//$tm['db_done'] = microtime();

//------------------------------------------------------------------------------
// Create configuration
//------------------------------------------------------------------------------

// Create configuration object
$config = new Config( $registry );

// Register configuration object
$registry->set( 'config', $config );

//------------------------------------------------------------------------------
// Set server URLs
//------------------------------------------------------------------------------

// Set default values
//$config->set( 'config_url', HTTP_SERVER );
//$config->set( 'config_ssl', HTTPS_SERVER );

// Time measurement
//$tm['db_config_done'] = microtime();

//------------------------------------------------------------------------------
// Url
//------------------------------------------------------------------------------

// Create URL object
//$url = new Url( HTTP_SERVER, $config->get( 'config_secure' ) ? HTTPS_SERVER : HTTP_SERVER );
$url = new Url( HTTP_SERVER, ( SECURE_SERVER == true ) ? HTTPS_SERVER : HTTP_SERVER );

// Register URL object
$registry->set( 'url', $url );

//------------------------------------------------------------------------------
// Log
//------------------------------------------------------------------------------

// Create logging object
$log = new Log();

// Register logging object
$registry->set( 'log', $log );

//------------------------------------------------------------------------------

function error_handler( $errno, $errstr, $errfile, $errline )
{

  global $log, $config;

  switch ($errno)
  {
    case E_NOTICE:
    case E_USER_NOTICE:
      $error = 'Notice';
      break;
    case E_WARNING:
    case E_USER_WARNING:
      $error = 'Warning';
      break;
    case E_ERROR:
    case E_USER_ERROR:
      $error = 'Fatal Error';
      break;
    default:
      $error = 'Unknown';
      break;
  }

// Show error code
//    echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';

  // Log PHP error
  $log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);

  // Return code
  return( true );

}

// Assign error Handler
set_error_handler( 'error_handler' );

// Time measurement
//$tm['error_handler_done'] = microtime();

//------------------------------------------------------------------------------
// Create request
//------------------------------------------------------------------------------

// Create request object
$request = new Request( $registry );

// Register request object
$registry->set( 'request', $request );

// Time measurement
//$tm['request_done'] = microtime();

//------------------------------------------------------------------------------
// Create response
//------------------------------------------------------------------------------

// Create responce object
$response = new Response();

// Add headers
$response->Add_Header( 'Content-Type: text/html; charset=utf-8' );

// Set compression level
$response->Set_Compression_Level( 5 );

// Register responce object
$registry->set( 'response', $response );

// Time measurement
//$tm['responce_done'] = microtime();

//------------------------------------------------------------------------------
// Create cache
//------------------------------------------------------------------------------

// Create cache object
$cache = new Cache();

// Register cache object
$registry->set( 'cache', $cache );

// Time measurement
//$tm['cache_done'] = microtime();

//------------------------------------------------------------------------------
// Create session
//------------------------------------------------------------------------------

// Create session object
$session = new Session();

// Register session object
$registry->set( 'session', $session );

// Time measurement
//$tm['session_done'] = microtime();

//------------------------------------------------------------------------------
// Load active languages
//------------------------------------------------------------------------------

// Language detection
$languages = array();

$query = $db->query( "SELECT * FROM language WHERE status=1" );

foreach ( $query->rows as $result )
{

  $languages[ $result['code'] ] = $result;

}

  //----------------------------------------------------------------------------
  // Request parameter don't have a valid language
  //----------------------------------------------------------------------------

$code = '';

  // Test session for valid language settings
  if ( isset($session->data[ 'language' ] ) && array_key_exists( $session->data[ 'language' ], $languages ) && $languages[ $session->data[ 'language' ] ][ 'status' ] )
  {

    // Use language settings from active session
    $code = $session->data[ 'language' ];

  } 
  else
  {

    //--------------------------------------------------------------------------
    // Session don't have a valid language settings
    //--------------------------------------------------------------------------

    // Test cookie for valid language settings
    if ( isset( $request->cookie[ 'language' ] ) && array_key_exists( $request->cookie[ 'language' ], $languages ) && $languages[ $request->cookie[ 'language' ] ][ 'status' ] )
    {

      // Use language settings from cookie
      $code = $request->cookie[ 'language' ];

    }
    else
    {

      //------------------------------------------------------------------------
      // Cookie don't have a valid language settings
      //------------------------------------------------------------------------

      if ( isset( $request->server[ 'HTTP_ACCEPT_LANGUAGE' ] ) && $request->server[ 'HTTP_ACCEPT_LANGUAGE' ] )
      {

        // Split accepted languages atring
        $browser_languages = explode( ',', $request->server[ 'HTTP_ACCEPT_LANGUAGE' ] );

        // ANVILEX KM: ToDo: this loop can be optimised by 
        foreach ( $browser_languages as $browser_language )
        {

          foreach ( $languages as $key => $value )
          {

            if ( $value[ 'status' ] )
            {

              $locale = explode( ',', $value[ 'locale' ] );

              if ( in_array( $browser_language, $locale ) )
              {

                $code = $key;

                // Terminate search
                break;
                
              }

            }

          }

        }

        if ( $code == '' )
        {

          //----------------------------------------------------------------------
          // Language can not be detected from the browswer information
          //----------------------------------------------------------------------

          // Use default information from the settings
          $code = "EN";

        }

      }
      else
      {

        // Use default information from the settings
        $code = "EN";

      }

    }

  }



// Test for session language not set
if ( !isset( $session->data[ 'language' ] ) || $session->data[ 'language' ] != $code )
{

  // Store language to the session
  $session->data[ 'language' ] = $code;

}

// Test for the cookie language not set
if ( !isset( $request->cookie[ 'language' ] ) || $request->cookie[ 'language' ] != $code )
{

  // Store language to the cookie
  setcookie( 'language', $code, time() + 60 * 60 * 24 * 30, '/', $request->server[ 'HTTP_HOST' ] );

}

//------------------------------------------------------------------------------
// Create language object
//------------------------------------------------------------------------------

// Create language object
$language = new Language( $registry, $code );

// Register language
$registry->set( 'language', $language );

// Time measurement
//$tm['languages_done'] = microtime();

//------------------------------------------------------------------------------
// Get country
//------------------------------------------------------------------------------

// Language detection
$countries = array();

$query = $db->query( "SELECT country_id, iso_code_2, status FROM country WHERE status=1" );

foreach ($query->rows as $result)
{

  $countries[ $result['country_id'] ] = $result;

}

//------------------------------------------------------------------------------

$country_id = 0;

// Test request parameter for valid language
if ( isset( $request->get['country_id'] ) && array_key_exists( $request->get[ 'country_id' ], $countries ) && $countries[ $request->get[ 'country_id' ] ][ 'status' ] )
{

  // Valid country detetected in request parameter
  $country_id = $request->get[ 'country_id' ];

}
else
{

  //----------------------------------------------------------------------------
  // Request parameter don't have a valid country
  //----------------------------------------------------------------------------

  // Test session for valid language settings
  if ( isset( $session->data[ 'country_id' ] ) && array_key_exists( $session->data[ 'country_id' ], $countries ) && $countries[ $session->data[ 'country_id' ] ][ 'status' ] )
  {

    // Use country settings from active session
    $country_id = $session->data[ 'country_id' ];

  } 
  else
  {

    //--------------------------------------------------------------------------
    // Session don't have a valid country settings
    //--------------------------------------------------------------------------

    // Test cookie for valid language settings
    if ( isset( $request->cookie[ 'country_id' ] ) && array_key_exists( $request->cookie[ 'country_id' ], $countries ) && $countries[ $request->cookie[ 'country_id' ] ][ 'status' ] )
    {

      // Use country settings from cookie
      $country_id = $request->cookie[ 'country_id' ];

    }
    else
    {

      //------------------------------------------------------------------------
      // Cookie don't have a valid country settings
      //------------------------------------------------------------------------

      // Use default information from the settings
      $country_id = 1;

    }

  }

}


// Test for session language not set
if ( !isset( $session->data[ 'country_id' ] ) || $session->data[ 'country_id' ] != $country_id )
{

  // Store language to the session
  $session->data[ 'country_id' ] = $country_id;

}

// Test for the cookie language not set
if ( !isset( $request->cookie[ 'country_id' ] ) || $request->cookie[ 'country_id' ] != $country_id )
{

  // Store language to the cookie
  setcookie( 'country_id', $country_id, time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST'] );

}

// Set country id
$config->set( 'config_country_id', $country_id );

//------------------------------------------------------------------------------
// Document
//------------------------------------------------------------------------------

$registry->set( 'document', new Document() );

//------------------------------------------------------------------------------
// Customer
//------------------------------------------------------------------------------

$registry->set( 'customer', new Customer( $registry ) );

//------------------------------------------------------------------------------
// Currency
//------------------------------------------------------------------------------

//$registry->set( 'currency', new Currency( $registry ) );

//------------------------------------------------------------------------------
// Units
//------------------------------------------------------------------------------

//$registry->set( 'units', new Units( $registry ) );

//------------------------------------------------------------------------------
// Warehouse
//------------------------------------------------------------------------------

//$registry->set( 'warehouse', new Warehouse( $registry ) );

//------------------------------------------------------------------------------
// Cart
//------------------------------------------------------------------------------

//$registry->set( 'cart', new Cart( $registry ) );

//------------------------------------------------------------------------------
// Encryption
//------------------------------------------------------------------------------
 
$registry->set( 'encryption', new Encryption( '12345' ) );

//$tm['objects_done'] = microtime();

//------------------------------------------------------------------------------
// Front Controller
//------------------------------------------------------------------------------

$controller = new Front( $registry );

//$tm['front_done'] = microtime();

// Maintenance Mode
//$controller->addPreAction(new Action('common/maintenance'));
//$tm['maintenance_done'] = microtime();

//------------------------------------------------------------------------------

// Route dispatch
$controller->dispatch( ( isset( $request->get[ 'route' ] ) ) ? new Action( $request->get[ 'route' ] ) : new Action( 'api/data' ), new Action( 'error/not_found' ) );

// Time measurement
//$tm['dispatch_done'] = microtime();

// Send responce to client
$response->output();

// Time measurement
//$tm['output_done'] = microtime();

//------------------------------------------------------------------------------

/*
$keys = array_keys($tm);
$last = 0;
foreach ($keys as $key)
{


  $time = explode(' ', $tm[$key]);
  $time = $time[1] + $time[0];

  $delta = round(($time - $last), 4);

  echo $key . ' : ' . $delta . '<br>';
  $last = $time;
}
*/

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>