<?php

// DEBUG: Time measurement
//$tm['start'] = microtime();

/*
// DEBUG : Load time measurement
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
*/

//------------------------------------------------------------------------------
// Include configuration
//------------------------------------------------------------------------------

// Request configuration file
require_once( 'config.php' );

//------------------------------------------------------------------------------
// Include startup code
//------------------------------------------------------------------------------

// Request startup file
require_once( DIR_SYSTEM . 'startup.php' );

//------------------------------------------------------------------------------
// Create registry object
//------------------------------------------------------------------------------

// Create registry object
$registry = new Registry();

//------------------------------------------------------------------------------
// Log object
//------------------------------------------------------------------------------

// Create logging object
$log = new Log();

// Register logging object
$registry->set( 'log', $log );

//------------------------------------------------------------------------------
// Create database object
//------------------------------------------------------------------------------

// Create database object
$db = new DB( DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE );

// Register database object
$registry->set( 'db', $db );

// Create database object
$db_vdc = new DB( DB_VDC_DRIVER, DB_VDC_HOSTNAME, DB_VDC_USERNAME, DB_VDC_PASSWORD, DB_VDC_DATABASE );

// Register database object
$registry->set( 'vdc_database', $db_vdc );

//------------------------------------------------------------------------------
// Create request object
//------------------------------------------------------------------------------

// Create request object
$request = new Request( $registry );

// Register request object
$registry->set( 'request', $request );

//------------------------------------------------------------------------------
// Crerate loader object
//------------------------------------------------------------------------------

// Create loader object
$loader = new Loader( $registry );

// Register loader object
$registry->set( 'load', $loader );

//------------------------------------------------------------------------------
// Create cache object
//------------------------------------------------------------------------------

// Create cache object
$cache = new Cache();

// Register cache object
$registry->set( 'cache', $cache );

//------------------------------------------------------------------------------
// Create session object
//------------------------------------------------------------------------------

// Create session object
$session = new Session();

// Register session object
$registry->set( 'session', $session );

//------------------------------------------------------------------------------

if ( isset( $session->data[ 'request_referer' ] ) )
{
  $session->data[ 'request_prereferer' ] = $session->data[ 'request_referer' ];
}
else
{
  $session->data[ 'request_prereferer' ] = '';
}

$session->data[ 'request_referer' ] = $request->Get_Request_Referer();

//------------------------------------------------------------------------------
// Create location object
//------------------------------------------------------------------------------

// Create location object
$location = new Location( $registry );

// Register location object
$registry->set( 'location', $location );

//------------------------------------------------------------------------------
// Create language object
//------------------------------------------------------------------------------


//------------------------------------------------------------------------------
// Create payment object
//------------------------------------------------------------------------------

// Create payment object
$payment = new Payment( $registry );

// Register payment object
$registry->set( 'payment', $payment );

//------------------------------------------------------------------------------
// Create delivery object
//------------------------------------------------------------------------------

// Create delivery object
$delivery = new Delivery( $registry );

// Register delivery object
$registry->set( 'delivery', $delivery );

//------------------------------------------------------------------------------
// Create messages object
//------------------------------------------------------------------------------

// Create messages object
$messages = new Messages( $registry );

// Register messages
$registry->set( 'messages', $messages );

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

//------------------------------------------------------------------------------
// Url
//------------------------------------------------------------------------------

// Create URL object
//$url = new Url( HTTP_SERVER, $config->get( 'config_secure' ) ? HTTPS_SERVER : HTTP_SERVER );
$url = new Url( HTTP_SERVER, ( SECURE_SERVER == true ) ? HTTPS_SERVER : HTTP_SERVER );

// Register URL object
$registry->set( 'url', $url );

//------------------------------------------------------------------------------
// Error handler function
//------------------------------------------------------------------------------

function error_handler( $errno, $errstr, $errfile, $errline )
{

  // Variables
  global $log, $config;

  // Error number decoder
  switch ( $errno )
  {

    case E_NOTICE:
    case E_USER_NOTICE:
      $error = 'NOTICE';
      break;
    
    case E_WARNING:
    case E_USER_WARNING:
      $error = 'WARNING';
      break;
    
    case E_ERROR:
    case E_USER_ERROR:
      $error = 'ERROR';
      break;
    
   default:
      $error = 'UNKNOWN';
      break;
  
  }
/*
  // Show error
    echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
*/

  // Log PHP error
  $log->Write( 'PHP ' . $error . ': ' . $errstr . ' in ' . $errfile . ' on line ' . $errline );

  // Return code
  return( true );

}

//------------------------------------------------------------------------------

// Assign error handler
set_error_handler( 'error_handler' );

