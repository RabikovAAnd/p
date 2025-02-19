<?php
class ModelCategoriesCategories extends Model
{

  // Database fields size definitions
  private const category_name_field_size = 127;
  private const category_description_short_field_size = 127;
  private const category_description_field_size = 255;
  private const category_picture_size = 8388608; // 8MB

  //----------------------------------------------------------------------------
  // Return maximum string size of category name database field
  //----------------------------------------------------------------------------

  public function Get_Category_Name_Maximum_String_Size()
  {

    // Return maximum string size of category name database field
    return( self::category_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of category short description database field
  //----------------------------------------------------------------------------

  public function Get_Category_Short_Description_Maximum_String_Size()
  {

    // Return maximum string size of category short description database field
    return( self::category_description_short_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of category description database field
  //----------------------------------------------------------------------------

  public function Get_Category_Description_Maximum_String_Size()
  {

    // Return maximum string size of category description database field
    return( self::category_description_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum size of category picture
  //----------------------------------------------------------------------------

  public function Get_Category_Picture_Maximum_Size()
  {

    // Return maximum size of category picture
    return( self::category_picture_size );

  }

  //----------------------------------------------------------------------------
  // Get active categories
  //----------------------------------------------------------------------------

  public function Get_GUID_Of_Active_Categories()
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category`.`guid` AS guid " .
      "FROM " .
        "`category` " .
      "WHERE " .
        "`category`.`status`='active'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Create new category
  //----------------------------------------------------------------------------

  public function Create_Category( $guid = '', $data = [] )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`category` " .
      "SET " .
        "`category`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`category`.`parent_guid`='" . $this->db->escape( $data[ 'parent_guid' ] ) . "', " .
        "`category`.`name`='" . $this->db->escape( $data[ 'name_en' ] ) . "', " .
        "`category`.`status`= '" . $this->db->escape( $data[ 'status' ] ) . "', " .
        "`category`.`date_added`= NOW()";

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
          "`category_description` " .
        "SET " .
          "`category_description`.`category_guid`='" . $this->db->escape( $guid ) . "', " .
          "`category_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "', " .
          "`category_description`.`name`='" . $this->db->escape( $data[ 'name_' . $language[ 'code' ] ] ) . "'";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return success/error code
    return( true );

  }

 //----------------------------------------------------------------------------
  // Get category information
  //----------------------------------------------------------------------------

  public function Get_Category_Information( $category_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category`.`guid` AS guid, " .
        "`category`.`status` AS status, " .
        "`category`.`parent_guid` AS parent_guid, " .
        "`category`.`date_added` AS date_added, " .
        "`category_description`.`name` AS name, " .
        "`category_description`.`description_short` AS description_short, " .
        "`category_description`.`description` AS description " .
      "FROM " .
        "`category` " .
      "LEFT JOIN " .
        "`category_description` " .
      "ON " .
        "`category`.`guid`=`category_description`.`category_guid` " .
      "WHERE " .
        "`category_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND " .
        "`category`.`guid`='" . $this->db->escape( $category_guid ) . "' ";

    // Perform SQL query
   $query = $this->db->query( $sql );

    // Test record count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'guid' ] = '';
      $return_data[ 'parent_guid' ] =  '';
      $return_data[ 'date_added' ] =  '0000-00-00 00:00:00';
      $return_data[ 'status' ] = 'inactive';
      $return_data[ 'name' ] =  '';
      $return_data[ 'description' ] = '';

    }
    else
    {

      // Set properties description
      $return_data[ 'valid' ] = true;
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'date_added' ] = $query->row[ 'date_added' ];
      $return_data[ 'parent_guid' ] = $query->row[ 'parent_guid' ];
      $return_data[ 'status' ] = $query->row[ 'status' ];
      $return_data[ 'name' ] = $query->row[ 'name' ];
      $return_data[ 'description_short' ] = $query->row[ 'description_short' ];
      $return_data[ 'description' ] = $query->row[ 'description' ];

    }

    // Return properties description
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get teaser catagories
  //----------------------------------------------------------------------------

  public function Get_Teaser_Categories( $category_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category`.`guid` AS guid " .
      "FROM " .
        "`category` " .
      "WHERE " .
//        "`category`.`parent_category_guid`='" . $category_guid . "' AND " .
        "`category`.`status`='active' AND " .
        "`category`.`teaser`=1";

    // Execute query
    $query = $this->db->query( $sql );

    // Return data
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get category referenced by category id
  //----------------------------------------------------------------------------

  public function Get_Category( $category_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT DISTINCT " .
        "`category`.`guid` AS guid, " .
        "`category`.`image_type`, " .
        "`category`.`image_data`, " .
        "`category_description`.`name` AS name, " .
        "`category_description`.`description_short` AS description_short, " .
        "`category_description`.`description` AS description " .
      "FROM " .
        "`category` " .
      "LEFT JOIN " .
        "`category_description` ".
      "ON " .
        "`category`.`guid`=`category_description`.`category_guid` " .
      "WHERE " .
        "`category`.`guid`='" . $this->db->escape( $category_guid ) . "' AND " .
        "`category_description`.`language_code`='" . $this->db->escape( $language_code ). "' " .
        // "`category`.`status`='active' " .
      "LIMIT 1";

    // Execute quiery
    $query = $this->db->query( $sql );

    // Test for no query result
    if ( !isset( $query->row ) )
    {

      //------------------------------------------------------------------------
      // ERROR: SQL query processing failed
      //------------------------------------------------------------------------

      // Set default values
      $result = array(
        'guid' => '',
        'image_type' => '',
        'image_data' => '',
        'name' => '',
        'description_short' => '',
        'description' => ''
      );

    }
    else
    {

      //------------------------------------------------------------------------
      // SQL query processed
      //------------------------------------------------------------------------

      // Assugn query result
      $result = array(
        'guid' => $query->row[ 0 ],
        'image_type' => $query->row[ 1 ],
        'image_data' => $query->row[ 2 ] !== null ? $query->row[ 2 ] : '',
        'name' => $query->row[ 3 ],
        'description_short' => $query->row[ 4 ],
        'description' => $query->row[ 5 ]
      );

    }

    // Return data
    return( $result );

  }

  //----------------------------------------------------------------------------
  // Get count of active subcategories
  //----------------------------------------------------------------------------

  public function Get_Subcategories_Count( $category_guid = '' ) : int
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "COUNT(*) " .
      "FROM " .
        "`category` " .
      "WHERE " .
        "`category`.`parent_guid`='" . $category_guid . "' AND " .
        "`category`.`status`='active'";

    // Execute query
    $query = $this->db->query( $sql );

    // Test for no query result
    if ( !isset( $query->row ) )
    {

      //------------------------------------------------------------------------
      // ERROR: SQL query processing failed
      //------------------------------------------------------------------------

      // Set count of subcategories to 0
      $count = 0;

    }
    else
    {

      //------------------------------------------------------------------------
      // SQL query processed
      //------------------------------------------------------------------------

      // Get count of the subcategories
      $count = $query->row[ 0 ];

    }

    // Return data
    return( $count );

  }

  //----------------------------------------------------------------------------
  // Get Category subcategories
  //----------------------------------------------------------------------------

  public function Get_Subcategories( $category_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`category` " .
      "LEFT JOIN " .
        "`category_description` " .
      "ON " .
        "`category`.`guid`=`category_description`.`category_guid` " .
      "WHERE " .
        "`category_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND " .
        "`category`.`parent_guid`='" . $this->db->escape( $category_guid ). "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get Categories
  //----------------------------------------------------------------------------

  public function Get_Categories( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        " * " .
      "FROM " .
        "`category` " .
      "LEFT JOIN " .
        "`category_description` " .
      "ON " .
        "`category`.`guid`=`category_description`.`category_guid` " .
      "WHERE " .
        "`category_description`.`language_code`='" . $this->db->escape( $language_code ). "'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return properties description
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get list of categories
  //----------------------------------------------------------------------------

  public function Get_List_Of_Categories(
    $page_length = 30,
    $page_number = 1,
    $search = '',
    $language_code = 'XX'
  )
  {

    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "category.guid AS guid, " .
        "category.status AS status, " .
        "category_description.name AS name " .
      "FROM " .
        "category " .
      "LEFT JOIN " .
        "category_description " .
      "ON " .
        "category.guid=category_description.category_guid " .
      "WHERE " .
        "category_description.name  LIKE '%" . $this->db->escape( $search ) . "%' AND " .
        "category_description.language_code='" . $this->db->escape( $language_code ) . "' " .
      "LIMIT " . $this->db->escape( $page_length ) . " " .
      "OFFSET " . $this->db->escape( $page_length * ( $page_number - 1 ) ) . ";";

    // Query database
    $results = $this->db->query( $sql );

    // Return data
    return( $results->rows );

  }

  //----------------------------------------------------------------------------
  // Get category images
  //----------------------------------------------------------------------------

  public function Get_Category_Image( $category_guid = '' )
  {

    // Initialise return data
    $return_data = array();

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category_pictures`.`guid` AS `guid`, " .
        "`category_pictures`.`type` AS `type`, " .
        "`category_pictures`.`data` AS `data` " .
      "FROM " .
        "`category_pictures` " .
      "WHERE " .
        "`category_pictures`.`guid`='" . $this->db->escape( $category_guid ) . "' ";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for single picture not found
    if ( $query->num_rows != 1 )
    {
      
      //------------------------------------------------------------------------
      // No data found
      //------------------------------------------------------------------------
      
      // Set error code
      $return_data[ 'return_code' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Data found
      //------------------------------------------------------------------------

      // Set picture data
      $return_data = $query->row;

      // Set success code
      $return_data[ 'return_code' ] = true;

    }

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get category description
  //----------------------------------------------------------------------------

  public function Get_Category_Description( $category_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category_description`.`name` AS name, " .
        "`category_description`.`description` AS description, " .
        "`category_description`.`description_short` AS description_short, " .
        "`category_description`.`language_code` AS language_code " .
      "FROM " .
        "`category_description` " .
      "WHERE " .
        "`category_description`.`category_guid`='" . $this->db->escape( $category_guid ) . "'";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Return group
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Edit category information
  //----------------------------------------------------------------------------

  public function Edit_Category( $data = [] )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`category` " .
      "SET " .
        "`category`.`name`='" . $this->db->escape( $data[ 'name_en' ] ) . "', " .
        "`category`.`status`='" . $this->db->escape( $data[ 'status' ] ) . "' " .
      "WHERE " .
        "`category`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Get list of languages
    $languages = $this->language->Get_Languages();

    foreach( $languages as $language )
    {

      if( isset( $data[ 'name_' . $language[ 'code' ] ] ) === true )
      {

        // Compose SQL query
        $sql =
        "UPDATE " .
          "`category_description` " .
        "SET " .
          "`category_description`.`name`='" . $this->db->escape( $data['name_' . $language[ 'code' ] ] ) . "' " .
        "WHERE " .
          "`category_description`.`language_code`='". $this->db->escape( $language[ 'guid' ] ) . "'" . " AND " .
          "`category_description`.`category_guid`='" . $this->db->escape( $data[ 'guid' ] ) . "' ";

        // Query database
        $this->db->query( $sql );

      }

    }

    // Return group
    return( true );

  }

  // //----------------------------------------------------------------------------
  // // Get Categories To Move
  // //----------------------------------------------------------------------------

  // public function Get_Categories_To_Move($category_guid='00000000000000000000000000000000', $language_code = 'XX' )
  // {

  //   // Compose SQL query
  //   $sql =
  //     "SELECT " .
  //       " * " .
  //     "FROM " .
  //       "`category` " .
  //     "LEFT JOIN " .
  //       "`category_description` " .
  //     "ON " .
  //       "`category`.`guid`=`category_description`.`category_guid` " .
  //     "WHERE " .
  //       "`category_description`.`language_code`='" . $this->db->escape( $language_code ). "' AND " .
  //       "`category_description`.`category_guid`='" . $this->db->escape( $category_guid ). "' AND " .
  //       "`category`.`parent_guid`!='" . $this->db->escape( $category_guid ) . "' " ;

  //   // Perform SQL query
  //   $query = $this->db->query( $sql );

  //   // Return properties description
  //   return( $query->rows );

  // }
  //----------------------------------------------------------------------------
  // Move category 
  //----------------------------------------------------------------------------

  public function Move_Category( $data = [] )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`category` " .
      "SET " .
        "`category`.`parent_guid`='" . $this->db->escape( $data[ 'parent_guid' ] ) . "' " .
      "WHERE " .
        "`category`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Return group
    return( true );

  }

 //----------------------------------------------------------------------------
  // Change category status
  //----------------------------------------------------------------------------

  public function Change_Category_Status( $category_guid='00000000000000000000000000000000', $status='inactive' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`category` " .
      "SET " .
        "`category`.`status`='" . $this->db->escape( $status ) . "' " .
      "WHERE " .
        "`category`.`guid`='" . $this->db->escape( $category_guid ) . "'";

    // Perform SQL query
    $this->db->query( $sql );

    // Return group
    return( true );

  }

  //----------------------------------------------------------------------------
  // Get category referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_By_GUID( $category_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category`.`guid` AS guid " .
      "FROM " .
        "`category` " .
      "WHERE " .
        "`category`.`guid`='" . $this->db->escape( $category_guid ) . "' AND " .
        "`category`.`status`='active' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for category exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Category not found
      //------------------------------------------------------------------------

      // Set not found status
      $category_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Category found
      //------------------------------------------------------------------------

      // Set category found status
      $category_found = true;

    }

    // Return status
    return( $category_found );

  }

  //----------------------------------------------------------------------------
  // Get category referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Category_Image_Exists( $category_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`category_pictures`.`guid` AS guid " .
      "FROM " .
        "`category_pictures` " .
      "WHERE " .
        "`category_pictures`.`guid`='" . $this->db->escape( $category_guid ). "' ".
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for image exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Image not found
      //------------------------------------------------------------------------

      // Set not found status
      $image_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Image found
      //------------------------------------------------------------------------

      // Set image found status
      $image_found = true;

    }

    // Return status
    return( $image_found );

  }

  //----------------------------------------------------------------------------
  // Add category image
  //----------------------------------------------------------------------------

  public function Add_Category_Image( $data )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`category_pictures` " .
      "SET " .
        "`category_pictures`.`guid`='" . $this->db->escape( $data[ 'category_guid' ] ) . "', " .
        "`category_pictures`.`type`='" . $this->db->escape( $data[ 'type' ] ) . "', " .
        "`category_pictures`.`data`='" . $this->db->escape( $data[ 'image_data' ] ) . "', " .
        "`category_pictures`.`creation_date`=NOW(), " .
        "`category_pictures`.`modification_date`=NOW() " .
      "ON DUPLICATE KEY UPDATE" .
        "`category_pictures`.`type`='" . $this->db->escape( $data[ 'type' ] ) . "', " .
        "`category_pictures`.`data`='" . $this->db->escape( $data[ 'image_data' ] ) . "', " .
        "`category_pictures`.`modification_date`=NOW()";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return( $return_code );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>