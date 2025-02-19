<?php
class Units extends Model
{

  //----------------------------------------------------------------------------
  // Get unit groups
  //----------------------------------------------------------------------------

  public function Get_Unit_Groups( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`unit_groups`.`guid` AS guid, " .
        "`unit_groups`.`status` AS status, " .
        "`unit_groups`.`name` AS group_name, " .
        "`unit_group_description`.`name` AS name, " .
        "`unit_group_description`.`description` AS description " .
      "FROM " .
        "`unit_groups` " .
      "LEFT JOIN " .
        "`unit_group_description` " .
      "ON " .
        "`unit_groups`.`guid`=`unit_group_description`.`group_guid` " .
      "WHERE " .
        "( `unit_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "') OR " .
        "( `unit_group_description`.`language_code` IS NULL )";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return ( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get unit information
  //----------------------------------------------------------------------------

  public function Get_Unit_Group_Info( $guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`unit_groups`.`guid` AS guid, " .
        "`unit_groups`.`status` AS status, " .
        "`unit_groups`.`creation_date` AS creation_date, " .
        "`unit_groups`.`modification_date` AS modification_date, " .
        "`unit_groups`.`name` AS group_name, " .
        "`unit_group_description`.`name` AS name, " .
        "`unit_group_description`.`description` AS description " .
      "FROM " .
        "`unit_groups` " .
      "LEFT JOIN " .
        "`unit_group_description` " .
      "ON " .
        "`unit_groups`.`guid`=`unit_group_description`.`group_guid` " .
      "WHERE " .
        "( `unit_groups`.`guid`='" . $this->db->escape( $guid ) . "' ) AND " .
        "( ( `unit_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "') OR " .
        "( `unit_group_description`.`language_code` IS NULL ) )";

    // Query database
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: unit not found
      //------------------------------------------------------------------------

      // Set default data
      $data[ 'return_code' ] = false;
      $data[ 'data' ] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // unit found
      //------------------------------------------------------------------------

      // Set product data
      $data[ 'return_code' ] = true;
      $data[ 'data' ][ 'guid' ] = $query->row[ 'guid' ];
      $data[ 'data' ][ 'status' ] = $query->row[ 'status' ];
      $data[ 'data' ][ 'group_name' ] = $query->row[ 'group_name' ];
      $data[ 'data' ][ 'name' ] = $query->row[ 'name' ];
      $data[ 'data' ][ 'description' ] = $query->row[ 'description' ];
      $data[ 'data' ][ 'creation_date' ] = $query->row[ 'creation_date' ];
      $data[ 'data' ][ 'modification_date' ] = $query->row[ 'modification_date' ];

    }

    // Return unit information
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Get unit group referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_Unit_Groups_By_GUID( $guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`unit_groups`.`guid` AS guid " .
      "FROM " .
        "`unit_groups` " .
      "WHERE " .
        "`unit_groups`.`guid`='" . $this->db->escape( $guid ) . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for group exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      //  Unit group not found
      //------------------------------------------------------------------------

      // Set not found status
      $group_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      //  Unit group found
      //------------------------------------------------------------------------

      // Set group found status
      $group_found = true;

    }

    // Return status
    return( $group_found );

  }

  //----------------------------------------------------------------------------
  // Update unit group
  //----------------------------------------------------------------------------

  public function Update_Unit_Group( $data = array() )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`unit_groups` " .
      "SET " .
        "`unit_groups`.`status`='" . $this->db->escape( $data[ 'status' ] ) . "' " .
      "WHERE " .
        "`unit_groups`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for language exists
      if( isset( $data[ 'name' ][ $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`unit_group_description` " .
        "SET " .
          "`unit_group_description`.`group_guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
          "`unit_group_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`unit_group_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "' " .
        "ON DUPLICATE KEY UPDATE " .
          "`unit_group_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
/*
  public function convert( $value, $from, $to )
  {

    if ($from == $to)
    {
          return $value;
    }

    if (isset($this->lengths[$from]))
    {
      $from = $this->lengths[$from]['value'];
    }
    else
    {
      $from = 0;
    }

    if (isset($this->lengths[$to])) {
      $to = $this->lengths[$to]['value'];
    } else {
      $to = 0;
    }

        return $value * ($to / $from);
    }
*/

  //----------------------------------------------------------------------------
/*
  public function format($value, $length_class_id, $decimal_point = '.', $thousand_point = ',')
  {

    if (isset($this->lengths[$length_class_id])) {
        return number_format($value, 2, $decimal_point, $thousand_point) . $this->lengths[$length_class_id]['unit'];
    } else {
      return number_format($value, 2, $decimal_point, $thousand_point);
    }

  }
*/
  //----------------------------------------------------------------------------
  // Get unit abbreviation
  //----------------------------------------------------------------------------

  public function getUnitAbbreviation( $unit_id, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "units_description.abbreviation " .
      "FROM " .
        "units_description " .
      "LEFT JOIN " .
        "units " .
      "ON " .
        "units_description.unit_id=units.id " .
      "WHERE " .
        "units.id=" . (int)$unit_id . " AND " .
        "units_description.language_code='" . $language_code . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test record quantity
    if ( $result->num_rows != 1 )
    {

      // Set default value
      $unit_abbreviation = '';

    }
    else
    {

      // Get unit abbrevation
      $unit_abbreviation = $result->row[ 'abbreviation' ];

    }

    // Return unit abbrevation
    return( $unit_abbreviation );

  }

  //----------------------------------------------------------------------------
  // Get groups unit
  //----------------------------------------------------------------------------

  public function Get_Group_Units( $guid='' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`units`.`guid` AS guid, " .
        "`units`.`status` AS status, " .
        "`units`.`name` AS name " .
        // "`units`.`description` AS description " .
      "FROM " .
        "units ".
      "WHERE " .
        "units.group_guid='" . $this->db->escape( $guid ) . "'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return ($query->rows);

  }

  //----------------------------------------------------------------------------
  // Get groups unit
  //----------------------------------------------------------------------------

  public function Get_Unit_Description( $guid='', $language_code='XX'  )
  {

    // Compose SQL query
    $sql =
      "SELECT * " .
      "FROM " .
        "units_description ".
      "WHERE " .
        "units_description.guid='" . $this->db->escape( $guid ) . "' AND ".
        "units_description.language_code='" . $this->db->escape( $language_code ) . "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

        //------------------------------------------------------------------------
        // ERROR: unit not found
        //------------------------------------------------------------------------

        // Set default data
        $data[ 'return_code' ] = false;
        $data[ 'data' ] = array();

      }
      else
      {

      //------------------------------------------------------------------------
      // unit found
      //------------------------------------------------------------------------

      // Set product data
      $data[ 'return_code' ] = true;
      $data[ 'data' ][ 'abbreviation' ] =  $query->row[ 'abbreviation' ];
      $data[ 'data' ][ 'unit_declination_0' ] =  $query->row[ 'unit_declination_0' ];
      $data[ 'data' ][ 'name_declination_0' ] = $query->row[ 'name_declination_0' ];
      $data[ 'data' ][ 'unit_declination_1' ] = $query->row[ 'unit_declination_1' ];
      $data[ 'data' ][ 'name_declination_1' ] = $query->row[ 'name_declination_1' ];
      $data[ 'data' ][ 'unit_declination_2' ] = $query->row[ 'unit_declination_2' ];
      $data[ 'data' ][ 'name_declination_2' ] = $query->row[ 'name_declination_2' ];
      $data[ 'data' ][ 'unit_declination_3' ] = $query->row[ 'unit_declination_3' ];
      $data[ 'data' ][ 'name_declination_3' ] = $query->row[ 'name_declination_3' ];

    }

    // Return unit description
    return ($data);

  }

  //----------------------------------------------------------------------------
  // Get unit referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Unit_Exists( $guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`units`.`guid` AS guid " .
      "FROM " .
        "`units` " .
      "WHERE " .
        "`units`.`guid`='" . $this->db->escape($guid) . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for unit exists
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

      // Set unit found status
      $unit_found = true;

    }

    // Return status
    return( $unit_found );

  }

  //----------------------------------------------------------------------------
  // Get unit information
  //----------------------------------------------------------------------------

  public function Get_Unit_Info( $unit_id, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT * " .
      "FROM " .
        "units_description " .
      "LEFT JOIN " .
        "units " .
      "ON " .
        "units_description.unit_id=units.id " .
      "WHERE " .
        "units.id=" . $this->db->escape( (int)$unit_id ) . " AND " .
        "units_description.language_code='" . $this->db->escape( $language_code ) . "'";

    // Query database
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

       //------------------------------------------------------------------------
       // ERROR: unit not found
       //------------------------------------------------------------------------

       // Set default data
       $data[ 'return_code' ] = false;
       $data[ 'data' ] = array();

     }
     else
     {

      //------------------------------------------------------------------------
      // unit found
      //------------------------------------------------------------------------

      // Set product data
      $data[ 'return_code' ] = true;
      $data[ 'data' ][ 'unit_id' ] =  $query->row[ 'unit_id' ];
      $data[ 'data' ][ 'symbol' ] =  $query->row[ 'symbol' ];
      $data[ 'data' ][ 'name' ] =  $query->row[ 'name' ];
      $data[ 'data' ][ 'language_code' ] =  $query->row[ 'language_code' ];
      $data[ 'data' ][ 'abbreviation' ] =  $query->row[ 'abbreviation' ];
      $data[ 'data' ][ 'unit_declination_0' ] =  $query->row[ 'unit_declination_0' ];
      $data[ 'data' ][ 'name_declination_0' ] = $query->row[ 'name_declination_0' ];
      $data[ 'data' ][ 'unit_declination_1' ] = $query->row[ 'unit_declination_1' ];
      $data[ 'data' ][ 'name_declination_1' ] = $query->row[ 'name_declination_1' ];
      $data[ 'data' ][ 'unit_declination_2' ] = $query->row[ 'unit_declination_2' ];
      $data[ 'data' ][ 'name_declination_2' ] = $query->row[ 'name_declination_2' ];
      $data[ 'data' ][ 'unit_declination_3' ] = $query->row[ 'unit_declination_3' ];
      $data[ 'data' ][ 'name_declination_3' ] = $query->row[ 'name_declination_3' ];

    }

    // Return unit information
    return( $data );

  }


