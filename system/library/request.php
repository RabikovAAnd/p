<?php

class Request
{

  //----------------------------------------------------------------------------
  // Public variables
  //----------------------------------------------------------------------------

  public $get = array();
  public $post = array();
  public $request = array();
  public $cookie = array();
  public $files = array();
  public $server = array();

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

  private $db;

  private $request_ip;
  private $request_hash;
  private $request_timestamp;
  private $request_time;
  private $request_random;
  private $request_url;
  private $request_referer;
  private $request_prereferer;

  //----------------------------------------------------------------------------
  // Constructor method
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Set request time
    $this->request_time = time();

    // Set random value
    //! @todo ANVILEX KM: That is this
    $this->request_random = rand();

    // Assign database
    $this->db = $registry->get( 'db' );

    //--------------------------------------------------------------------------
    // Clean server variables
    //--------------------------------------------------------------------------

    // Clean server variables
    $_GET = $this->clean( $_GET );
    $_POST = $this->clean( $_POST );
    $_REQUEST = $this->clean( $_REQUEST );
    $_COOKIE = $this->clean( $_COOKIE );
    $_FILES = $this->clean( $_FILES );
    $_SERVER = $this->clean( $_SERVER );

    // Assing server parameters for local usage
    $this->get = $_GET;
    $this->post = $_POST;
    $this->request = $_REQUEST;
    $this->cookie = $_COOKIE;
    $this->files = $_FILES;
    $this->server = $_SERVER;

    //--------------------------------------------------------------------------
    // Get remote IP
    //--------------------------------------------------------------------------

    // Test for remote address setted
    if ( isset( $this->server[ 'REMOTE_ADDR' ] ) === false )
    {

      //------------------------------------------------------------------------
      // Remote address not set
      //------------------------------------------------------------------------

      //! @todo Log notice

      // Set default remote ip
      $this->request_ip = ip2long( '0.0.0.0' );

    }
    else
    {

      //------------------------------------------------------------------------
      // Remote address setted
      //------------------------------------------------------------------------

      // Store remote ip
      $this->request_ip = ip2long( $this->server[ 'REMOTE_ADDR' ] );

    }

    //--------------------------------------------------------------------------
    //
    //--------------------------------------------------------------------------

    // Test for host and request URL setted
    if (
      ( isset( $this->server[ 'HTTP_HOST' ] ) === false ) ||
      ( isset( $this->server[ 'REQUEST_URI' ] ) === false )
    )
    {

      //------------------------------------------------------------------------
      // Server host or request URI not set
      //------------------------------------------------------------------------

      // Set default request URL
      $this->request_url = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Server host or request URI seted
      //------------------------------------------------------------------------

      // Store request URL
      $this->request_url = 'http://' . $this->server[ 'HTTP_HOST' ] . $this->server[ 'REQUEST_URI' ];

    }

    //--------------------------------------------------------------------------
    // Process request referrer and pre-referrer
    //--------------------------------------------------------------------------

    // ANVILEX: Test for HTTPS request

    // Update prereferer
    $this->request_prereferer = $this->request_referer;

    // Test for refferer setted
    if ( isset( $this->server[ 'HTTP_REFERER' ] ) === false )
    {

      //------------------------------------------------------------------------
      // Referrer not set
      //------------------------------------------------------------------------

      // Set default request refferer
      $this->request_referer = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Referrer setted
      //------------------------------------------------------------------------

      // Store request refferer
      $this->request_referer = $this->server[ 'HTTP_REFERER' ];

    }

    //--------------------------------------------------------------------------
    // Process cookie
    //--------------------------------------------------------------------------

    // Test for the ANVILEX cookie set
    if ( isset( $this->cookie[ 'ANVILEX' ] ) == false )
    {

      //------------------------------------------------------------------------
      // ANVILEX hash not setted
      //------------------------------------------------------------------------

      // Set default hash value
      $this->request_hash = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // ANVILEX hash setted
      //------------------------------------------------------------------------

      // Get hash valus
      $this->request_hash = $this->cookie[ 'ANVILEX' ];

    }

    //--------------------------------------------------------------------------
    // Process cookies
    //--------------------------------------------------------------------------

