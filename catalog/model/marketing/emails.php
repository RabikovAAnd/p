<?php
class ModelMarketingEmails extends Model
{

  //----------------------------------------------------------------------------
  // Add email into database
  //----------------------------------------------------------------------------

  public function Add( $email = '', $company = '', $firstname = '', $lastname = '' )
  {

    // Trim email address
    $email = trim( $email );
    $company = trim( $company );
    $firstname = trim( $firstname );
    $lastname = trim( $lastname );

    // Test URL value
    if ( $email == '' )
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
      $sql = "INSERT INTO emails SET ";
      $sql .= "email='" . $this->db->escape( $email ) . "', ";
      $sql .= "contact_firstname='" . $this->db->escape( $firstname ) . "', ";
      $sql .= "contact_lastname='" . $this->db->escape( $lastname ) . "', ";
      $sql .= "company_name='" . $this->db->escape( $company ) . "', ";
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
  // Is email exists
  //----------------------------------------------------------------------------

  public function Is_Exists( $email = '' )
  {

    // Trim email address
    $email = trim( $email );
    
    // Compose SQL query
    $sql = "SELECT id FROM emails WHERE email='" . $this->db->escape( $email ) . "' LIMIT 1";

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
  // Validate email address
  //----------------------------------------------------------------------------

  public function Is_Email_Address_Valid( $email )
  {

    // Trim email
    $email = trim( $email );

    // Get domain name length
    $domain_len = strlen( $email );

    // Test domain name length
    if ( ( $domain_len < 4 ) Or ( $domain_len > 253 ) )
    {

      // Set error code
      $return_code = false;

    }
    else
    {

      // We dont need the www either
      if( stripos( $email, '@' ) === 0 )
      {

        // Set error code
        $return_code = false;

      }
      else
      {

        // Now we use the FILTER_VALIDATE_EMAIL, and return BOOL
        if ( filter_var( $email, FILTER_VALIDATE_EMAIL ) === FALSE )
        {

          // Set error code
          $return_code = false;

        }
        else
        {

          // Set success code
          $return_code = true;

        }

      }

    }

    // Return validation ststus
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // End of file
  //----------------------------------------------------------------------------
  
}
?>