  //----------------------------------------------------------------------------
  // Get unit information
  //----------------------------------------------------------------------------

  public function Get_Unit_Info_By_GUID( $unit_guid, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
      "`units`.`guid` AS guid, " .
      "`units`.`group_guid` AS group_guid, " .
      "`units`.`status` AS status, " .
      // "`units`.`default` AS default, " .
      "`units`.`fixed` AS fixed, " .
      "`units`.`creation_date` AS creation_date, " .
      "`units`.`modification_date` AS modification_date, " .
      "`units_description`.`name` AS name, " .
      "`units_description`.`language_code` AS language_code, " .
      "`units_description`.`abbreviation` AS abbreviation, " .
      "`units_description`.`symbol` AS symbol, " .
      "`units_description`.`unit_declination_0` AS unit_declination_0, " .
      "`units_description`.`name_declination_0` AS name_declination_0, " .
      "`units_description`.`unit_declination_1` AS unit_declination_1, " .
      "`units_description`.`name_declination_1` AS name_declination_1, " .
      "`units_description`.`unit_declination_2` AS unit_declination_2, " .
      "`units_description`.`name_declination_2` AS name_declination_2, " .
      "`units_description`.`unit_declination_3` AS unit_declination_3, " .
      "`units_description`.`name_declination_3` AS name_declination_3 " .
      "FROM " .
        "units_description " .
      "LEFT JOIN " .
        "units " .
      "ON " .
        "units_description.guid=units.guid " .
      "WHERE " .
        "units.guid='" . $this->db->escape($unit_guid) . "' AND " .
        "units_description.language_code='" . $this->db->escape($language_code) . "'";

        $this->log->Log_Debug( 'sql ' .   $sql );

      // Query database
      $query = $this->db->query( $sql );

      // Test for item exists
      if ( $query->num_rows != 1 )
      {

        //------------------------------------------------------------------------
        // ERROR: unit not found
        //------------------------------------------------------------------------

        // Set default data
        $data[ 'return_code' ] = false;
        $data[ 'data' ] = array();

      }
      else
      {

        //------------------------------------------------------------------------
        // unit found
        //------------------------------------------------------------------------

        // Set product data
        $data[ 'return_code' ] = true;
        $data[ 'data' ][ 'guid' ] =  $query->row[ 'guid' ];
        $data[ 'data' ][ 'abbreviation' ] =  $query->row[ 'abbreviation' ];
        $data[ 'data' ][ 'symbol' ] =  $query->row[ 'symbol' ];
        $data[ 'data' ][ 'name' ] =  $query->row[ 'name' ];
        $data[ 'data' ][ 'language_code' ] =  $query->row[ 'language_code' ];
        $data[ 'data' ][ 'creation_date' ] =  $query->row[ 'creation_date' ];
        $data[ 'data' ][ 'modification_date' ] =  $query->row[ 'modification_date' ];
        $data[ 'data' ][ 'unit_declination_0' ] =  $query->row[ 'unit_declination_0' ];
        $data[ 'data' ][ 'name_declination_0' ] = $query->row[ 'name_declination_0' ];
        $data[ 'data' ][ 'unit_declination_1' ] = $query->row[ 'unit_declination_1' ];
        $data[ 'data' ][ 'name_declination_1' ] = $query->row[ 'name_declination_1' ];
        $data[ 'data' ][ 'unit_declination_2' ] = $query->row[ 'unit_declination_2' ];
        $data[ 'data' ][ 'name_declination_2' ] = $query->row[ 'name_declination_2' ];
        $data[ 'data' ][ 'unit_declination_3' ] = $query->row[ 'unit_declination_3' ];
        $data[ 'data' ][ 'name_declination_3' ] = $query->row[ 'name_declination_3' ];

      }

      // Return unit information
      return( $data );

  }