//------------------------------------------------------------------------------
// Create response
//------------------------------------------------------------------------------

// Create responce object
$response = new Response( $registry );

// Add headers
$response->Add_Header( 'Content-Type: text/html; charset=utf-8' );

// Set compression level
$response->Set_Compression_Level( 5 );

// Register responce object
$registry->set( 'response', $response );

//------------------------------------------------------------------------------
// Load active languages
//------------------------------------------------------------------------------

// Language detection
$languages = array();

$query = $db->query( "SELECT * FROM language WHERE status=1" );

foreach ( $query->rows as $result )
{

  $languages[ strtoupper( $result['code'] ) ] = $result;

}

//------------------------------------------------------------------------------

$code = '';

  //----------------------------------------------------------------------------
  // Request parameter don't have a valid language
  //----------------------------------------------------------------------------

  // Log debug message
//  $log->write( 'LANGUAGE : Current session language : ' . $session->data[ 'language_code' ] );
//  $log->write( 'LANGUAGE : Current cookies language : ' . $request->cookie[ 'language_code' ] );

  // Test session for valid language settings
  if ( 
    isset( $session->data[ 'language_code' ] ) && 
    array_key_exists( $session->data[ 'language_code' ], $languages ) && 
    $languages[ $session->data[ 'language_code' ] ][ 'status' ] )
  {

    // Use language settings from active session
    $code = $session->data[ 'language_code' ];

    // Log debug message
//    $log->write( 'LANGUAGE : Session language : ' . $session->data[ 'language_code' ] );

  } 
  else
  {

    //--------------------------------------------------------------------------
    // Session don't have a valid language settings
    //--------------------------------------------------------------------------

    // Test cookie for valid language settings
    if ( isset( 
      $request->cookie[ 'language_code' ] ) && 
      array_key_exists( $request->cookie[ 'language_code' ], $languages ) && 
      $languages[ $request->cookie[ 'language_code' ] ][ 'status' ] )
    {

      // Use language settings from cookie
      $code = $request->cookie[ 'language_code' ];

      // Log debug message
//      $log->write( 'LANGUAGE : Cookie language : ' . $request->cookie[ 'language_code' ] );

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
          $code = 'EN';

        }

      }
      else
      {

        // Use default information from the settings
        $code = 'EN';

      // Log debug message
//      $log->write( 'LANGUAGE : No language in browser' );

      }

    }

  }

//------------------------------------------------------------------------------

$code = strtoupper( $code ); 

if ( isset( $request->cookie[ 'language_code' ] ) === false )
{

  // Store language to the cookie
  setcookie( 'language_code', $code, time() + 60 * 60 * 24 * 30, '/', $request->server[ 'HTTP_HOST' ] );
  
}
else
{
  
  // Test for language code changed
  if ( $request->cookie[ 'language_code' ] != $code )
  {

    // Store language to the cookie
    setcookie( 'language_code', $code, time() + 60 * 60 * 24 * 30, '/', $request->server[ 'HTTP_HOST' ] );

  }
  
}

//------------------------------------------------------------------------------
// Create language object
//------------------------------------------------------------------------------

// Create language object
$language = new Language( $registry, $code );

// Register language object
$registry->set( 'language', $language );

//------------------------------------------------------------------------------
// Get country
//------------------------------------------------------------------------------

// Country detection
$countries = array();

// Compose and execute SQL query to get contries list 
$query = $db->query( "SELECT country_id, iso_code_2, status FROM country WHERE status=1" );

// Load list of countries
foreach ( $query->rows as $result )
{

  $countries[ $result[ 'iso_code_2' ] ] = $result;

}

//------------------------------------------------------------------------------
/*
// Clear country ID
$country_code = 'EN';

// Test session for valid language settings
if ( isset( $session->data[ 'country_code' ] ) && array_key_exists( $session->data[ 'country_code' ], $countries ) && $countries[ $session->data[ 'country_code' ] ][ 'status' ] )
{

  // Use country settings from active session
  $country_code = $session->data[ 'country_code' ];

} 
else
{

  //--------------------------------------------------------------------------
  // Session don't have a valid country settings
  //--------------------------------------------------------------------------

  // Test cookie for valid language settings
  if ( isset( $request->cookie[ 'country_code' ] ) && array_key_exists( $request->cookie[ 'country_code' ], $countries ) && $countries[ $request->cookie[ 'country_code' ] ][ 'status' ] )
  {

    // Use country settings from cookie
    $country_code = $request->cookie[ 'country_code' ];

  }
  else
  {

    //------------------------------------------------------------------------
    // Cookie don't have a valid country settings
    //------------------------------------------------------------------------

    // Use default information from the settings
    $country_code = 'EN';

  }

 }
*/

