<?php
class Supplier
{

  //----------------------------------------------------------------------------
  // Local objects
  //----------------------------------------------------------------------------

  private $config;
  private $db;
  private $request;
  private $session;

  //----------------------------------------------------------------------------
  // Active customer related data
  //----------------------------------------------------------------------------

  private $supplier_id;
  private $gender_id;
  private $firstname;
  private $lastname;
  private $email;
  private $phone;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    $this->config = $registry->get( 'config' );
    $this->db = $registry->get( 'db' );
    $this->request = $registry->get( 'request' );
    $this->session = $registry->get( 'session' );

    //--------------------------------------------------------------------------

    // Set customer hash value
    $this->supplier_hash = $this->request->Get_Request_Hash();

  }


  //----------------------------------------------------------------------------
  // Create new customer
  //----------------------------------------------------------------------------
  
  public function Create( $supplier_data )
  {
    
    // Generate customer GUID
    $guid = UUID_V4_T1();

    // Compose query
	  $sql = 
      "INSERT INTO " . 
        "`supplier` " .
      "SET " .
        "`supplier`.`guid`='" . $guid . "', " .
	      "`supplier`.`firstname`='" . $this->db->escape( $supplier_data[ 'firstname' ] ) . "', " .
        "`supplier`.`middlename`='" . $this->db->escape( $supplier_data[ 'middlename' ] ) . "', " .
        "`supplier`.`lastname`='" . $this->db->escape( $supplier_data[ 'lastname' ] ) . "', " .
        "`supplier`.`email`='" . $this->db->escape( $supplier_data[ 'email' ] ) . "', " .
        "`supplier`.`phone`='" . $this->db->escape( $supplier_data[ 'phone' ] ) . "', " .
        "`supplier`.`ip`='" . $this->db->escape( $this->request->server[ 'REMOTE_ADDR' ] ) . "', " .
        "`supplier`.`status`='1', " .
        "`supplier`.`approved`='1', " .
        "`supplier`.`date_added`=NOW()";

    // Execute query
	  $this->db->query( $sql );
    // Store customer GUID in session
    $this->session->data[ 'supplier_guid' ] = $guid;
    // Set success code
    $return_code = true;

    // Return success status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Update customer data
  //----------------------------------------------------------------------------

	public function Update( $guid, $data ) 
	{
    // Compose SQL query
    $sql =
      "UPDATE " .
      "`customer` " .
      "SET " .
      "`customer`.`firstname`='" . $this->db->escape( $data[ 'firstname' ] ) . "', " .
      "`customer`.`middlename`='" . $this->db->escape( $data[ 'middlename' ] ) . "', " .
      "`customer`.`lastname`='" . $this->db->escape( $data[ 'lastname' ] ) . "', " .
      "`customer`.`phone`='" . $this->db->escape( $data[ 'phone' ] ) . "' " .
      "WHERE " .
      "`customer`.`guid` = '" . $this->db->escape( $guid ) . "';";


    // Query databse
    $this->db->query( $sql );
	
	}

  //----------------------------------------------------------------------------
  // Get customer information
  //----------------------------------------------------------------------------

	public function Get_Contact_Information( $supplier_guid = '' )
	{

		// Compose SQL query
		$sql = 
      "SELECT " .
        " * " . 
      "FROM " .
        "`supplier` " .
      "WHERE " .
        "`supplier`.`guid`='" . $this->db->escape( $supplier_guid ) . "'";

		// Query database
		$result = $this->db->query( $sql );

		// Test record count
		if ( $result->num_rows != 1 )
		{

			// Set default data
			$contact_data[ 'valid' ] = false;
			$contact_data[ 'contact_id' ] = 0;
			$contact_data[ 'guid' ] = '';
      $contact_data[ 'gender_id' ] = 0;
			$contact_data[ 'legal_entity' ] = 0;
			$contact_data[ 'firstname' ] = '';
			$contact_data[ 'lastname' ] = '';
			$contact_data[ 'email' ] = '';
			$contact_data[ 'phone' ] = '';
      $contact_data[ 'date_added' ] = '0000-00-00 00:00:00';

		}
		else
		{

			// Extract data
			$contact_data[ 'valid' ] = true;
			$contact_data[ 'contact_id' ] = $result->row[ 'supplier_id' ];
			$contact_data[ 'guid' ] = $result->row[ 'guid' ];
			$contact_data[ 'gender_id' ] = $result->row[ 'gender_id' ];
			$contact_data[ 'firstname' ] = $result->row[ 'firstname' ];
			$contact_data[ 'lastname' ] = $result->row[ 'lastname' ];
			$contact_data[ 'middlename' ] = $result->row[ 'middlename' ];
			$contact_data[ 'email' ] = $result->row[ 'email' ];
			$contact_data[ 'phone' ] = $result->row[ 'phone' ];
      $contact_data[ 'date_added' ] =$result->row[ 'date_added' ];

		}

		// Return data
		return( $contact_data );

	}


  //----------------------------------------------------------------------------
  // Get customer GUID
  //----------------------------------------------------------------------------

  public function Get_GUID()
  {

    // Supplier guid not setted
    if ( isset( $this->session->data[ 'supplier_guid' ] ) === false )
    {

      // Send empty guid
      $customer_guid = '';
      
    }
    else
    {
      
      // Get supplier guid from session
      $customer_guid = $this->session->data[ 'supplier_guid' ];

    }
    
    // Return customer guid
    return( $customer_guid );

  }

  //----------------------------------------------------------------------------
  // Get customer ID
  //----------------------------------------------------------------------------

  public function Get_ID()
  {

    // Return customer id
    return( $this->supplier_id );

  }
}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>