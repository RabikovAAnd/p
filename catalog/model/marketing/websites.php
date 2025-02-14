<?php
class ModelMarketingWebsites extends Model
{

  //----------------------------------------------------------------------------
  // Add website into database
  //----------------------------------------------------------------------------

  public function Add( $url = '' )
  {

    // Test URL value
    if ( $url == '' )
    {

      //----------------------------------------------------------------------
      // ERROR: URL is empty
      //----------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      // Compose SQL query
      $sql = "INSERT INTO websites SET ";
      $sql .= "url='" . $this->db->escape( $url ) . "', ";
      $sql .= "create_date=NOW()";

      // Query database
      $this->db->query( $sql );

      // Set success code
      $return_code = true;

    }

    // Return status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Is exists
  //----------------------------------------------------------------------------

  public function Is_Exists( $url )
  {

    // Compose SQL query
    $sql = "SELECT id FROM websites WHERE url='" . $this->db->escape( $url ) . "' LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      // Set error code
      $return_code = false;

    }
    else
    {

      // Set success code
      $return_code = true;

    }

    // Return status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Validate domain name
  //----------------------------------------------------------------------------

  public function Is_Domain_Name_Valid( $full_domain_name )
  {

    // Trim string
    $domain_name = trim( $full_domain_name );
    
    // Get domain name length
    $domain_len = strlen( $domain_name );

    // Test domain name length
    if ( ( $domain_len < 3 ) OR ( $domain_len > 253 ) )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid length
      //------------------------------------------------------------------------
      
      // Set error code
      $return_code[ 'return_code' ] = false;
      $return_code[ 'error_code' ] = 'Invalid length';

    }
    else
    {

      //------------------------------------------------------------------------
      // Length is valid, test protocol
      //------------------------------------------------------------------------
      
      // Getting rid of HTTP/S just in case was passed.
      if( stripos( $domain_name, 'http://' ) === 0 )
      {

        $domain_name = substr( $domain_name, 7 );

      }
      else
      {

        if( stripos( $domain_name, 'https://' ) === 0 )
        {

          $domain_name = substr( $domain_name, 8 );

        }

      }

      // We don't need the www either
      if( stripos( $domain_name, 'www.' ) === 0 )
      {

        $domain_name = substr( $domain_name, 4 );

      }

      // Checking for a '.' at least, not in the beginning nor end, since http://.abcd. is reported valid
      if( ( strpos( $domain_name, '.' ) === false ) Or ( $domain_name[ strlen( $domain_name ) - 1 ] == '.' ) Or ( $domain_name[ 0 ] == '.' ) )
      {

        // Set error code
        $return_code[ 'return_code' ] = false;
        $return_code[ 'error_code' ] = 'Invalid dots';

      }
      else
      {

        // Now we use the FILTER_VALIDATE_URL, concatenating http so we can use it, and return BOOL
        if ( filter_var( 'http://' . $domain_name, FILTER_VALIDATE_URL ) === false )
        {

          // Set error code
          $return_code[ 'return_code' ] = false;
          $return_code[ 'error_code' ] = 'Invalid URL: ' . $domain_name;

        }
        else
        {

          // Set success code
          $return_code[ 'return_code' ] = true;

        }

      }

    }

    // Return validation ststus
    return( $return_code );

  }

  //----------------------------------------------------------------------------

/*
	public function editCustomer( $data )
	{

		$this->db->query("UPDATE customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "' WHERE customer_id = '" . (int)$this->customer->Get_ID() . "'");

	}
*/
  //----------------------------------------------------------------------------
  // End of file
  //----------------------------------------------------------------------------

}
?>
