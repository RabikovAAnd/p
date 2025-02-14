<?php
class ModelPropertiesProperties extends Model
{

  // Database fields size definitions
  private const property_name_field_size = 127;

  //----------------------------------------------------------------------------
  // Return maximum string size of property name database field
  //----------------------------------------------------------------------------

  public function Get_Property_Name_Maximum_String_Size()
  {

    // Return maximum string size of property name database field
    return( self::property_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Edit property information
  //----------------------------------------------------------------------------

  public function Edit_Property($data = [])
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "`properties` " .
      "SET " .
      "`properties`.`name`='" . $this->db->escape($data['name_en']) . "', " .
      "`properties`.`units_guid`='" . $this->db->escape($data['unit_guid']) . "', " .
      "`properties`.`status`='" . $this->db->escape($data['status']) . "' " .
      "WHERE " .
      "`properties`.`guid`='" . $this->db->escape($data['guid']) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    $languages = $this->language->Get_Languages();

    foreach( $languages as $language )
    {
      if(isset($data['name_' . $language['code']]))
      {
        // Compose SQL query
        $sql =
        "UPDATE " .
        "`properties_description` " .
        "SET " .
        "`properties_description`.`name`='" . $this->db->escape($data['name_' . $language['code']]) . "' " .
        "WHERE " .
        "`properties_description`.`language_code`='". $this->db->escape($language['guid']) . "'" . " AND " .
        "`properties_description`.`property_guid`='" . $this->db->escape($data['guid']) . "' ";

        // Query database
        $this->db->query($sql);
      }

    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Edit Group property information
  //----------------------------------------------------------------------------

  public function Edit_Group($data = [])
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "`properties_group` " .
      "SET " .
      "`properties_group`.`name`='" . $this->db->escape($data['group_name_en']) . "', " .
      "`properties_group`.`status`='" . $this->db->escape($data['status']) . "' " .
      "WHERE " .
      "`properties_group`.`guid`='" . $this->db->escape($data['guid']) . "'";
    
      // Perform SQL query
    $this->db->query($sql);

    $languages = $this->language->Get_Languages();

    foreach($languages as $language) 
    {
      if(isset($data['group_name_' . $language['code']]))
      {
        // Compose SQL query
        $sql =
        "UPDATE " .
        "`properties_group_description` " .
        "SET " .
        "`properties_group_description`.`name`='" . $this->db->escape($data['group_name_' . $language['code']]) . "' " .
        "WHERE " .
        "`properties_group_description`.`language_code`='". $this->db->escape($language['guid']) . "' " . " AND " .
        "`properties_group_description`.`group_guid`='" . $this->db->escape($data['guid']) . "' ";
      
        // Query database
        $this->db->query($sql);
      }
    
    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Revove group of properties
  //----------------------------------------------------------------------------

  public function Remove($group_guid = '00000000000000000000000000000000')
  {


    // Compose SQL query
    $sql =
      "UPDATE " .
      "`properties_group` " .
      "SET " .
      "`properties_group`.`status`='deleted' " .
      "WHERE " .
      "`properties_group`.`guid`='" . $this->db->escape($group_guid) . "' ";

    // Query database
    $this->db->query($sql);

    // Return success code
    return (true);

  }

  //----------------------------------------------------------------------------
  // Remove property 
  //----------------------------------------------------------------------------

  public function Remove_Property($property_guid = '00000000000000000000000000000000')
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "`properties` " .
      "SET " .
      "`properties`.`status`='deleted' " .
      "WHERE " .
      "`properties`.`guid`='" . $this->db->escape($property_guid) . "' ";

    // Query database
    $this->db->query($sql);

    // Return success code
    return (true);

  }


  //----------------------------------------------------------------------------
  // Get Group property information
  //----------------------------------------------------------------------------

  public function Create_Group($group_guid = '', $data = [])
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
      "`properties_group` " .
      "SET " .
      "`properties_group`.`guid`='" . $this->db->escape($group_guid) . "', " .
      "`properties_group`.`name`='" . $this->db->escape($data['group_name_en']) . "', " .
      "`properties_group`.`status`='" . $this->db->escape($data['status']) . "', " .
      "`properties_group`.`date_added`= NOW() ";

    // Perform SQL query
    $this->db->query($sql);

    $languages = $this->language->Get_Languages();

    foreach($languages as $language) 
    {

      if(isset($data['group_name_' . $language['code']]))
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`properties_group_description` " .
        "SET " .
          "`properties_group_description`.`group_guid`='" . $this->db->escape($group_guid) . "', " .
          "`properties_group_description`.`language_code`='" . $this->db->escape($language['guid']) . "', " .
          "`properties_group_description`.`name`='" . $this->db->escape($data['group_name_' . $language['code']]) . "' ";

        // Query database
        $this->db->query($sql);

      }

    }

    // Return group 
    return (true);

  }

  //----------------------------------------------------------------------------
  // Get property information
  //----------------------------------------------------------------------------

  public function Create_Property( $property_guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`properties` " .
      "SET " .
        "`properties`.`guid`='" . $this->db->escape( $property_guid ) . "', " .
        "`properties`.`group_guid`='" . $this->db->escape( $data[ 'group_guid' ] ) . "', " .
        "`properties`.`name`='" . $this->db->escape( $data[ 'name_en' ] ) . "', " .
        "`properties`.`units_guid`='" . $this->db->escape( $data['unit_guid'] ) . "', " .
        "`properties`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "', " .
        "`properties`.`date_added`= NOW()";

    // Perform SQL query
    $this->db->query( $sql );

    $languages = $this->language->Get_Languages();

    foreach($languages as $language) 
    {

      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`properties_description` " .
        "SET " .
          "`properties_description`.`property_guid`='" . $this->db->escape($property_guid) . "', " .
          "`properties_description`.`language_code`='". $this->db->escape($language['guid']) . "', " .
          "`properties_description`.`name`='" . $this->db->escape($data['name_' . $language['code']]) . "' ";

        // Query database
        $this->db->query($sql);

      }

    }

    // Return group 
    return (true);

  }

