<?php
class ModelCustomersCustomers extends Model 
{

  private const customer_attribute_value_field_size = 255;

  //----------------------------------------------------------------------------
  // Return maximum string size of attribute value database field
  //----------------------------------------------------------------------------

  public function Get_Customer_Attribute_Value_Maximum_String_Size()
  {

    // Return maximum string size of item MPN database field
    return( self::customer_attribute_value_field_size );

  }
  //----------------------------------------------------------------------------
  // Get customer information
  //----------------------------------------------------------------------------

  public function Search_Customers_Count($search = '', $firstname = true, $lastname = false, $manufacturer=false)
  {

    if($firstname || $lastname || $manufacturer){
    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();
    
    if ( $firstname === true )
    {
      $where_or[] = "customer.firstname LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $lastname === true )
    {    
      $where_or[] = "customer.lastname LIKE '%" . $this->db->escape( $search ) . "%'";
    }

    if ( $manufacturer === true )
    {
      $where_or[] = "customer.company_name LIKE '%" . $this->db->escape( $search ) . "%'";
    }

    //--------------------------------------------------------------------------
    // Compose AND part
    //--------------------------------------------------------------------------

 
    $where_and = array();

    if ( count( $where_or ) == 1 )
    {
      $where_and[] = implode( ' OR ', $where_or );
    }
    else
    {
      if ( count( $where_or ) > 1 )
      {
        $where_and[] = '( ' . implode( ' OR ', $where_or ) . ' )';
      }
    }
    
   


    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode(  ' AND ', $where_and  );
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "COUNT(*) " .
      "FROM " .
        "customer " .
      "WHERE " . 
        $where . ";";
    // Query database
    $results = $this->db->query( $sql );
    $result = $results->row[ 0 ] ;
  }else{
    $result = 0;
  }
    // Return data
    return( $result );
  
  }
  public function Get_List_Of_Customers( $page_length, $page_number, $search = '', $firstname = true, $lastname = false, $manufacturer = false, $legal_entity= -1)
  {
    if($firstname || $lastname || $manufacturer){
      //--------------------------------------------------------------------------
      // Compose OR part
      //--------------------------------------------------------------------------

      $where_or = array();
          
      if ( $firstname === true )
      {
        $where_or[] = "customer.firstname LIKE '%" . $this->db->escape( $search ) . "%' ";
      }

      if ( $lastname === true )
      {    
        $where_or[] = "customer.lastname LIKE '%" . $this->db->escape( $search ) . "%'";
      }

      if ( $manufacturer === true )
      {
        $where_or[] = "customer.company_name LIKE '%" . $this->db->escape( $search ) . "%'";
      }
      //--------------------------------------------------------------------------
      // Compose AND part
      //--------------------------------------------------------------------------


      $where_and = array();

      
      if( $legal_entity === 0 || $legal_entity === 1 )
      {
        $where_and[] = "customer.legal_entity='" . $this->db->escape( $legal_entity ) . "'";
      }

      if ( count( $where_or ) == 1 )
      {
        $where_and[] = implode( ' OR ', $where_or );
      }
      else
      {
        if ( count( $where_or ) > 1 )
        {
          $where_and[] = '( ' . implode( ' OR ', $where_or ) . ' )';
        }
      }
    

      //--------------------------------------------------------------------------
      // Compose WHERE clause
      //--------------------------------------------------------------------------

      $where = implode(  ' AND ', $where_and );
      //--------------------------------------------------------------------------
      // Compose SQL query
      //--------------------------------------------------------------------------

      $sql =
        "SELECT " .
          "customer.guid AS guid, " .
          "customer.customer_id AS id, " .
          "customer.lastname AS lastname, " .
          "customer.middlename AS middlename, " .
          "customer.status AS status, " .
          "customer.firstname AS name, " .
          "customer.registration_country AS registration_country, " .
          "customer.company_name AS company_name " .
        "FROM " .
          "customer " .
        "WHERE " . 
          $where . " " .
      //! @note ANVILEX KM: Sorting caused increase server response time.
      //      "ORDER BY product.mpn ASC " .
        "LIMIT " . $this->db->escape( $page_length ) . " " .
        "OFFSET " . $this->db->escape( $page_length * ( $page_number - 1 ) ) . ";";

  //      $this->log->Log_Debug( $sql );

      // Query database
      $results = $this->db->query( $sql );

      $result = $results->rows;

    }
    else
    {

      $result = [];

    }

    // Return data
    return( $result );

  }
 
  //----------------------------------------------------------------------------
  // Check for customer exists
  //----------------------------------------------------------------------------

  public function Is_Exist_Customers_Customer( $parent_guid = '', $customer_guid = '' )
  {

    // Compose SQL query
    $sql =
    "SELECT " .
      "* " .
    "FROM " .
      "customer_relationships " .
    "WHERE " .
      "parent_guid='" . $this->db->escape( $parent_guid ) . "' AND " .
      "customer_guid='" . $this->db->escape( $customer_guid ) . "' ";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // Customer not found
      //------------------------------------------------------------------------

      // Set customer not found status
      $customer_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer found
      //------------------------------------------------------------------------

      // Set project found status
      $customer_found = true;

    }

    // Return data
    return( $customer_found );

  }
  //----------------------------------------------------------------------------
  // Add customer to customer
  //----------------------------------------------------------------------------

