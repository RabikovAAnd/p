<?php
class ModelItemsProperties extends Model
{
 
  //----------------------------------------------------------------------------
  // Get properties groups
  //----------------------------------------------------------------------------

  public function Get_Properties_Groups( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`properties_group`.`guid` AS `guid`, " .
        "`properties_group`.`status` AS `status`, " .
        "`properties_group_description`.`name` AS `name`, " .
        "`properties_group_description`.`description` AS `description` " .
      "FROM " .
        "`properties_group` " .
      "LEFT JOIN " .
        "`properties_group_description` " .
      "ON " .
        "`properties_group`.`guid`=`properties_group_description`.`group_guid` " .
      "WHERE " .
        "`properties_group_description`.`language_code`='" . $language_code . "' "   ;

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }



  //----------------------------------------------------------------------------
  // Get properties
  //----------------------------------------------------------------------------

  public function Get_Properties( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "properties " .
      "LEFT JOIN " .
        "`properties_description` " .
      "ON " .
        "`properties`.`guid`=`properties_description`.`property_guid` " .
      "WHERE " .
        "`properties_description`.`language_code`='" . $language_code . "' "   ;

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }
  
  //----------------------------------------------------------------------------
  // Get item property information
  //----------------------------------------------------------------------------

  public function Is_Item_Property_Exists( $property_guid = '', $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product_properties`.`product_guid` AS guid " .
      "FROM " .
        "`product_properties` " .
      "WHERE " .
        "`product_properties`.`property_guid`='" . $property_guid . "' AND " .
        "`product_properties`.`product_guid`='" . $item_guid . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for property exists
    if ( $query->num_rows < 1 )
    {

      //------------------------------------------------------------------------
      // Property not found
      //------------------------------------------------------------------------

      // Set not found status
      $property_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Property found
      //------------------------------------------------------------------------

      // Set property found status
      $property_found = true;

    }

    // Return status
    return( $property_found );

  }

  //----------------------------------------------------------------------------
  // Get item information
  //----------------------------------------------------------------------------

  public function Is_Property_Exists( $property_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`properties`.`guid` AS guid " .
      "FROM " .
        "`properties` " .
      "WHERE " .
        "`properties`.`guid`='" . $property_guid . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Item not found
      //------------------------------------------------------------------------

      // Set not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Item found
      //------------------------------------------------------------------------

      // Set item found status
      $item_found = true;

    }

    // Return status
    return( $item_found );

  }

  //----------------------------------------------------------------------------
  // Get Unit referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Unit_Property_Valid($property_guid='', $unit_guid='' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`units`.`guid` AS guid " .
      "FROM " .
        "`units` " .
        "LEFT JOIN " .
        "`unit_groups` " .
      "ON " .
        "`units`.`group_guid`=`unit_groups`.`guid` " .
        "LEFT JOIN " .
        "`properties` " .
      "ON " .
        "`unit_groups`.`guid`=`properties`.`units_guid` " .
      "WHERE " .
        "`units`.`guid`='".  $this->db->escape( $unit_guid ) ."' AND " .
        "`properties`.`guid`='".  $this->db->escape( $property_guid ) ."' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Unit not found
      //------------------------------------------------------------------------

      // Set not found status
      $unit_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Unit found
      //------------------------------------------------------------------------

      // Set item found status
      $unit_found = true;

    }

    // Return status
    return( $unit_found );

  }
  //----------------------------------------------------------------------------
  // Add property observed item
  //----------------------------------------------------------------------------

  public function Add_Item_Property( $item_guid = '', $property_guid  = '', $property_value  = '', $unit_guid  = '' )
  {

    // Generate value GUID
    $property_value_guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "product_properties " .
      "SET " .
        "product_guid='" . $this->db->escape( $item_guid ) . "', " .
        "property_guid='" . $this->db->escape( $property_guid ) . "', " .
        "value='" . $this->db->escape( $property_value ) . "', " .
        "unit_guid='" . $this->db->escape( $unit_guid ) . "', " .
        "value_guid='" . $this->db->escape( $property_value_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Search properties groups
  //----------------------------------------------------------------------------

  public function Search_Properties_Groups( $limit= 30, $search='', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`properties_group`.`guid` AS `guid`, " .
        "`properties_group_description`.`name` AS `name`, " .
        "`properties_group_description`.`description` AS `description` " .
      "FROM " .
        "`properties_group` " .
      "LEFT JOIN " .
        "`properties_group_description` " .
      "ON " .
        "`properties_group`.`guid`=`properties_group_description`.`group_guid` " .
      "WHERE " .
      "properties_group_description.name LIKE '%" . $this->db->escape($search) . "%' AND " .
        "`properties_group_description`.`language_code`='" . $language_code . "' "   .
      "LIMIT " . $this->db->escape($limit) ;

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }


  //----------------------------------------------------------------------------
  // Search properties
  //----------------------------------------------------------------------------

  public function Search_Properties( $limit= 30, $group_guid='', $search='', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`properties`.`guid` AS `guid`, " .
        "`properties`.`group_guid` AS `group_guid`, " .
        "`properties_description`.`name` AS `name`, " .
        "`properties_description`.`description` AS `description` " .
      "FROM " .
        "`properties` " .
      "LEFT JOIN " .
        "`properties_description` " .
      "ON " .
        "`properties`.`guid`=`properties_description`.`property_guid` " .
      "WHERE " .
        "properties_description.name LIKE '%" . $this->db->escape( $search ) . "%' AND " .
        "properties.group_guid ='" . $this->db->escape( $group_guid ) . "' AND " .
        "`properties_description`.`language_code`='" . $this->db->escape( $language_code ) . "' " .
      "LIMIT " . $this->db->escape( $limit ) ;


    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }
  
  //----------------------------------------------------------------------------
  // Get group data
  //----------------------------------------------------------------------------

  public function Get_Group_Data($group_guid, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT * " .

      "FROM " .
        "`properties_group_description` " .
      "WHERE " .
        "`properties_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "' AND " .
        "`properties_group_description`.`group_guid`='" . $this->db->escape( $group_guid ). "' LIMIT 1"   ;


    // Perform SQL query
    $query = $this->db->query( $sql );


    // Test row count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $data[ 'valid' ] = false;
      $data[ 'name' ] = '';
      $data[ 'description' ] = '';
    }
    else
    {

      // Set valid data
      $data[ 'valid' ] = true;
      $data[ 'name' ] = $query->row['name'];
      $data[ 'description' ] = $query->row['description'];

    }

