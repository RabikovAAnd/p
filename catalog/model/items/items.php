<?php
class ModelItemsItems extends Model
{

  // Database fields size definitions
  private const item_mpn_field_size = 127;
  private const item_order_code_field_size = 127;
  private const item_name_field_size = 127;
  private const item_description_field_size = 255;

  //----------------------------------------------------------------------------
  // Return maximum string size of item MPN database field
  //----------------------------------------------------------------------------

  public function Get_Item_MPN_Maximum_String_Size()
  {

    // Return maximum string size of item MPN database field
    return( self::item_mpn_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of item order code database field
  //----------------------------------------------------------------------------

  public function Get_Item_Order_Code_Maximum_String_Size()
  {

    // Return maximum string size of item order code database field
    return( self::item_order_code_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of item name database field
  //----------------------------------------------------------------------------

  public function Get_Item_Name_Maximum_String_Size()
  {

    // Return maximum string size of item name database field
    return( self::item_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of item description database field
  //----------------------------------------------------------------------------

  public function Get_Item_Description_Maximum_String_Size()
  {

    // Return maximum string size of item description database field
    return( self::item_description_field_size );

  }

  //----------------------------------------------------------------------------
  // Get item information
  //----------------------------------------------------------------------------

  public function Get_Information( $item_guid = '00000000000000000000000000000000', $language_code='XX' )
  {

    //! @todo ANVILEX KM: Test for language code valid

    // Initialise return data
    $return_data = array();

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product`.`product_id` AS `item_id`, " .
        "`product`.`guid` AS `guid`, " .
        "`product`.`atomic` AS `atomic_item`, " .
        "`product`.`mpn` AS `mpn`, " .
        "`product`.`order_code` AS `order_code`, " .
        "`product`.`units_id` AS `quantisation_unit_id`, " . //! @todo ANVILEX KM: Remove
//        "`product_description`.`description` AS `description`, " .
        "`product`.`price` AS `price`, " . //! @todo ANVILEX KM: Remove
        "`customer`.`guid` AS `manufacturer_guid`, " .
        "`customer`.`company_name` AS `manufacturer_name`, " .
        "`product`.`lifecycle_status_id` AS `product_lifecycle_id` " .
      "FROM " .
        "`product` " .
//      "LEFT JOIN " .
//        "`product_description` " .
//      "ON " .
//        "`product_description`.`item_guid`=`product`.`guid` " .
      "LEFT JOIN " .
        "`customer` " .
      "ON " .
        "`customer`.`guid`=`product`.`manufacturer_guid` " .
      "WHERE " .
        "`product`.`guid`='" . $this->db->escape( $item_guid ) . "' AND " .
//        "`product_description`.`language_code`='" . $this->db->escape( $language_code ) . "' AND " .
        "`product`.`active`=1 " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );
    
    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'item_id' ] = '0';
      $return_data[ 'guid' ] = '00000000000000000000000000000000';
      $return_data[ 'product_mpn' ] = ''; //! @todo ANVILEX KM: Remove
      $return_data[ 'mpn' ] = '';
      $return_data[ 'price' ] = 0.000000; //! @todo ANVILEX KM: Remove
      $return_data[ 'order_code' ] = '';
      $return_data[ 'manufacturer_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'manufacturer_name' ] = '';
      $return_data[ 'atomic_item' ] = true;
      $return_data[ 'product_lifecycle_id' ] = '';
      $return_data[ 'quantisation_unit_id' ] = '';
      $return_data[ 'quantisation_unit_name' ] = '';

      // Set error code
      $return_data[ 'return_code' ] = false;

    }
    else
    {

      // Get product quantisation unit
      $quantisation_unit_name = $this->units->getUnitAbbreviation( $query->row[ 'quantisation_unit_id' ], $language_code );

      // Set product data
      $return_data[ 'valid' ] = true;
      $return_data[ 'item_id' ] = $query->row[ 'item_id' ];
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'product_mpn' ] = $query->row[ 'mpn' ]; //! @todo ANVILEX KM: Remove
      $return_data[ 'mpn' ] = $query->row[ 'mpn' ];
      $return_data[ 'price' ] = $query->row[ 'price' ]; //! @todo ANVILEX KM: Remove
      $return_data[ 'order_code' ] = $query->row[ 'order_code' ];
      $return_data[ 'manufacturer_guid' ] = $query->row[ 'manufacturer_guid' ];
      $return_data[ 'manufacturer_name' ] = $query->row[ 'manufacturer_name' ];
      $return_data[ 'atomic_item' ] = ( $query->row[ 'atomic_item' ] == '1' ? true : false );
      $return_data[ 'product_lifecycle_id' ] = $query->row[ 'product_lifecycle_id' ];
      $return_data[ 'quantisation_unit_id' ] = $query->row[ 'quantisation_unit_id' ];
      $return_data[ 'quantisation_unit_name' ] = $quantisation_unit_name;

      // Set success code
      $return_data[ 'return_code' ] = true;

    }

    // Return item data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get list of favorite items observed by customer
  //----------------------------------------------------------------------------

  public function Get_Favorite_Items( $customer_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`customer_items`.`item_guid` AS guid " .
      "FROM " .
        "`customer_items` " .
      "WHERE ".
        "`customer_items`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Check for item in customers favorite liste
  //----------------------------------------------------------------------------

  public function Is_In_Favorites( $customer_guid = '', $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`customer_items`.`item_guid` " .
      "FROM " .
        "`customer_items` " .
      "WHERE " .
        "`customer_items`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`customer_items`.`item_guid`='" . $this->db->escape( $item_guid ) . "' " .
      "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Observed item not found
      //------------------------------------------------------------------------

      // Set project not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Observed item found
      //------------------------------------------------------------------------

      // Set project found status
      $item_found = true;

    }

    // Return status
    return( $item_found );

  }

  //----------------------------------------------------------------------------
  // Add item to customer favorites list
  //----------------------------------------------------------------------------

  public function Add_To_Favorites( $customer_guid = '00000000000000000000000000000000', $item_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT IGNORE INTO " .
        "`customer_items` " .
      "SET " .
        "`customer_items`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "', " .
        "`customer_items`.`item_guid`='" . $this->db->escape( $item_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Revove item to customer favorites list
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites( $customer_guid = '00000000000000000000000000000000', $item_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`customer_items` " .
      "WHERE " .
        "`customer_items`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`customer_items`.`item_guid`='". $this->db->escape( $item_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  // //----------------------------------------------------------------------------
  // // Get property information
  // //----------------------------------------------------------------------------

  // public function Get_Property_Information( $property_guid = '', $language_code = 'XX' )
  // {

  //   // Compose SQL query
  //   $sql =
  //     "SELECT " .
  //       "`properties`.`guid` AS property_guid, " .
  //       "`properties`.`group_guid` AS group_guid, " .
  //       "`properties_description`.`name` AS name, " .
  //       "`properties`.`units_guid` AS units_guid, " .
  //       "`properties_description`.`description` AS description " .
  //     "FROM " .
  //       "properties " .
  //     "LEFT JOIN " .
  //       "`properties_description` " .
  //     "ON " .
  //       "`properties`.`guid`=`properties_description`.`property_guid` " .
  //     "WHERE " .
  //       "`properties_description`.`language_code`='" . $language_code . "' AND " .
  //       "`properties`.`guid`='" . $property_guid . "' "  ;

  //   // Perform SQL query
  //  $query = $this->db->query( $sql );

  //   // Test record count
  //   if ( $query->num_rows != 1 )
  //   {

  //     // Set default data
  //     $return_data[ 'valid' ] = false;
  //     $return_data[ 'guid' ] = '';
  //     $return_data[ 'group_guid' ] =  '';
  //     $return_data[ 'name' ] =  '';
  //     $return_data[ 'units_guid' ] = '';
  //     $return_data[ 'description' ] = '';

  //   }
  //   else
  //   {

  //     // Set properties description
  //     $return_data[ 'valid' ] = true;
  //     $return_data[ 'guid' ] = $query->row[ 'property_guid' ];
  //     $return_data[ 'group_guid' ] = $query->row[ 'group_guid' ];
  //     $return_data[ 'name' ] = $query->row[ 'name' ];
  //     $return_data[ 'units_guid' ] = $query->row[ 'units_guid' ];
  //     $return_data[ 'description' ] = $query->row[ 'description' ];

  //   }

  //   // Return properties description
  //   return( $return_data );

  // }


  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function Is_Exists( $mpn ='', $manufacturer_guid='' ) : bool
  {

    // Test for mpn and manufacturer_id empty
    if ( 
      ( $mpn == '' ) || 
      ( $manufacturer_guid == '' ) 
    )
    {

      //------------------------------------------------------------------------
      // ERROR:  Mpn and manufacturer_guid  is empty
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      //  MPN and manufacturer_guid  not empty
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql =
        "SELECT " .
          "`product`.`guid` " .
        "FROM " .
          "`product` " .
        "WHERE " .
          "`product`.`mpn`='" . $this->db->escape( $mpn ) . "' AND " .
          "`product`.`manufacturer_guid`='" . $this->db->escape( $manufacturer_guid ) . "'" .
        "LIMIT 1";

      // Query database
      $result = $this->db->query( $sql );

      // Test record count
      if ( $result->num_rows == 0 )
      {

        //----------------------------------------------------------------------
        // Item not found
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item found
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------
  //! @todo ANVILEX KM: This method is not needed ==> Use Is_Exists

  public function Is_Edit_Item_Exists( $guid='', $mpn ='', $manufacturer_guid='' ) : bool
  {

    // Test for mpn and manufacturer_id empty
    if (
      ( $guid == '' ) || 
      ( $mpn == '' ) || 
      ( $manufacturer_guid == '' )
    )
    {

      //------------------------------------------------------------------------
      // ERROR:  Mpn or manufacturer_guid or guid  is empty
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      //  MPN and manufacturer_guid and guid  not empty
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql =
        "SELECT " .
          "`product`.`guid` " .
        "FROM " .
          "`product` " .
        "WHERE " .
          "`product`.`mpn`='" . $this->db->escape( $mpn ) . "' AND " .
          "`product`.`manufacturer_guid`='" . $this->db->escape( $manufacturer_guid ) . "' AND " .
          "`product`.`guid`!='" . $this->db->escape( $guid ) . "'" .
        "LIMIT 1";

      // Query database
      $result = $this->db->query( $sql );

      // Test record count
      if ( $result->num_rows == 0 )
      {

        //----------------------------------------------------------------------
        // Item not found
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Item found
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return status
    return( $return_code );

  }


  //----------------------------------------------------------------------------
  // Edit item
  //----------------------------------------------------------------------------

  public function Edit( $item_data, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`product` " .
      "SET " .
        "`product`.`mpn`='" . $this->db->escape( $item_data[ 'mpn' ] ) . "', " .
        "`product`.`order_code`='" . $this->db->escape( $item_data[ 'order_code' ] ) . "', " .
        "`product`.`units_id`=" . $this->db->escape( $item_data[ 'unit' ] ) . ", " .
        "`product`.`atomic`='" .  ( ( $item_data[ 'atomic_item' ] === true ) ? '1' : '0' ) . "', " .
        "`product`.`manufacturer_guid`='" . $this->db->escape( $item_data[ 'manufacturer_guid' ] ) . "' " .
      "WHERE " .
        "`product`.`guid`='" . $this->db->escape( $item_data[ 'guid' ] ) . "' " ;

    // Query database
    $this->db->query( $sql );

    // Compose SQL query
    $sql =
      "INSERT INTO "  .
       "`product_description` " .
     "SET " .
       "`product_description`.`item_guid`='" . $this->db->escape( $item_data[ 'guid' ] ) . "', " .
       "`product_description`.`language_code`='" . $this->db->escape( $language_code ) . "', " .
       "`product_description`.`name`='" . $this->db->escape( $item_data[ 'mpn' ] ) . "', " .
       "`product_description`.`description`='" . $this->db->escape( $item_data[ 'description' ] ) . "', " .
       "`product_description`.`meta_description`='" . $this->db->escape( $item_data[ 'description' ] ) .  "', ".
       "`product_description`.`meta_keyword`='" . $this->db->escape( $item_data[ 'description' ] ) .  "', " .
       "`product_description`.`tag`='" . $this->db->escape( $item_data[ 'description' ] ) .  "' " .
     "ON DUPLICATE KEY UPDATE " .
       "`product_description`.`name`='" . $this->db->escape( $item_data[ 'mpn' ] ) . "', " .
       "`product_description`.`description`='" . $this->db->escape( $item_data[ 'description' ] ) .  "', ".
       "`product_description`.`meta_description`='" . $this->db->escape( $item_data[ 'description' ] ) .  "', ".
       "`product_description`.`meta_keyword`='" . $this->db->escape( $item_data[ 'description' ] ) .  "', ".
       "`product_description`.`tag`='" . $this->db->escape( $item_data[ 'description' ] ) .  "' ";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Update item MPN
  //----------------------------------------------------------------------------

  public function Update_MPN( $guid = '', $mpn = '' )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`product` " .
      "SET " .
        "`product`.`mpn`='" . $this->db->escape( $mpn ) . "' " .
      "WHERE " .
        "`product`.`guid`='" . $this->db->escape( $guid ) . "' " ;

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }


//   //----------------------------------------------------------------------------
//   // Get item subitems
//   //----------------------------------------------------------------------------

//   public function Get_Item_Subitems( $item_guid = '' )
//   {

//     // Compose SQL query
//     $sql =
//       "SELECT " .
//         "* " .
//       "FROM " .
//         "`item_subitems` " .
//       "WHERE " .
//         "`item_subitems`.`item_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
//         "`item_subitems`.`deleted`=0";

//     // Query database
//     $result = $this->db->query( $sql );

//     // Return data
//     return( $result->rows );

//  }


  //----------------------------------------------------------------------------
  // Create new item
  //----------------------------------------------------------------------------

  public function Add_Item( $data )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`product` " .
      "SET " .
        "`product`.`guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
        "`product`.`mpn`='" . $this->db->escape( $data[ 'mpn' ] ) . "', " .
        "`product`.`order_code`='" . $this->db->escape( $data[ 'order_code' ] ) . "', " .
        "`product`.`atomic`='" . ( ( $data[ 'atomic_item' ] === true ) ? '1' : '0' ) . "', " .
        "`product`.`manufacturer_guid`='" . $this->db->escape( $data[ 'manufacturer_guid' ] ) . "', " .
        "`product`.`active`='1', " .
        "`product`.`date_added`=NOW(), " .
        "`product`.`units_id`='" . $this->db->escape( $data[ 'unit' ] ) . "'";

    // Query database
    $this->db->query( $sql );

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`product_description` " .
      "SET " .
        "`product_description`.`item_guid`='" . $this->db->escape( $data[ 'guid' ] ) . "', " .
        "`product_description`.`language_code`='" . $this->db->escape( $this->language->Get_Language_Code() ) . "', " .
        "`product_description`.`name`='" . $this->db->escape( $data[ 'mpn' ] ) . "', " .
        "`product_description`.`meta_description`='" . $this->db->escape( $data[ 'mpn' ] ) . "', " .
        "`product_description`.`meta_keyword`='" . $this->db->escape( $data[ 'mpn' ] ) . "', " .
        "`product_description`.`tag`='" . $this->db->escape( $data[ 'mpn' ] ) . "', " .
        "`product_description`.`description`='" . $this->db->escape( $data[ 'description' ] ) . "'";

    // Query database
    $this->db->query( $sql );

    // Set return data
    $return_data[ 'return_code' ] = true;

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  //
  //----------------------------------------------------------------------------

  public function Get_Units( $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT `units`.`id` AS id, `units_description`.`name_declination_1` AS name " .
      "FROM units " .
      "LEFT JOIN " .
        "`units_description` " .
      "ON " .
        "`units`.`id`=`units_description`.`unit_id` " .
      "WHERE " .
        "`units_description`.`language_code`='" . $language_code . "' ";

    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );
  }

  //----------------------------------------------------------------------------
  // Get documents assigned to item
  //----------------------------------------------------------------------------

  public function Get_Documents( $item_guid = '' )
  {

//     // Create documents array
//     $documents = array();

    // Compose SQL query
    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`documents` " .
      "LEFT JOIN " .
        "`document_to_item` " .
      "ON " .
        "`documents`.`guid`=`document_to_item`.`document_guid` " .
      "WHERE " .
        "`document_to_item`.`item_guid`='" . $item_guid . "' ";

    // Execute quiery
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get product count referensed by category id
  //----------------------------------------------------------------------------

  public function getProductCountByCategory( $category_id )
  {

    // Compose SQL query
    $sql = "SELECT COUNT(*) FROM product_to_category WHERE category_id=" . (int)$category_id;

    // Execute quiery
    $query = $this->db->query( $sql );

    if ( !isset( $query->row ) )
    {

      // Set count of subcategories to 0
      $count = 0;

    }
    else
    {

      // Get count of the subcategories
      $count = $query->row[ 0 ];

    }

    // Return data
    return( $count );

  }

  //----------------------------------------------------------------------------
  // Get items referenced by catagory
  //----------------------------------------------------------------------------

  public function Get_Items_By_Category( $category_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product_to_category`.`item_guid` AS guid, " .
        "`product`.`active` " .
      "FROM " .
        "`product_to_category` " .
      "LEFT JOIN " .
        "`product` " .
      "ON " .
        "`product_to_category`.`item_guid`=`product`.`guid` " .
      "WHERE " .
        "`product_to_category`.`category_guid`='" . $category_guid . "' AND " .
        "`product`.`active`=1";

    // Quiery database
    $products = $this->db->query( $sql );

    // Return data
    return( $products->rows );

  }

  //----------------------------------------------------------------------------
  // Get list of items
  //----------------------------------------------------------------------------

  public function Get_List_Of_Items(
    $page_length = 30,
    $page_number = 1,
    $search = '',
    $id = false,
    $mpn = true,
    $description = false,
    $manufacturer = '',
    $language_code = 'XX'
  )
  {

    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();

    if ( $id === true )
    {
      $where_or[] = "product.product_id='" . $this->db->escape( $search ) . "' ";
    }

    if ( $mpn === true )
    {
      $where_or[] = "product.mpn LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $description === true )
    {
      $where_or[] = " product_description.description LIKE '%" . $this->db->escape( $search ) . "%'";
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

    if ( $manufacturer != '' )
    {
      $where_and[] = "customer.company_name LIKE '%" . $this->db->escape( $manufacturer ) . "%'";
    }

    if ( $description === true )
    {
      if( $language_code != 'XX' )
      {
        $where_and[] = "product_description.language_code='" . $this->db->escape( $language_code ) . "'";
      }
    }

    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode( ' AND ', $where_and );

    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "product.guid AS guid, " .
        "product.product_id AS id, " .
        "product.status_id AS status, " .
        "product.mpn AS mpn, " .
        "product_description.name AS name, " .
        "product_description.description AS description, " .
        "customer.company_name AS manufacturer_name " .
      "FROM " .
        "product " .
      "LEFT JOIN " .
        "product_description " .
      "ON " .
        "product.guid=product_description.item_guid " .
      "LEFT JOIN " .
        "customer " .
      "ON " .
        "product.manufacturer_guid=customer.guid " .
      "WHERE " .
        $where . " " .
//! @note ANVILEX KM: Sorting caused increase server response time.
//      "ORDER BY product.mpn ASC " .
      "LIMIT " . $this->db->escape( $page_length ) . " " .
      "OFFSET " . $this->db->escape( $page_length * ( $page_number - 1 ) ) . ";";


    // Query database
    $results = $this->db->query( $sql );

    // Return data
    return( $results->rows );

  }

  //----------------------------------------------------------------------------

  public function Search_Items_Count(
    $search = '',
    $id = false,
    $mpn = true,
    $description = false,
    $manufacturer='',
    $language_code = 'XX'
  )
  {

    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();

    if ( $search == '' )
    {


    }
    else
    {

      if ( $id === true )
      {
        $where_or[] = "product.product_id='" . $this->db->escape( $search ) . "' ";
      }

      if ( $mpn === true )
      {
        $where_or[] = "product.mpn LIKE '%" . $this->db->escape( $search ) . "%' ";
      }

      if (
        ( $description === true ) &&
        ( $language_code != 'XX' )
      )
      {
        $where_or[] = "product_description.description LIKE '%" . $this->db->escape( $search ) . "%'";
      }

    }

    //--------------------------------------------------------------------------
    // Compose AND part
    //--------------------------------------------------------------------------

    $where_and = array();

    if ( count( $where_or ) < 0 )
    {

      //------------------------------------------------------------------------
      // No OR parts present
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // OR parts valid
      //------------------------------------------------------------------------

      if ( count( $where_or ) == 0 )
      {

        //----------------------------------------------------------------------
        // Only one OR part exists
        //----------------------------------------------------------------------

//        $where_and[] = implode( ' OR ', $where_or );
        $where_and[] = implode( '', $where_or ) . ' ';

      }
      else
      {

        //----------------------------------------------------------------------
        // Multiple OR parts exists
        //----------------------------------------------------------------------

        $where_and[] = '( ' . implode( ' OR ', $where_or ) . ' ) ';

      }

    }

//! @bug ANVILEX KM: Manufacturer GUID must be passed to function for filterung
//    if ( $manufacturer != '' )
//    {
//      $where_and[] = "customer.company_name LIKE '%" . $this->db->escape( $manufacturer ) . "%'";
//    }

    $description_join = '';

    // Add description
    if (
      ( $description === true ) &&
      ( $language_code != 'XX' )
    )
    {

      $where_and[] = "product_description.language_code='" . $this->db->escape( $language_code ) . "'";

      $description_join =
        "LEFT JOIN " .
          "product_description " .
        "ON " .
          "product.guid=product_description.item_guid ";

    }

    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode( ' AND ', $where_and );

    if ( trim( $where ) != '' )
    {
      $where = "WHERE " . $where;
    }

    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "COUNT(*) " .
      "FROM " .
        "product " .
      $description_join .
//      "LEFT JOIN " .
//        "customer " .
//      "ON " .
//        "product.manufacturer_guid=customer.guid " .
//      "WHERE " .
        $where;


    // Query database
    $results = $this->db->query( $sql );

    // Return data
    return( $results->row[ 0 ] );

  }

  //----------------------------------------------------------------------------
//! @todo ANVILEX KM: Not used to remove ???
/*
  public function Item_Count()
  {

    // Compose SQL query
    $sql = "SELECT COUNT(*) ";
    $sql .= "FROM product ";
    $sql .= "WHERE status_id=0 ";

    // Quiery database
    $products = $this->db->query( $sql );

    // Return data
    return( $products->row[ 0 ] );
  }
*/
  //----------------------------------------------------------------------------
  // Get products counts by search query
  //----------------------------------------------------------------------------

  public function Get_Product_Count_By_Search_Query( $data = array() )
  {

    // Compose SQLquery
    $sql = "SELECT COUNT(*) ";
    $sql .= "FROM product p ";
    $sql .= "WHERE p.status=1 ";

    // Test for query string parameter set
    if ( $data[ 'query' ] != '' )
    {

      $sql .= "AND mpn LIKE '" . $this->db->escape( $data[ 'query' ] ) . "'";

    }

    // Quiery database
    $result = $this->db->query( $sql );

    if ( isset( $result->row ) == false )
    {

      // Set count of subcategories to 0
      $count = 0;

    }
    else
    {

      // Get count of the subcategories
      $count = $result->row[ 0 ];

    }

    // Return data
    return( $count );

  }

  //----------------------------------------------------------------------------
  // Get products by search query
  //----------------------------------------------------------------------------
  // query
  // start
  // limit
  //----------------------------------------------------------------------------

  public function Get_Products_By_Search_Query( $data = array() )
  {

    // Compose SQLquery
    $sql = "SELECT product_id AS id ";
    $sql .= "FROM product p ";
    $sql .= "WHERE p.status=1 ";

    // Test for query string parameter set
    if ( $data[ 'query' ] != '' )
    {

      $sql .= "AND mpn LIKE '" . $this->db->escape( $data[ 'query' ] ) . "' ";

    }

    // Test for limit parameter set
    if ( $data[ 'limit' ] != '' )
    {

      $sql .= "LIMIT " . (int)$data[ 'limit' ] . " ";

    }

    // Test for start parameter set
    if ( $data[ 'start' ] != '' )
    {

      $sql .= "OFFSET " . (int)$data[ 'start' ];

    }

    // Quiery database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get item referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_By_GUID( $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product`.`guid` AS guid " .
      "FROM " .
        "`product` " .
      "WHERE " .
        "`product`.`guid`='" . $item_guid . "' AND " .
        "`product`.`active`=1 " .
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
  // Get item referenced by ID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_By_ID( $item_id = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product`.`product_id` AS id " .
      "FROM " .
        "`product` " .
      "WHERE " .
        "`product`.`product_id`='" . $this->db->escape( $item_id ) . "' AND " .
        "`product`.`active`=1 " .
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
  // Get item information referenced by ID
  //----------------------------------------------------------------------------

  public function Get_Information_by_ID( $item_id = '0', $language_code='XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product`.`product_id` AS item_id, " .
        "`product`.`mpn` AS mpn, " .
        "`product`.`guid` AS guid, " .
        "`product`.`guid` AS manufacturer_guid, " .
        "`customer`.`company_name` AS manufacturer_name, " .
        "`product`.`lifecycle_status_id` AS product_lifecycle_id, " .
        "`product`.`status_id` AS status_id, " .
        "`product`.`units_id` AS quantisation_unit_id " .
      "FROM " .
        "`product` " .
//      "LEFT JOIN " .
//        "`manufacturer` " .
      "LEFT JOIN " .
        "`customer` " .
      "ON " .
        "`product`.`manufacturer_guid`=`customer`.`guid` " .
      "WHERE " .
        "`product`.`product_id`='" . $item_id . "' AND " .
        "`product`.`active`=1 " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'item_id' ] = '0';
      $return_data[ 'guid' ] = '00000000000000000000000000000000';
      $return_data[ 'product_mpn' ] = ''; //! @todo ANVILEX KM: Remove
      $return_data[ 'mpn' ] = '';
      $return_data[ 'manufacturer_guid' ] = '00000000000000000000000000000000';
      $return_data[ 'manufacturer_name' ] = '';
      $return_data[ 'product_lifecycle_id' ] = '';
      $return_data[ 'status_id' ] = '';
/*      $return_data[ 'quantisation_unit_id' ] = ''; */
      $return_data[ 'quantisation_unit_name' ] = '';

    }
    else
    {

      // Get product quantisation unit
      $quantisation_unit_name = $this->units->getUnitAbbreviation( $query->row[ 'quantisation_unit_id' ], $language_code );

      // Set product data
      $return_data[ 'valid' ] = true;
      $return_data[ 'item_id' ] = $query->row[ 'item_id' ];
      $return_data[ 'guid' ] = $query->row[ 'guid' ];
      $return_data[ 'product_mpn' ] = $query->row[ 'mpn' ]; //! @todo ANVILEX KM: Remove
      $return_data[ 'mpn' ] = $query->row[ 'mpn' ];
      $return_data[ 'manufacturer_guid' ] = $query->row[ 'manufacturer_guid' ];
      $return_data[ 'manufacturer_name' ] = $query->row[ 'manufacturer_name' ];
      $return_data[ 'product_lifecycle_id' ] = $query->row[ 'product_lifecycle_id' ];
      $return_data[ 'status_id' ] = '';
/*      $return_data[ 'quantisation_unit_id' ] = $query->row[ 'quantisation_unit_id' ]; */
      $return_data[ 'quantisation_unit_name' ] = $quantisation_unit_name;

    }

    // Return data
    return( $return_data );

  }


  //----------------------------------------------------------------------------
  // Get product description
  //----------------------------------------------------------------------------

  public function Get_Description( $item_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`product_description`.`description` AS description " .
      "FROM " .
        "`product_description` " .
      "WHERE " .
        "`product_description`.`item_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
        "`product_description`.`language_code`='" . $this->db->escape( $language_code ) . "'" ;

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test record count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'description' ] = '';

    }
    else
    {

      // Set product description
      $return_data[ 'valid' ] = true;
      $return_data[ 'description' ] = $query->row[ 'description' ];

    }

    // Return product description
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get product primary properties
  //----------------------------------------------------------------------------

  public function Get_Product_Primary_Properties( $product_id, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`online`.`item_properties`.`property_guid` AS `property_guid`, " .
        "`online`.`item_properties`.`value_guid` AS `property_value_guid`, " .
        "`online`.`item_properties`.`value` AS `property_value`, " .
        "`static`.`property_description`.`name` AS `property_name` " .
      "FROM " .
        "`online`.`item_properties` " .
      "LEFT JOIN " .
        "`online`.`product` " .
      "ON " .
        "`online`.`item_properties`.`product_guid`=`online`.`product`.`guid` " .
      "LEFT JOIN " .
        "`static`.`property_description` " .
      "ON " .
        "`static`.`property_description`.`property_guid`=`online`.`item_properties`.`property_guid` " .
      "WHERE " .
        "`online`.`product`.`product_id`='" . (int)$product_id . "' AND " .
        "`online`.`item_properties`.`primary`='1' AND " .
        "`static`.`property_description`.`language_code`='" . $this->db->escape( $language_code ) . "'";

    // Query database
    $results = $this->db->query( $sql );

    // Create properties array
    $properties = array();

    // Iterate over all properties
    foreach ( $results->rows as $property )
    {

      // Compose properties array
      $properties[] = array(
        'property_guid' => $property[ 'property_guid' ],
        'property_name' => $property[ 'property_name' ],
        'value_guid' => $property[ 'property_value_guid' ],
        'value' => $property[ 'property_value' ]
      );

    }

    // Return properties
    return( $properties );

  }

  //----------------------------------------------------------------------------
  // Get product properties
  //----------------------------------------------------------------------------

  public function Get_Properties_2( $item_guid = '', $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_properties`.`property_guid` AS `property_guid`, " .
        "`properties_description`.`name` AS `property_name`, " .
        "`item_properties`.`value` AS `property_value`, " .
        "`item_properties`.`unit_guid` AS `unit_guid`, " .
        "`units_description`.`symbol` AS `unit_symbol`, " .
        "`properties_group_description`.`group_guid` AS `properties_group_guid`, " .
        "`properties_group_description`.`name` AS `properties_group_name` " .
      "FROM " .
        "`item_properties` " .
      "LEFT JOIN " .
        "`properties` " .
      "ON " .
        "`properties`.`guid`=`item_properties`.`property_guid` " .
      "LEFT JOIN " .
        "`properties_description` " .
      "ON " .
        "`properties_description`.`property_guid`=`item_properties`.`property_guid` " .
      "LEFT JOIN " .
        "`properties_group_description` " .
      "ON " .
        "`properties_group_description`.`group_guid`=`properties`.`group_guid` " .
      "LEFT JOIN " .
        "`units_description` " .
      "ON " .
        "`units_description`.`guid`=`item_properties`.`unit_guid` " .
      "WHERE " .
        "`item_properties`.`product_guid`='" . $this->db->escape( $item_guid ) . "' AND " .
        "`item_properties`.`status`='active' AND " .
        "`properties_description`.`language_code`='" . $this->db->escape( $language_code ) . "' AND " .
        "`properties_group_description`.`language_code`='" . $this->db->escape( $language_code ) . "' AND " .
        "`units_description`.`language_code`='" . $this->db->escape( $language_code ) . "'";

    // Query database
    $results = $this->db->query( $sql );

    // Create properties array
    $return_data = array();

    $property_groups = array();

/*
    property_guid
   *property_name
   *property_value
    unit_guid
   *unit_symbol
    properties_group_guid
   *properties_group_name
*/
    // Iterate over all properties
    foreach ( $results->rows as $row )
    {

      // Compose property
      $property = array(
//        'property_guid' => $row[ 'property_guid' ],
        'name' => $row[ 'property_name' ],
        'value' => $row[ 'property_value' ],
        'unit' => $row[ 'unit_symbol' ],
      );

      // Compose troup
      $property_groups[ $row[ 'properties_group_guid' ] ][ 'guid' ] = $row[ 'properties_group_guid' ];
      $property_groups[ $row[ 'properties_group_guid' ] ][ 'name' ] = $row[ 'properties_group_name' ];
      $property_groups[ $row[ 'properties_group_guid' ] ][ 'properties' ][ $row[ 'property_guid' ] ] = $property;
/*
      if ( isset( $property_groups[ $row[ 'properties_group_guid' ] ] ) === false )
      {
        $property_groups[ $row[ 'properties_group_guid' ] ] =
      }
      else
      {
      }
*/   
/*   
      // Compose properties array
      $return_data[ $row[ 'property_group_name' ] ] = array(
        'property_guid' => $row[ 'property_guid' ],
        'property_name' => $row[ 'property_name' ],
        'property_value_guid' => $row[ 'property_value_guid' ],
        'property_value' => $row[ 'property_value' ],
        'property_group_name' => $row[ 'property_group_name' ]
      );
*/
    }

    $return_data[ 'return_code' ] = true;
    $return_data[ 'data' ] = $property_groups;

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get product properties
  //----------------------------------------------------------------------------

  public function Get_Properties_1( $item_guid, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_properties`.`property_guid` AS `property_guid`, " .
        "`item_properties`.`value_guid` AS `property_value_guid`, " .
        "`item_properties`.`value` AS `property_value`, " .
        "`property_description`.`name` AS `property_name`, " .
        "`property_groups`.`name` AS `property_group_name` " .
      "FROM " .
        "`item_properties` " .

      "LEFT JOIN " .
        "`product` " .
      "ON " .
        "`item_properties`.`product_guid`=`product`.`guid` " .

      "LEFT JOIN " .
        "`static`.`property_description` " .
      "ON " .
        "`static`.`property_description`.`property_guid`=`item_properties`.`property_guid` " .

      "LEFT JOIN " .
        "`static`.`property_to_group` " .
      "ON " .
        "`static`.`property_to_group`.`property_guid`=`item_properties`.`property_guid` " .

      "LEFT JOIN " .
        "`static`.`property_groups` " .
      "ON " .
        "`static`.`property_groups`.`guid`=`static`.`property_to_group`.`group_guid` " .

      "WHERE " .
        "`product`.`guid`='" . $this->db->escape( $item_guid ) . "' AND " .
//        "`online`.`item_properties`.`primary`='1' AND " .
        "`static`.`property_description`.`language_code`='" . $this->db->escape( $language_code ) . "'";

    // Query database
    $results = $this->db->query( $sql );

    // Create properties array
    $properties = array();

    // Iterate over all properties
    foreach ( $results->rows as $property )
    {

      // Compose properties array
      $properties[ $property[ 'property_group_name' ] ] = array(
        'property_guid' => $property[ 'property_guid' ],
        'property_name' => $property[ 'property_name' ],
        'property_value_guid' => $property[ 'property_value_guid' ],
        'property_value' => $property[ 'property_value' ],
        'property_group_name' => $property[ 'property_group_name' ]
      );

    }

    // Return properties
    return( $properties );

  }

  //----------------------------------------------------------------------------
  // Get item pictures
  //----------------------------------------------------------------------------

  public function Get_Pictures( $item_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_pictures`.`guid` AS guid, " .
        "`item_pictures`.`item_guid` AS item_guid, " .
        "`item_pictures`.`type` AS type, " .
        "`item_pictures`.`status` AS status" .
      "FROM ".
        "`item_pictures` " .
      "WHERE " .
        "`item_pictures`.`item_guid`='" . $this->db->escape( $item_guid ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Return list of pictures linked to item
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get item picture data
  //----------------------------------------------------------------------------

  public function Get_Picture_Data( $guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_picture_data`.`guid` AS guid, " .
        "`item_picture_data`.`item_guid` AS item_guid, " .
        "`item_picture_data`.`type` AS type, " .
        "`item_picture_data`.`status` AS status" .
      "FROM ".
        "`item_picture_data` " .
      "WHERE " .
        "`item_picture_data`.`guid`='" . $this->db->escape( $guid ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Return picture data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get item price
  //----------------------------------------------------------------------------

  public function Get_Product_Price( $item_id )
  {

    // Compose SQL query
    $sql = "SELECT ";
    $sql .= "price ";
    $sql .= "FROM product ";
    $sql .= "WHERE product_id=" . (int)$item_id;

    // Perform SQL query
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      // Set default data
      $price_data[ 'valid' ] = false;
      $price_data[ 'price' ] = 0;

    }
    else
    {

      // Set product description
      $price_data[ 'valid' ] = true;
      $price_data[ 'price' ] = $result->row[ 'price' ];

    }

    // Return product price
    return( $price_data );

  }

  //----------------------------------------------------------------------------
  // Log search results
  //----------------------------------------------------------------------------

  public function Log_Search_Results( $query, $total, $language_code, $customer_id=0, $customer_hash='' )
  {

    // Check for query is not empty
    if ( $query != '' )
    {

      // Compose SQL query
      $sql = "INSERT INTO product_search_queries SET ";
      $sql .= "query='" . $this->db->escape( $query ) . "', ";
      $sql .= "language_code='" . $this->db->escape( $language_code ) . "', ";
      $sql .= "date=NOW(), ";
      $sql .= "found='" . $total . "', ";
      $sql .= "customer_id='" . (int)$customer_id . "', ";
      $sql .= "customer_hash='" . $this->db->escape( $customer_hash ) . "'";

      // Query database
      $this->db->query( $sql );

    }

  }

  //----------------------------------------------------------------------------
  // Get product categores
  //----------------------------------------------------------------------------
/*
  public function getProductCategories( $data = array() )
  {

    // Compose SQL query
    $sql = "SELECT pc.id, pcd.name, pcd.description FROM product_categories pc INNER JOIN product_categories_description pcd ON pc.id=pcd.category_id WHERE pc.status='" . (int)$data['status'] . "' AND pcd.language_id='1' LIMIT " . (int)$data['limit'];

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return $query->rows;

  }
*/
  //----------------------------------------------------------------------------
/*
  public function getProduct_Category_Image( $id )
  {

    // Compose SQL query
    $sql = "SELECT image_type, image_data FROM product_categories WHERE id=" . (int)$id . ' LIMIT 1';

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return $query->row;

  }
*/
  //----------------------------------------------------------------------------

  public function updateViewed($product_id)
  {
    $this->db->query("INSERT INTO product_impressions SET product_id='" . (int)$product_id . "', date=NOW(), ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', url_source='', source= '1'");
  }

  //----------------------------------------------------------------------------

  public function updateProductViewed($product_id,$url,$ip,$source)
  {
    $this->db->query("INSERT INTO product_impressions SET product_id='" . (int)$product_id . "', date=NOW(), ip='" . $ip . "', url_source ='" . $url . "', source='" . $source . "'");
  }

  //----------------------------------------------------------------------------

// ANVILEX Begin : Realtime price and avaliability request
  public function getProductPriceAndAvailability($product_id)
  {

    $this->db->query("UPDATE product SET request_date = NOW() WHERE product_id='" . (int)$product_id . "'");

// ANVILEX : Disabled. Function will be depricated
//    $this->db->query("INSERT INTO product_realtime_request SET product_id='" . (int)$product_id . "', item_id='0', status='1', request_date=NOW() ON DUPLICATE KEY UPDATE request_date=NOW(), status='1'");

//    return "UPDATE product SET request_date = NOW() WHERE product_id='" . (int)$product_id . "'";
    return true;
  }
// ANVILEX End

  //----------------------------------------------------------------------------
/*
  public function getLatestProducts($limit)
  {


    $product_data = $this->cache->get('product.latest.' . '0' . '.' . (int)$limit);

    if (!$product_data) {
      $query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

      foreach ($query->rows as $result) {
        $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
      }

      $this->cache->set('product.latest.' . '0' . '.' . (int)$limit, $product_data);
    }

    return $product_data;

    return NULL;

  }
*/
  //----------------------------------------------------------------------------
/*
  public function getPopularProducts($limit)
  {
    $product_data = array();

    $query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY p.viewed, p.date_added DESC LIMIT " . (int)$limit);

    foreach ($query->rows as $result) {
      $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
    }

    return $product_data;
  }
*/
  //----------------------------------------------------------------------------
/*
  public function getRandomProducts($limit)
  {
    $product_data = array();

    $query = $this->db->query("SELECT p.product_id FROM product p WHERE p.status = '1' ORDER BY RAND() LIMIT " .(int)$limit );

    foreach ($query->rows as $result)
    {
      $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
    }

    return $product_data;
  }
*/
  //----------------------------------------------------------------------------
/*
  public function getBestSellerProducts($limit)
  {

    $product_data = $this->cache->get('product.bestseller.' . '0' . '.' . (int)$limit);

    if (!$product_data) {
      $product_data = array();

      $query = $this->db->query("SELECT op.product_id, COUNT(*) AS total FROM order_product op LEFT JOIN `order` o ON (op.order_id = o.order_id) LEFT JOIN `product` p ON (op.product_id = p.product_id) WHERE o.order_status_id > '0' AND p.status = '1' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

      foreach ($query->rows as $result)
      {
        $product_data[$result['product_id']] = $this->getProduct($result['product_id']);
      }

      $this->cache->set('product.bestseller.' . '0' . '.' . (int)$limit, $product_data);
    }

    return $product_data;
  }
*/
  //----------------------------------------------------------------------------

  public function getProductDiscounts( $product_id )
  {
    return 0;
  }

  //----------------------------------------------------------------------------

  public function getProductRelated($product_id)
  {
    $product_data = array();

    $query = $this->db->query("SELECT * FROM product_related pr LEFT JOIN product p ON (pr.related_id = p.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1'");

    foreach ($query->rows as $result)
    {
      $product_data[$result['related_id']] = $this->getProduct($result['related_id']);
    }

    return $product_data;
  }

  //----------------------------------------------------------------------------

  public function getProductAccessoires($product_id)
  {
    $product_data = array();

    $query = $this->db->query("SELECT * FROM product_accessoires pr LEFT JOIN product p ON (pr.accessoires_id = p.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1'");

    foreach ($query->rows as $result)
    {
      $product_data[$result['accessoires_id']] = $this->getProduct($result['accessoires_id']);
    }

    return $product_data;
  }

  //----------------------------------------------------------------------------

  public function getProductDocuments($product_id)
  {

    $product_doc = array();

    $query = $this->db->query("SELECT * FROM documents WHERE product_id = '" . $product_id . "' AND language_id = '0'");

    foreach ($query->rows as $result)
    {
      $product_doc[] = $result;
    }

    return $product_doc;

  }

  //----------------------------------------------------------------------------
  // * Returns a list of products available in stock.
  // @return array Products with details like ID, name, price, etc.
  //----------------------------------------------------------------------------

  //-----------------------------------------------------------------------------
  // Retrieves products based on specific warehouse filters such as customer GUID and country code.
  //-----------------------------------------------------------------------------
  // ANVILEX KM: Rework this method.
  
  public function Get_Items_By_Warehouse( $customer_guid, $country_iso_code_2, $limit = 1000, $offset = 0 )
  {

    $sql = 
      "SELECT " .
        "`product`.`guid` as guid, " .
        "`product`.`mpn` as mpn, " .
        "`product`.`manufacturer_guid` as manufacturer_guid " .
//        "`product`.`manufacturer`, " .
//        "pd.name, " .
//        "pd.description, " .
//        "`warehouses`.`warehouse_guid` " .
      "FROM " .
        "`product` " .
//      "INNER JOIN " .
//        "`warehouse_stock` " .
//      "ON " . 
//        "`product`.`guid`=`warehouse_stock`.`guid` " .
//      "INNER JOIN " .
//        "`warehouses` " .
//      "ON " .
//        "`warehouses`.`warehouse_guid`=`warehouse_stock`.`guid` " .
//      "WHERE " .
//        "(`warehouse_stock`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "') AND " .
//        "(`warehouse_stock`.`country_iso_code_2`='" . $this->db->escape( $country_iso_code_2 ) . "')";
//        "ORDER BY guid ASC " .
        "LIMIT " . $this->db->escape( $limit ) . " " .
        "OFFSET " . $this->db->escape( $offset );

    $query = $this->db->query( $sql );

    return ( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Retrieves price and currency details for a given list of product GUIDs.
  //----------------------------------------------------------------------------

  public function getPricesForProducts( $product_guids )
  {

    $placeholders = implode(',', array_fill( 0, count($product_guids), '?' ) );

    $sql = "SELECT p.guid, ip.price, ip.currency_code
            FROM item_prices ip
            INNER JOIN product p ON ip.item_guid = p.guid
            WHERE p.guid IN ($placeholders)";

    $query = $this->db->query( $sql, $product_guids );

    return $query->rows;

  }

  //----------------------------------------------------------------------------
  // Fetches the product description for a specified product GUID and language code.
  //----------------------------------------------------------------------------

  public function getDescription( $product_guid, $language_code = 'EN' )
  {

    $sql = "SELECT pd.description
            FROM product_description pd
            WHERE pd.product_guid = ? AND pd.language_code = ?";

    $query = $this->db->query($sql, [$product_guid, $language_code]);
    return $query->row;

  }

  //----------------------------------------------------------------------------
  //Retrieves a complete list of all products without applying any filters.
  //----------------------------------------------------------------------------

  public function getAllProducts()
  {

    $sql = "SELECT p.guid, p.name, p.manufacturer
            FROM product p";

    $query = $this->db->query($sql);
    return $query->rows;

  }

  //----------------------------------------------------------------------------

  public function GetProductStatus( $item_id )
  {

    // Compose SQL query
    $sql = "SELECT ";
    $sql .= "product_id, ";
    $sql .= "status ";
    $sql .= "FROM product ";
    $sql .= "WHERE product_id=" . (int)$item_id;

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test row count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $product[ 'valid' ] = false;
      $product[ 'active' ] = false;

    }
    else
    {

      // Set product data
      $product[ 'valid' ] = true;
      $product[ 'active' ] = ( $query->row[ 'status' ] == 1 ) ? true : false ;

    }

    // Return data
    return( $product );

  }

  //----------------------------------------------------------------------------
  // Get item properties groups
  //----------------------------------------------------------------------------
/*
  public Get_Properties_Groups( $item_guid = '', $language_code = 'XX' )
  {
    
    // Compose SQL query
    $sql =
      "SELECT " .
        "`item_properties`.`product_id` AS `item_id`, " .
        "`product`.`guid` AS `guid`, " .
        "`product`.`atomic` AS `atomic_item`, " .
        "`product`.`mpn` AS `mpn`, " .
        "`product`.`order_code` AS `order_code`, " .
        "`product`.`units_id` AS `quantisation_unit_id`, " . //! @todo ANVILEX KM: Remove
//        "`product_description`.`description` AS `description`, " .
        "`product`.`price` AS `price`, " . //! @todo ANVILEX KM: Remove
        "`customer`.`guid` AS `manufacturer_guid`, " .
        "`customer`.`company_name` AS `manufacturer_name`, " .
        "`product`.`lifecycle_status_id` AS `product_lifecycle_id` " .
      "FROM " .
        "`item_properties` " .
//      "LEFT JOIN " .
//        "`product_description` " .
//      "ON " .
//        "`product_description`.`item_guid`=`product`.`guid` " .
      "LEFT JOIN " .
        "`customer` " .
      "ON " .
        "`customer`.`guid`=`product`.`manufacturer_guid` " .
      "WHERE " .
        "`product`.`guid`='" . $this->db->escape( $item_guid ) . "' AND " .
//        "`product_description`.`language_code`='" . $this->db->escape( $language_code ) . "' AND " .
        "`product`.`active`=1 ";

    // Perform SQL query
    $result = $this->db->query( $sql );

    return( $result->rows )

  }
*/
}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>