  //----------------------------------------------------------------------------
  // Get Group descriptions
  //----------------------------------------------------------------------------

  public function Get_Group_Descriptions($group_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`properties_group_description`.`name` AS name, " .
      "`properties_group_description`.`description` AS description, " .
      "`properties_group_description`.`language_code` AS language_code " .
      "FROM " .
      "`properties_group_description` " .

      "WHERE " .
      "`properties_group_description`.`group_guid`='" . $group_guid . "' ";

    // Perform SQL query
    $query = $this->db->query($sql);


    // Return group 
    return ($query->rows);

  }

  //----------------------------------------------------------------------------
  // Get Group description
  //----------------------------------------------------------------------------

  public function Get_Group_Description($group_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`properties_group_description`.`name` AS name, " .
      "`properties_group_description`.`description` AS description " .
      "FROM " .
      "`properties_group_description` " .
      "WHERE " .
      "`properties_group_description`.`group_guid`='" . $group_guid . "' AND " .
      "`properties_group_description`.`language_code`='" . $language_code . "' LIMIT 1" ;

    // Perform SQL query
    $query = $this->db->query($sql);
    // Return group 
    return ($query->row);

  }

  //----------------------------------------------------------------------------
  // Get Property description
  //----------------------------------------------------------------------------

  public function Get_Property_Description($property_guid = '')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`properties_description`.`name` AS name, " .
      "`properties_description`.`description` AS description, " .
      "`properties_description`.`language_code` AS language_code " .
      "FROM " .
      "`properties_description` " .
      "WHERE " .
      "`properties_description`.`property_guid`='" . $property_guid . "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return group 
    return ( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get Group property information
  //----------------------------------------------------------------------------

  public function Get_Group_Information( $group_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`properties_group`.`status` AS status, " .
        "`properties_group`.`guid` AS guid, " .
        "`properties_group_description`.`name` AS name, " .
        "`properties_group_description`.`description` AS description, " .
        "`properties_group`.`date_added` AS date_added " .
      "FROM " .
        "`properties_group` " .
      "LEFT JOIN " .
        "`properties_group_description` " .
      "ON " .
        "`properties_group`.`guid`=`properties_group_description`.`group_guid` " .
      "WHERE " .
        "`properties_group_description`.`language_code`='" . $language_code . "' AND " .
        "`properties_group`.`guid`='" . $group_guid . "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test record count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'guid' ] = '';
      $return_data[ 'status' ] = 'inactive';
      $return_data[ 'name' ] = '';
      $return_data[ 'description' ] = '';
      $return_data[ 'date_added' ] = '0000-00-00 00:00:00';

    }
    else
    {

      // Set group 
      $return_data[ 'valid' ] = true;
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'status' ] = $query->row[ 'status' ];
      $return_data[ 'name' ] = $query->row[ 'name' ];
      $return_data[ 'description' ] = $query->row[ 'description' ];
      $return_data[ 'date_added' ] = $query->row[ 'date_added' ];

    }