    // Return properties description
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Get item properties
  //----------------------------------------------------------------------------

  public function Get_Item_Properties( $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product_properties`.`property_guid` AS `property_guid`, " .
        "`product_properties`.`value` AS `value`" .
      "FROM " .
        "product_properties " .
      "WHERE " .
        "product_guid='" . $this->db->escape( $item_guid ) . "'" ;

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

 }

  //----------------------------------------------------------------------------
  // Get property value
  //----------------------------------------------------------------------------

  public function Get_Property_Value( $property_guid = '', $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product_properties`.`value_guid` AS value_guid, " .
        "`product_properties`.`value` AS value " .
      "FROM " .
        "product_properties " .
      "WHERE " .
        "`product_properties`.`property_guid`='" . $this->db->escape( $property_guid ) . "' AND " .
        "`product_properties`.`product_guid`='" . $this->db->escape( $item_guid ) . "' " .
        "LIMIT 1"  ;

    // Perform SQL query
   $query = $this->db->query( $sql );

    // Test record count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'value_guid' ] = '';
      $return_data[ 'value' ] =  '';

    }
    else
    {

      // Set properties description
      $return_data[ 'valid' ] = true;
      $return_data[ 'value_guid' ] = $query->row[ 'value_guid' ];
      $return_data[ 'value' ] = $query->row[ 'value' ];

    }

    // Return properties description
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Remove property item 
  //----------------------------------------------------------------------------

  public function Remove_Property( $property_guid = '00000000000000000000000000000000', $item_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`product_properties` " .
      "WHERE " .
        "`product_properties`.`property_guid`='" . $this->db->escape( $property_guid ) . "' AND " .
        "`product_properties`.`product_guid`='". $this->db->escape( $item_guid ) . "'";
        $this->log->Log_Debug( 'sql' .  $sql);
    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Edit property observed item
  //----------------------------------------------------------------------------

  public function Edit_Item_Property( $item_guid = '', $property_guid  = '', $property_value  = '' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "product_properties " .
      "SET " .
        "value='" . $this->db->escape( $property_value ) . "' " .
      "WHERE " .
        "`product_properties`.`product_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
        "`product_properties`.`property_guid`='". $this->db->escape( $property_guid ) . "'";

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