    // Test for the ANVILEX cookie set
    if ( isset( $this->cookie[ 'ANVILEX' ] ) === false )
    {

      //------------------------------------------------------------------------
      // ANVILEX hash not setted, set it
      //------------------------------------------------------------------------

      // Compose cookie string
      $cookie_string = sprintf( '%08x', $this->request_ip ) . sprintf( '%08x', $this->request_time ) . sprintf( '%08x', $this->request_random );

      // Encode and set hash value
      $this->request_hash = base64_encode( pack( 'H*', $cookie_string ) );

      // Store hash to the cookie
      setcookie( 'ANVILEX', $this->request_hash, strtotime( '+730 days' ), '/', $this->server[ 'HTTP_HOST' ] );

    }

    //--------------------------------------------------------------------------
    // Log request in database
    //--------------------------------------------------------------------------

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`requests` " .
      "SET " .
        "`requests`.`ip`=" . $this->request_ip . ", " .
        "`requests`.`timestamp`=" . $this->request_time . ", " .
        "`requests`.`hash`='" . $this->db->escape( $this->request_hash ) . "', " .
        "`requests`.`url`='" . $this->db->escape( $this->request_url ) . "', " .
        "`requests`.`referer`='" . $this->db->escape( $this->request_referer ) . "'";

    // Query database
//    $this->db->query( $sql );

  }

  //----------------------------------------------------------------------------
  // Get server base
  //----------------------------------------------------------------------------

  public function Get_Server_Base()
  {

    if (
      isset( $this->server[ 'HTTPS' ] ) &&
      ( ( $this->server[ 'HTTPS' ] == 'on' ) ||
      ( $this->server[ 'HTTPS' ] == '1' ) )
    )
    {
      $server = HTTPS_SERVER;
    }
    else
    {
      $server = HTTP_SERVER;
    }

    return( $server );

  }

  //----------------------------------------------------------------------------
  // Clean request data method
  //----------------------------------------------------------------------------

  public function clean( $data )
  {

    // Test for request is an array
    if ( is_array( $data ) === true )
    {

      //------------------------------------------------------------------------
      // Request is an array
      //------------------------------------------------------------------------

      // Iterate over all array items
      foreach ( $data as $key => $value )
      {

        // Remove request entry given by key
        unset( $data[ $key ] );

        // Store cleaned key value paar
        $data[ $this->clean( $key ) ] = $this->clean( $value );

      }

    }
    else
    {

      //------------------------------------------------------------------------
      // Request is not an array
      //------------------------------------------------------------------------

      // Convert HTML representation to regular representation
      $data = htmlspecialchars( $data, ENT_COMPAT, 'UTF-8' );

    }

    // Return cleaned data
    return ( $data );

  }

  //----------------------------------------------------------------------------
  // Get request hash method
  //----------------------------------------------------------------------------

  public function Get_Request_Hash()
  {

    // Return request hash
    return ( $this->request_hash );

  }

  //----------------------------------------------------------------------------
  // Get request IP method
  //----------------------------------------------------------------------------

  public function Get_Request_IP()
  {

    // Return request IP
    return ( $this->request_ip );

  }

  //----------------------------------------------------------------------------
  // Get request referer
  //----------------------------------------------------------------------------

  public function Get_Request_Referer()
  {

    // Return request referer
    return ( $this->request_referer );

  }

  //----------------------------------------------------------------------------
  // Get request pre-referer
  //----------------------------------------------------------------------------

  public function Get_Request_Prereferer()
  {

    // Return request prereferer
    return ( $this->request_prereferer );

  }

  //----------------------------------------------------------------------------
  // Is GET request
  //----------------------------------------------------------------------------

  public function Is_GET_Request() : bool
  {

    // Return status
    return( $this->server[ 'REQUEST_METHOD' ] == 'GET' );

  }

  //----------------------------------------------------------------------------
  // Is POST request
  //----------------------------------------------------------------------------

  public function Is_POST_Request() : bool
  {

    // Return status
    return( $this->server[ 'REQUEST_METHOD' ] == 'POST' );

  }

  //----------------------------------------------------------------------------
  // GET parameter exists method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Exists( $name ) : bool
  {

    // Return status
    return ( isset( $this->get[ (string)$name] ) === true );

  }

  //----------------------------------------------------------------------------
  // POST parameter exists method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Exists( $name ) : bool
  {

    // Return status
    return ( isset( $this->post[ (string)$name ] ) === true );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter boolean method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Boolean( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for valid boolean value
      if (
        ( $this->get[ (string)$name ] !== 'true' ) &&
        ( $this->get[ (string)$name ] !== 'false' )
      )
      {

        //----------------------------------------------------------------------
        // Parameter is not valid boolean value
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter is valid boolean value
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter boolean method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Boolean( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for valid boolean value
      if (
        ( $this->post[ (string)$name ] !== 'true' ) &&
        ( $this->post[ (string)$name ] !== 'false' )
      )
      {

        //----------------------------------------------------------------------
        // Parameter is not valid boolean value
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter is valid boolean value
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter array of boolean method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Array_Of_Boolean( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Init array parameter found status
    $array_parameter_found = false;

    // Set parameter valid flag
    $array_parameter_value_valid = true;

    // Iterate over all post parameters
    foreach ( $this->post as $post_parameter_name => $post_parameter_value )
    {

      // Test for array parameter found
      if ( str_starts_with( (string)$post_parameter_name, (string)$name . '_' ) === true )
      {

        //----------------------------------------------------------------------
        // Array parameter found
        //----------------------------------------------------------------------

        // Set array parameter found status
        $array_parameter_found = true;

        // Test for valid boolean value
        if (
          ( $this->post[ (string)$post_parameter_name ] !== 'true' ) &&
          ( $this->post[ (string)$post_parameter_name ] !== 'false' )
        )
        {

          //--------------------------------------------------------------------
          // Parameter is not valid boolean value
          //--------------------------------------------------------------------

          // Set error code
          $array_parameter_value_valid = false;

        }

      }

    }

    //--------------------------------------------------------------------------
    // Process return code
    //--------------------------------------------------------------------------

    if ( $array_parameter_found === false )
    {

      //------------------------------------------------------------------------
      // Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Test for parameter value valid
      if ( $array_parameter_value_valid === false )
      {

        //------------------------------------------------------------------------
        // Parameter found and value not a valid boolean value
        //------------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //------------------------------------------------------------------------
        // Parameter found and value a valid boolean value
        //------------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter certain size string method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Certain_Size_String( $name, $minimum_length = 0, $maximum_length = 255 ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter value set
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $string = trim( rawurldecode( (string)$this->get[ (string)$name ] ) );

      // Test length of the string
      if (
        ( utf8_strlen( $string ) < $minimum_length ) ||
        ( utf8_strlen( $string ) > $maximum_length )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // String length valid
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter certain size string method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Certain_Size_String( $name, $minimum_length = 0, $maximum_length = 255 ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter value set
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $string = trim( rawurldecode( (string)$this->post[ (string)$name ] ) );

      // Test length of the string
      if (
        ( utf8_strlen( $string ) < $minimum_length ) ||
        ( utf8_strlen( $string ) > $maximum_length )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // String length valid
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter positive integer method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Positive_Integer( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for parameter is numeric
      if ( ctype_digit( (string)$this->get[ (string)$name ] ) == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameter is not numeric
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter is numeric
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter positive integer method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Positive_Integer( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for parameter is numeric
      if ( ctype_digit( (string)$this->post[ (string)$name ] ) == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Parameter is not numeric
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter is numeric
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Post parameter method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Email( $name )
  {

    // Test for parameter exists
    if ( $this->Is_POST_Parameter_Exists( $name ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Get parameter value
      $value = trim( rawurldecode( (string)$this->post[ (string)$name ] ) );

      if ( $value === '' )
      {

//        return array("check" => false, "response" => "empty_email_error");

        // Set error code
        $return_code = false;

      }
      else
      {

        $atPos = strpos( $value, '@' );
        $domain = substr( $value, $atPos + 1 );

        if ( ! filter_var( $value, FILTER_VALIDATE_EMAIL ) )
        {

          // Set error code
          $return_code = false;

        }
        else
        {

          if ( !checkdnsrr( $domain, 'MX' ) )
          {

            // Set error code
            $return_code = false;

          }
          else
          {

            // Set error code
            $return_code = true;

          }

        }

      }

    }

    // Return success/error code
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  //! @todo ANVILEX KM: DEPRECATED, to remove

  public function Post_Parameter_Is_Mail( $parameter_name )
  {

    if (!$this->Is_POST_Parameter_Exists($parameter_name))
    {
      return array("check" => false, "response" => "email_not_exist_error");
    }
    else
    {
      $value = rawurldecode((string)$this->post[(string)$parameter_name]);
      if ($value === '')
      {
        return array("check" => false, "response" => "empty_email_error");
      }
      $atPos = strpos($value, '@');
      $domain = substr($value, $atPos + 1);
      if (!filter_var($value, FILTER_VALIDATE_EMAIL))
      {
        return array("check" => false, "response" => "invalid_email_format_error");
      } else if (!checkdnsrr($domain, 'MX')) {
      return array("check" => false, "response" => "invalid_email_domain_error");
      } else {
        return array("check" => true, "response" => $value);
      }
    }
  }

  //----------------------------------------------------------------------------
  // Is GET parameter ID string method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_ID( $name ) : bool
  {

    // Test for parameter value set
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $id = trim( (string)$this->get[ (string)$name ] );

      // Test length of the ID string
      if (
        ( strlen( $id ) == 0 ) ||
        ( strlen( $id ) > 11 )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid ID string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // ID string length valid
        //----------------------------------------------------------------------

        // Test ID string for valid characters
        if ( ctype_digit( $id ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // ID string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter ID string method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_ID( $name ) : bool
  {

    // Test for parameter value set
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $id = trim( (string)$this->post[ (string)$name ] );

      // Test length of the ID string
      if (
        ( strlen( $id ) == 0 ) ||
        ( strlen( $id ) > 11 )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid ID string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // ID string length valid
        //----------------------------------------------------------------------

        // Test ID string for valid characters
        if ( ctype_digit( $id ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // ID string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter GUID string method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_GUID( $name ) : bool
  {

    // Test for parameter value set
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $guid = trim( (string)$this->get[ (string)$name ] );

      // Test length of the GUID string
      if ( strlen( $guid ) != 32 )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid GUID string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // GUID string length valid
        //----------------------------------------------------------------------

        // Test GUID string for valid characters
        if ( ctype_xdigit( $guid ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // GUID string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter GUID string method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_GUID( $name ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter value set
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $guid = trim( (string)$this->post[ (string)$name ] );

      // Test length of the GUID string
      if ( strlen( $guid ) != 32 )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid GUID string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // GUID string length valid
        //----------------------------------------------------------------------

        // Test GUID string for valid characters
        if ( ctype_xdigit( $guid ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // GUID string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter password string method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Password( $name, $minimum_length = 0, $maximum_length = 255 ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter value set
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $password = trim( rawurldecode((string)$this->get[ (string)$name ] ));

      // Test length of the password string
      if (
        ( strlen( $password ) < $minimum_length ) ||
        ( strlen( $password ) > $maximum_length )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid password string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Password string length valid
        //----------------------------------------------------------------------
/*
        // Test password string for valid characters
        if ( ctype_xdigit( $password ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Password string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }
*/
        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter password string method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Password( $name, $minimum_length = 0, $maximum_length = 255 ) : bool
  {

    // Init return code
    $return_code = false;

    // Test for parameter value set
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not found
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter found
      //------------------------------------------------------------------------

      // Get parameter value
      $password = trim( rawurldecode( (string)$this->post[ (string)$name ] ) );

      // Test length of the password string
      if (
        ( strlen( $password ) < $minimum_length ) ||
        ( strlen( $password ) > $maximum_length )
      )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid password string length
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Password string length valid
        //----------------------------------------------------------------------
/*
        // Test password string for valid characters
        if ( ctype_xdigit( $password ) === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Invalid characrers found
          //--------------------------------------------------------------------

          // Set error code
          $return_code = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Password string valid
          //--------------------------------------------------------------------

          // Set success code
          $return_code = true;

        }
*/
        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter datetime method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_DateTime( $name, $format = 'Y-m-d H:i:s' )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Get date from parameter string
      $date = (string)$this->get[ (string)$name ];

      // Create date object from parameter string using format
      $composed_date = DateTime::createFromFormat( $format, $date );

      // Compose status
      $return_code = $composed_date && ( $composed_date->format( $format ) == $date );

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter datetime method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_DateTime( $name, $format = 'Y-m-d H:i:s' )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Get date from parameter string
      $date = (string)$this->post[ (string)$name ];

      // Create date object from parameter string using format
      $composed_date = DateTime::createFromFormat( $format, $date );

      // Compose status
      $return_code = $composed_date && ( $composed_date->format( $format ) == $date );

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter date method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Date( $name, $format = 'Y-m-d' )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Get date from parameter string
      $date = (string)$this->get[ (string)$name ];

      // Create date object from parameter string using format
      $composed_date = DateTime::createFromFormat( $format, $date );

      // Compose status
      $return_code = $composed_date && ( $composed_date->format( $format ) == $date );

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter date method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Date( $name, $format = 'Y-m-d' )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Get date from parameter string
      $date = (string)$this->post[ (string)$name ];

      // Create date object from parameter string using format
      $composed_date = DateTime::createFromFormat( $format, $date );

      // Compose status
      $return_code = $composed_date && ( $composed_date->format( $format ) == $date );

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is GET parameter enum method
  //----------------------------------------------------------------------------

  public function Is_GET_Parameter_Enum( $name, $values )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->get[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for parameter value is in enum values list
      if ( in_array( (string)$this->get[ (string)$name ], $values, false ) === false )
      {
        
        //----------------------------------------------------------------------
        // Value is not in enum values list
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Value is in enum values list
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is POST parameter enum method
  //----------------------------------------------------------------------------

  public function Is_POST_Parameter_Enum( $name, $values )
  {

    // Init return code
    $return_code = false;

    // Test for parameter exists
    if ( isset( $this->post[ (string)$name ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Parameter not exists
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Parameter exists
      //------------------------------------------------------------------------

      // Test for parameter value is in enum values list
      if ( in_array( (string)$this->post[ (string)$name ], $values, false ) === false )
      {
        
        //----------------------------------------------------------------------
        // Value is not in enum values list
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Value is in enum values list
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return error/succcess code
    return ( $return_code );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as a boolean method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_Boolean( $name ) : bool
  {

    // Return parameter as boolean
    return ( ( trim( $this->get[ (string)$name ] ) === 'true' ) ? true : false );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a boolean method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_Boolean( $name ) : bool
  {

    // Return parameter as boolean
    return ( ( trim( $this->post[ (string)$name ] ) === 'true' ) ? true : false );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as an array of boolean method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_Array_Of_Boolean( $name )
  {

    // Initialise parameter list
    $parameter_list = array();

    // Iterate over all post parameters
    foreach ( $this->post as $post_parameter_name => $post_parameter_value )
    {

      // Test for array parameter found
      if ( str_starts_with( (string)$post_parameter_name, (string)$name . '_' ) === true )
      {

        //----------------------------------------------------------------------
        // Array parameter found
        //----------------------------------------------------------------------

        // Get GUID by striping parameter name at the beginning of the parameter name
        $post_parameter_key = str_replace( (string)$name . '_', '', $post_parameter_name );

        // Append GUID - Value pair
        $parameter_list[] = array(
          $post_parameter_key => ( $post_parameter_value === 'true' ) ? true : false
        );

      }

    }

    // Return parameter list as an array
    return ( $parameter_list );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as a string method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_String( $name ) : string
  {

    // Return parameter as string
    return ( (string)( rawurldecode( $this->get[ (string)$name ] ) ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a string method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_String( $name ) : string
  {

    // Return parameter as string
    return ( rawurldecode( (string)( $this->post[ (string)$name ] ) ) );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as a numeric ID string method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_ID( $name ) : string
  {

    // Return parameter value as an ID string
    return ( trim( (string)( $this->get[ (string)$name ] ) ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a numeric ID string method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_ID( $name ) : string
  {

    // Return parameter value as an ID string
    return ( trim( (string)( $this->post[ (string)$name ] ) ) );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as an upper cased GUID string method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_GUID( $name ) : string
  {

    // Return parameter value as an upper cased GUID string
    return ( strtoupper( trim( rawurldecode( (string)( $this->get[ (string)$name ] ) ) ) ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as an upper cased GUID string method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_GUID( $name ) : string
  {

    // Return parameter value as an upper cased GUID string
    return ( strtoupper( trim(rawurldecode( (string)( $this->post[ (string)$name ] ) ) ) ) );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as a password string method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_Password( $name ) : string
  {

    // Return parameter as string
    return ( (string)( trim( rawurldecode( $this->get[ (string)$name ] ) ) ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a password string method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_Password( $name ) : string
  {

    // Return parameter as string
    return ( (string)( trim( rawurldecode( $this->post[ (string)$name ] ) ) ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a file csv method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_Csv( $name )
  {

    // Return parameter (file content) as string
    return ( str_getcsv( $this->post[ (string)$name ] ) );

  }

  //----------------------------------------------------------------------------
  // Get GET parameter as a unsigned integer method
  //----------------------------------------------------------------------------

  public function Get_GET_Parameter_As_Integer( $name ) : int
  {

    // Return parameter as integer
    return ( (int)( $this->get[ (string)$name ] ) );

  }

  //----------------------------------------------------------------------------
  // Get POST parameter as a unsigned integer method
  //----------------------------------------------------------------------------

  public function Get_POST_Parameter_As_Integer( $name ) : int
  {

    // Return parameter as integer
    return ( (int)( $this->post[ (string)$name ] ) );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>