/*
// Test for session language not set
if ( !isset( $session->data[ 'country_code' ] ) || $session->data[ 'country_code' ] != $country_code )
{

  // Store language to the session
  $session->data['country_code'] = $country_code;

}
*/

// Test for the cookie language not set
if ( !isset( $request->cookie[ 'country_code' ] ) || $request->cookie[ 'country_code' ] != $location->Get_Country_Code() )
{

  // Store language to the cookie
  setcookie( 'country_code', $location->Get_Country_Code(), time() + 60 * 60 * 24 * 30, '/', $request->server['HTTP_HOST'] );

}

// Set country code
$config->set( 'config_country_code', $location->Get_Country_Code() );

//------------------------------------------------------------------------------
// EMail object
//------------------------------------------------------------------------------

// Create mail object
$mail = new Mail();

// Set email properties
$mail->protocol = MAIL_PROTOCOL;
$mail->parameter = MAIL_PARAMETER;
$mail->hostname = MAIL_HOSTNAME;
$mail->username = MAIL_USERNAME;
$mail->password = MAIL_PASSWORD;
$mail->port = MAIL_PORT;
$mail->timeout = MAIL_TIMEOUT;
$mail->setFrom( 'mail.sender@anvilex.com' );
$mail->setSender( 'ANVILEX' );

$registry->set( 'mail', $mail );

//------------------------------------------------------------------------------
// Customer global object
//------------------------------------------------------------------------------

$registry->set( 'customer', new Customer( $registry ) );

//------------------------------------------------------------------------------
// Access control list global object
//------------------------------------------------------------------------------

$registry->set( 'acl', new AccessControlList( $registry ) );

//------------------------------------------------------------------------------
// Currency
//------------------------------------------------------------------------------

$registry->set( 'currency', new Currency( $registry ) );

//------------------------------------------------------------------------------
// Tax ==> Deprecated
//------------------------------------------------------------------------------

$registry->set( 'tax', new Tax( $registry ) );

//------------------------------------------------------------------------------
// Weight ==> Deprecated
//------------------------------------------------------------------------------

$registry->set( 'weight', new Weight( $registry ) );

//------------------------------------------------------------------------------
// Length ==> Deprecated
//------------------------------------------------------------------------------

$registry->set( 'length', new Length( $registry ) );

//------------------------------------------------------------------------------
// Units
//------------------------------------------------------------------------------

$registry->set( 'units', new Units( $registry ) );

//------------------------------------------------------------------------------
// Warehouse
//------------------------------------------------------------------------------

$registry->set( 'warehouse', new Warehouse( $registry ) );

//------------------------------------------------------------------------------
// Cart
//------------------------------------------------------------------------------

$registry->set( 'cart', new Cart( $registry ) );

//------------------------------------------------------------------------------
// Encryption
//------------------------------------------------------------------------------

// Set encryption
$registry->set( 'encryption', new Encryption( '12345' ) );

//------------------------------------------------------------------------------
// Front Controller
//------------------------------------------------------------------------------

// Create front controller
$front_controller = new Front( $registry );

// DEBUG: Time measurement
//$tm['front_done'] = microtime();

// Maintenance Mode
//$front_controller->addPreAction(new Action('common/maintenance'));
//$tm['maintenance_done'] = microtime();

// SEO URL's
//$front_controller->addPreAction(new Action('common/seo_url'));
//$tm['seo_done'] = microtime();

//------------------------------------------------------------------------------
// Initialise objects
//------------------------------------------------------------------------------

$response->Initialise();

$response->server_base = $request->Get_Server_Base();

//------------------------------------------------------------------------------
// Request processing
//------------------------------------------------------------------------------

// Log debug message
$log->Log_Debug( 'SYSTEM : System prepared for request processing.' );

$front_controller->final_action = new Action( 'common/log' );

if ( isset( $request->get[ 'route' ] ) === false )
{

  // Route dispatch
  $front_controller->dispatch( new Action( 'common/home' ), new Action( 'common/not_found' ) );

}
else
{

  // Route dispatch
  $front_controller->dispatch( new Action( $request->get[ 'route' ] ), new Action( 'common/not_found' ) );
  
}

$log->Log_Debug( 'SYSTEM : Request dispatched.' );

// DEBUG: Time measurement
//$tm['dispatch_done'] = microtime();

// Log debug message
//$log->write( 'LANGUAGE : Language before output : ' . $language->Get_Language_Code() );

// Send responce to client
$response->Output();

// DEBUG: Time measurement
//$tm['output_done'] = microtime();

//------------------------------------------------------------------------------
// DEBUG: Show time measirements
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