  public function Add_Customer_To_Customer( $parent_guid = '00000000000000000000000000000000', $customer_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`customer_relationships` " .
      "SET " .
        "`customer_relationships`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "', " .
        "`customer_relationships`.`parent_guid`='" . $this->db->escape( $parent_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  
  //----------------------------------------------------------------------------
  // Get customer customers
  //----------------------------------------------------------------------------

  public function Get_Customer_Customers( $customer_guid = '' )
  {

   // Compose SQL query
   $sql =
     "SELECT " .
       "* " .
     "FROM " .
       "`customer_relationships` " .
     "WHERE " .
       "`customer_relationships`.`parent_guid`='" . $this->db->escape( $customer_guid ) . "'";

   // Query database
   $result = $this->db->query( $sql );

   // Return data
   return( $result->rows );

 }

 

  //----------------------------------------------------------------------------
  // Remove customer
  //----------------------------------------------------------------------------

  public function Remove_Related_Customer( $parent_guid = '00000000000000000000000000000000', $customer_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`customer_relationships` " .
      "WHERE " .
        "`customer_relationships`.`parent_guid`='" . $this->db->escape( $parent_guid ) . "' AND " .
        "`customer_relationships`.`customer_guid`='". $this->db->escape( $customer_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }
  
  //----------------------------------------------------------------------------
  // Get attributes
  //----------------------------------------------------------------------------

  public function Get_Attributes( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`attributes` " .
      "LEFT JOIN " .
        "`attributes_description` " .
      "ON " .
        "`attributes`.`guid`=`attributes_description`.`attribute_guid` " .
      "WHERE " .
        "`attributes_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND ".
        "`attributes`.`status`='active' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get attributes
  //----------------------------------------------------------------------------

  public function Get_Customer_Attributes( $customer_guid = '',$language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`customer_attributes` " .
        "LEFT JOIN " .
        "`attributes` " .
      "ON " .
        "`attributes`.`guid`=`customer_attributes`.`attribute_guid` " .
      "LEFT JOIN " .
        "`attributes_description` " .
      "ON " .
        "`attributes`.`guid`=`attributes_description`.`attribute_guid` " .
      "WHERE " .
         "`customer_attributes`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND ".
        "`attributes_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND ".
        "`attributes`.`status`='active' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }


  //----------------------------------------------------------------------------
   // Get Attribute information
   //----------------------------------------------------------------------------
 
   public function Get_Customer_Attribute( $index_guid = '', $language_code = 'XX')
   {
 
     // Compose SQL query
     $sql =
       "SELECT " .
         " * " .
       "FROM " .
         "`customer_attributes` " .
         "LEFT JOIN " .
           "`attributes` " .
         "ON " .
           "`attributes`.`guid`=`customer_attributes`.`attribute_guid` " .
         "LEFT JOIN " .
           "`attributes_description` " .
         "ON " .
           "`attributes`.`guid`=`attributes_description`.`attribute_guid` " .
       "WHERE " .
         "`customer_attributes`.`index_guid`='" . $this->db->escape( $index_guid ) . "' AND ".
         "`attributes_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND ".
         "`attributes`.`status`='active' LIMIT 1";
 
     // Query database
     $result = $this->db->query( $sql );
 
     // Test record count
     if ( $result->num_rows != 1 )
     {
 
       // Set default data
       $data[ 'valid' ] = false;
       $data[ 'guid' ] = '';
       $data[ 'customer_guid' ] = '';
       $data[ 'attribute_guid' ] = '';
       $data[ 'multiple' ] = 0;
       $data[ 'status' ] = 'inactive';
       $data[ 'creation_date' ] = '0000-00-00 00:00:00';
       $data[ 'modification_date' ] = '0000-00-00 00:00:00';
       $data[ 'name' ] = '';
       $data[ 'value' ] = '';
       
     }
     else
     {
 
       // Extract data
       $data[ 'valid' ] = true;
       $data[ 'attribute_guid' ] = $result->row[ 'attribute_guid' ];
       $data[ 'customer_guid' ] = $result->row[ 'customer_guid' ];
       $data[ 'index_guid' ] = $result->row[ 'index_guid' ];
       $data[ 'multiple' ] = $result->row[ 'multiple' ];
       $data[ 'status' ] = $result->row[ 'status' ];
       $data[ 'creation_date' ] = $result->row[ 'creation_date' ];
       $data[ 'modification_date' ] = $result->row[ 'modification_date' ];
       $data[ 'name' ] = $result->row[ 'name' ];
       $data[ 'value' ] = $result->row[ 'value' ];
      
 
     }
     
     // Return data
     return( $data );
 
   }

   //----------------------------------------------------------------------------
    // Get Attribute information
    //----------------------------------------------------------------------------
  
    public function Get_Attribute( $attribute_guid = '', $language_code = 'XX')
    {
  
      // Compose SQL query
      $sql =
        "SELECT " .
          " * " .
        "FROM " .
          "`attributes` " .
          "LEFT JOIN " .
            "`attributes_description` " .
          "ON " .
            "`attributes`.`guid`=`attributes_description`.`attribute_guid` " .
        "WHERE " .
          "`attributes`.`guid`='" . $this->db->escape( $attribute_guid ) . "' AND ".
          "`attributes_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND ".
          "`attributes`.`status`='active' LIMIT 1";
  
      // Query database
      $result = $this->db->query( $sql );
  
      // Test record count
      if ( $result->num_rows != 1 )
      {
  
        // Set default data
        $data[ 'valid' ] = false;
        $data[ 'guid' ] = '';
        $data[ 'multiple' ] = 0;
        $data[ 'status' ] = 'inactive';
        $data[ 'creation_date' ] = '0000-00-00 00:00:00';
        $data[ 'modification_date' ] = '0000-00-00 00:00:00';
        $data[ 'name' ] = '';
  
      }
      else
      {
  
        // Extract data
        $data[ 'valid' ] = true;
        $data[ 'guid' ] = $result->row[ 'guid' ];
        $data[ 'multiple' ] = $result->row[ 'multiple' ];
        $data[ 'status' ] = $result->row[ 'status' ];
        $data[ 'creation_date' ] = $result->row[ 'creation_date' ];
        $data[ 'modification_date' ] = $result->row[ 'modification_date' ];
        $data[ 'name' ] = $result->row[ 'name' ];
       
  
      }

      // Return data
      return( $data );
  
    }

  //----------------------------------------------------------------------------
  // Add Attribute to customer
  //----------------------------------------------------------------------------

  public function Add_Attribute_To_Customer( $customer_guid = '00000000000000000000000000000000', $attribute_guid = '00000000000000000000000000000000', $value='' )
  {

     // Generate Attribute index GUID
      $guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`customer_attributes` " .
      "SET " .
        "`customer_attributes`.`index_guid`='" . $this->db->escape( $guid ) . "', " .
        "`customer_attributes`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "', " .
        "`customer_attributes`.`attribute_guid`='" . $this->db->escape( $attribute_guid ) . "'," .
        "`customer_attributes`.`value`='" . $this->db->escape( $value ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Remove Attribute
  //----------------------------------------------------------------------------

  public function Remove_Customers_Attribute( $customer_guid = '00000000000000000000000000000000', $index_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`customer_attributes` " .
      "WHERE " .
        "`customer_attributes`.`index_guid`='" . $this->db->escape( $index_guid ) . "' AND " .
        "`customer_attributes`.`customer_guid`='". $this->db->escape( $customer_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }
    
  //----------------------------------------------------------------------------
  // Edit value observed Attribute
  //----------------------------------------------------------------------------

  public function Edit_Attribute( $index_guid = '', $value  = '')
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`customer_attributes` " .
      "SET " .
        "`customer_attributes`.`value`='" . $this->db->escape( $value ) . "' " .
      "WHERE " .
        "`customer_attributes`.`index_guid`='". $this->db->escape( $index_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }
}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