    // Return group 
    return ( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get property information
  //----------------------------------------------------------------------------

  public function Get_Property_Information($property_guid = '', $language_code = 'XX')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`properties`.`status` AS status, " .
      "`properties`.`guid` AS guid, " .
      "`properties`.`group_guid` AS group_guid, " .
      "`properties`.`units_guid` AS units_guid, " .
      "`properties`.`date_added` AS date_added, " .
      "`properties_description`.`name` AS name, " .
      "`properties_description`.`description` AS description " .
      "FROM " .
      "properties " .
      "LEFT JOIN " .
      "`properties_description` " .
      "ON " .
      "`properties`.`guid`=`properties_description`.`property_guid` " .
      "WHERE " .
      "`properties_description`.`language_code`='" . $language_code . "' AND " .
      "`properties`.`guid`='" . $property_guid . "' ";

    // Perform SQL query
    $query = $this->db->query($sql);

    // Test record count
    if ($query->num_rows != 1) {

      // Set default data
      $return_data['valid'] = false;
      $return_data['guid'] = '';
      $return_data['status'] = 'inactive';
      $return_data['name'] = '';
      $return_data['description'] = '';
      $return_data['group_guid'] = '';
      $return_data['units_guid'] = '';
      $return_data['date_added'] = '0000-00-00 00:00:00';

    } else {

      // Set group 
      $return_data['valid'] = true;
      $return_data['guid'] = $query->row['guid'];
      $return_data['status'] = $query->row['status'];
      $return_data['name'] = $query->row['name'];
      $return_data['description'] = $query->row['description'];
      $return_data['group_guid'] = $query->row['group_guid'];
      $return_data['units_guid'] = $query->row['units_guid'];
      $return_data['date_added'] = $query->row['date_added'];

    }

    // Return group 
    return ($return_data);

  }

  //----------------------------------------------------------------------------
  // Get Group properties
  //----------------------------------------------------------------------------

  public function Get_Group_Properties($group_guid = '', $language_code = 'XX')
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`properties`.`status` AS status, " .
      "`properties`.`units_guid` AS units_guid, " .
      "`properties`.`guid` AS guid, " .
      "`properties_description`.`name` AS name, " .
      "`properties_description`.`description` AS description " .
      "FROM " .
      "properties " .
      "LEFT JOIN " .
      "`properties_description` " .
      "ON " .
      "`properties`.`guid`=`properties_description`.`property_guid` " .
      "WHERE " .
      "`properties_description`.`language_code`='" . $language_code . "' AND " .
      "`properties`.`group_guid`='" . $group_guid . "' ";

    // Perform SQL query
    $query = $this->db->query($sql);


    // Return properties description
    return ($query->rows);

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>