  //----------------------------------------------------------------------------
  // Create new group unit
  //----------------------------------------------------------------------------

  public function Create_Group_Unit( $guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`unit_groups` " .
      "SET " .
        "`unit_groups`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`unit_groups`.`name`='" . $this->db->escape( $data[ 'name_en' ] ) . "', " .
        "`unit_groups`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "', ".
        "`unit_groups`.`creation_date`= NOW(), " .
        "`unit_groups`.`modification_date`= NOW()";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for name setted
      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`unit_group_description` " .
        "SET " .
          "`unit_group_description`.`group_guid`='" . $this->db->escape( $guid ) . "', " .
          "`unit_group_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`unit_group_description`.`name`='" . $this->db->escape( $data[ 'name_' . $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Create new unit
  //----------------------------------------------------------------------------

  public function Create_Unit( $guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`units` " .
      "SET " .
        "`units`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`units`.`name`='" . $this->db->escape( $data[ 'name' ]['en'] ) . "', " .
        "`units`.`symbol`='" . $this->db->escape( $data[ 'symbol' ]['en'] ) . "', " .
        "`units`.`group_guid`='" . $this->db->escape( $data[ 'group_guid' ] ) . "', " .
        "`units`.`creation_date`=NOW(), " .
        "`units`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "' ";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of active languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`units_description` " .
        "SET " .
          "`units_description`.`guid`='" . $this->db->escape( $guid ) . "', " .
          "`units_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`units_description`.`symbol`='". $this->db->escape( $data[ 'symbol_' . $language[ 'code' ] ]  ) . "', " .
          "`units_description`.`name`='" . $this->db->escape( $data[ 'name_' . $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success/error code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Update unit
  //----------------------------------------------------------------------------

  public function Update_Unit( $data = array() )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`units` " .
      "SET " .
        "`units`.`status`='" . $this->db->escape( $data[ 'status' ] ) . "', " .
        "`units`.`name`='" . $this->db->escape( $data[ 'name' ]['en'] ) . "', " .
        "`units`.`modification_date`=NOW(), " .
        "`units`.`symbol`='" . $this->db->escape( $data[ 'symbol']['en'] ) . "' " .
      "WHERE " .
        "`units`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    // Iterate over all languages
    foreach( $languages as $language )
    {

      // Test for language exists
      if( isset( $data[ 'name' ][ $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "INSERT INTO " .
          "`units_description` " .
        "SET " .
          "`units_description`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
          "`units_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`units_description`.`symbol`='". $this->db->escape( $data[ 'symbol'][ $language[ 'code' ] ]  ) . "', " .
          "`units_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "' " .
        "ON DUPLICATE KEY UPDATE " .
          "`units_description`.`name`='" . $this->db->escape( $data[ 'name' ][ $language[ 'code' ] ] ) . "', " .
          "`units_description`.`symbol`='". $this->db->escape( $data[ 'symbol'][ $language[ 'code' ] ]  ) . "'" ;

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Change unit Status
  //----------------------------------------------------------------------------

  public function Change_Unit_Status( $unit_guid='00000000000000000000000000000000', $status='inactive' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`units` " .
      "SET " .
        "`units`.`status`='" . $this->db->escape( $status ) . "' " .
      "WHERE " .
        "`units`.`guid`='" . $this->db->escape( $unit_guid ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Return group
    return( true );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>