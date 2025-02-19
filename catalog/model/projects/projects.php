<?php

class ModelProjectsProjects extends Model
{

  // Database fields size definitions
  private const project_name_field_size = 254;
  private const project_designator_field_size = 7;
  private const project_description_field_size = 254;

  //----------------------------------------------------------------------------
  // Return maximum string size of project name database field
  //----------------------------------------------------------------------------

  public function Get_Project_Name_Maximum_String_Size()
  {

    // Return maximum string size of project name database field
    return( self::project_name_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of project designator database field
  //----------------------------------------------------------------------------

  public function Get_Project_Designator_String_Size()
  {

    // Return maximum string size of project designator database field
    return( self::project_designator_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of project description database field
  //----------------------------------------------------------------------------

  public function Get_Project_Description_Maximum_String_Size()
  {

    // Return maximum string size of project description database field
    return( self::project_description_field_size );

  }

  //----------------------------------------------------------------------------
  // Get documents assigned to project
  //----------------------------------------------------------------------------

  public function Get_Documents( $project_guid = '' )
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
        "`document_to_project` " .
      "ON " .
        "`documents`.`guid`=`document_to_project`.`document_guid` " .
      "WHERE " .
        "`document_to_project`.`project_guid`='" . $project_guid . "' ";

    // Execute quiery
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get project items
  //----------------------------------------------------------------------------

  public function Get_Project_Items( $project_guid = '' )
  {

   // Compose SQL query
   $sql =
     "SELECT " .
       "* " .
     "FROM " .
       "`project_items` " .
     "WHERE " .
       "`project_items`.`project_guid`='" . $this->db->escape( $project_guid ) . "'";

   // Query database
   $result = $this->db->query( $sql );

   // Return data
   return( $result->rows );

 }

  //----------------------------------------------------------------------------
  // Get project projects
  //----------------------------------------------------------------------------

  public function Get_Project_Projects( $project_guid = '' )
  {

   // Compose SQL query
   $sql =
     "SELECT " .
       "* " .
     "FROM " .
       "`project_projects` " .
     "WHERE " .
       "`project_projects`.`parent_guid`='" . $this->db->escape( $project_guid ) . "'";

   // Query database
   $result = $this->db->query( $sql );

   // Return data
   return( $result->rows );

 }


  //----------------------------------------------------------------------------
  // Remove project to customer favorites list
  //----------------------------------------------------------------------------

  public function Remove_Project( $parent_guid = '00000000000000000000000000000000', $project_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`project_projects` " .
      "WHERE " .
        "`project_projects`.`parent_guid`='" . $this->db->escape( $parent_guid ) . "' AND " .
        "`project_projects`.`project_guid`='". $this->db->escape( $project_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }


  //----------------------------------------------------------------------------
  // Get list of favorite projects observed by customer
  //----------------------------------------------------------------------------

  public function Get_Favorite_Projects( $customer_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`customer_projects`.`project_guid` AS guid " .
      "FROM " .
        "`customer_projects` " .
      "WHERE ".
        "`customer_projects`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

//----------------------------------------------------------------------------
  // Check for project in customers favorite liste
  //----------------------------------------------------------------------------

  public function Is_In_Favorites( $customer_guid = '', $project_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`customer_projects`.`project_guid` " .
      "FROM " .
        "`customer_projects` " .
      "WHERE " .
        "`customer_projects`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`customer_projects`.`project_guid`='" . $this->db->escape( $project_guid ) . "' " .
      "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Observed project not found
      //------------------------------------------------------------------------

      // Set project not found status
      $project_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Observed project found
      //------------------------------------------------------------------------

      // Set project found status
      $project_found = true;

    }

    // Return status
    return( $project_found );

  }

  //----------------------------------------------------------------------------
  // Create new project
  //----------------------------------------------------------------------------

  public function Add_Project($guid, $data = array() )
  {

    // Decompose project designator
    $project_number = $this->Decompose_Project_Number( $data[ 'designator' ] );

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`projects` " .
      "SET " .
        "`projects`.`guid`='" . $this->db->escape( $guid ) . "', " .
        "`projects`.`name`='" . $this->db->escape( $data[ 'name' ] ) . "', " .
        "`projects`.`description`='" . $this->db->escape( $data[ 'description' ] ) . "', " .
        "`projects`.`number`=" .  $project_number[ 'number' ] . ", " .   
        "`projects`.`year`=" . $project_number[ 'year' ] . ", " . 
        "`projects`.`designator`='" . $this->db->escape( $data[ 'designator' ] ) . "', " .   
        "`projects`.`create_date`=NOW() ";

    // Query database
    $this->db->query( $sql );

    //! @todo ANVILEX KM: Check result

    // Set return data
    $return_data[ 'return_code' ] = true;
    $return_data[ 'guid' ] = $guid;

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Add project to customer favorites list
  //----------------------------------------------------------------------------

  public function Add_To_Favorites( $customer_guid = '00000000000000000000000000000000', $project_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT IGNORE INTO " .
        "`customer_projects` " .
      "SET " .
        "`customer_projects`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "', " .
        "`customer_projects`.`project_guid`='" . $this->db->escape( $project_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Revove project to customer favorites list
  //----------------------------------------------------------------------------

  public function Remove_From_Favorites( $customer_guid = '00000000000000000000000000000000', $project_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "DELETE FROM " .
        "`customer_projects` " .
      "WHERE " .
        "`customer_projects`.`customer_guid`='" . $this->db->escape( $customer_guid ) . "' AND " .
        "`customer_projects`.`project_guid`='". $this->db->escape( $project_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }


  //----------------------------------------------------------------------------
  // Get project information
  //----------------------------------------------------------------------------

  public function Get_Information( $guid = '00000000000000000000000000000000' )
  {

    //! @todo ANVILEX KM: Test for language code valid

    // Compose SQL query
    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`projects` " .
      "WHERE " .
        "`projects`.`guid`='" . $this->db->escape( $guid ) . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for item exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // ERROR: Project not found
      //------------------------------------------------------------------------

      // Set default data
      $data[ 'return_code' ] = false;
      $data[ 'data' ] = array();

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set product data
      $data[ 'return_code' ] = true;
      $data[ 'data' ][ 'guid' ] =  $query->row[ 'guid' ];
      $data[ 'data' ][ 'designator' ] =  $query->row[ 'designator' ];
      $data[ 'data' ][ 'year' ] =  $query->row[ 'year' ];
      $data[ 'data' ][ 'number' ] = $query->row[ 'number' ];
      $data[ 'data' ][ 'status' ] = $query->row[ 'status' ];
      $data[ 'data' ][ 'create_date' ] = $query->row[ 'create_date' ];
      $data[ 'data' ][ 'name' ] = $query->row[ 'name' ];
      $data[ 'data' ][ 'description' ] = $query->row[ 'description' ];

    }

    // Return item data
    return( $data );

  }

  //----------------------------------------------------------------------------

  public function Search_Projects_Count(
    $search = '', 
    $designator = false, 
    $name = true, 
    $description = false 
  )
  {

    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();

    if ( $designator === true )
    {
      $where_or[] = " `projects`.`designator` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $name === true )
    {
      $where_or[] = " `projects`.`name` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $description === true )
    {
      $where_or[] = " `projects`.`description` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode(' OR ', $where_or );
  
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "COUNT(*) " .
      "FROM " .
        "`projects` " .
      "WHERE " .
        $where;

    // Query database
    $results = $this->db->query( $sql );

    // Return data
    return( $results->row[ 0 ] );

  }

  //----------------------------------------------------------------------------
  // Get list of projects
  //----------------------------------------------------------------------------

  public function Get_List_Of_Projects( 
    $page_length = 30, 
    $page_number = 1, 
    $search = '', 
    $designator = false, 
    $name = true, 
    $description = false
  )
  {

    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();

    if ( $designator === true )
    {
      $where_or[] = " `projects`.`designator` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $name === true )
    {
      $where_or[] = " `projects`.`name` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $description === true )
    {
      $where_or[] = " `projects`.`description` LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode( ' OR ', $where_or );
    
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT * " .
      "FROM " .
        "`projects` " .
      "WHERE " .
        $where . " " .
      "LIMIT " . $this->db->escape( $page_length ) . " " .
      "OFFSET " . $this->db->escape( $page_length * ( $page_number - 1 ) ) . ";";

    // Execute sql query
    $results = $this->db->query( $sql );

    // Return data
    return( $results->rows );

  }

  //----------------------------------------------------------------------------
  //! @brief Get next project number in format P0YY.NN
  //! @note Returns next project number based on the last project in the database
  //----------------------------------------------------------------------------

  public function Get_Next_Project_Number()
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`projects`.`year`, " .
        "`projects`.`number` " . 
      "FROM " .
        "`projects` " .
      "ORDER BY ". 
        "`projects`.`year` DESC, " .
        "`projects`.`number` DESC " .
      "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    $this->log->Log_Debug( 'num_rows ' .  $result->num_rows);
    $this->log->Log_Debug( 'year ' .  $result->row[ 'year' ]);
    $this->log->Log_Debug( 'number ' .  $result->row[ 'number' ]);

    // Test record count
    switch( $result->num_rows )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      case 0:
      {

        //----------------------------------------------------------------------
        // Project not found
        //----------------------------------------------------------------------

        // Set first project in actual year
        $new_project_number = $this->Compose_Project_Number( date( 'y' ), 1 );

        // Leave row count decoder
        break;

      }

      //------------------------------------------------------------------------
      // Only one project found
      //------------------------------------------------------------------------

      case 1:
      {

        //----------------------------------------------------------------------
        // Project found
        //----------------------------------------------------------------------

				// Get actual year
				$actual_year = date( 'y' );

				// Test for on projects exists in actual year
				if ( $actual_year != $result->row[ 'year' ] )
				{

					//--------------------------------------------------------------------
					// No projects exists
					//--------------------------------------------------------------------

					// Set first project in actual year
					$new_project_number = $this->Compose_Project_Number( $actual_year, 1 );

				}
				else
				{

					//--------------------------------------------------------------------
					// Some projects already exists
					//--------------------------------------------------------------------

        	// Set new next project number
					$new_project_number = $this->Compose_Project_Number( $result->row[ 'year' ], $result->row[ 'number' ] + 1 );

				}

        // Leave row count decoder
        break;

      }

      //------------------------------------------------------------------------
      // Several projects found
      //------------------------------------------------------------------------

      default:
      {

        //----------------------------------------------------------------------
        // ERROR: Several projects found
        //----------------------------------------------------------------------

        // Set new default project number
        $new_project_number = '';

        // Leave row count decoder
        break;

      }

    }

    // Return new project number
    return( $new_project_number );

  }

  //----------------------------------------------------------------------------
  // Test for project exists
  //----------------------------------------------------------------------------

  public function Is_Exists( $project_designator = "" )
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`projects`.`guid` " . 
      "FROM " .
        "`projects` " .
      "WHERE `projects`.`designator`='" . $this->db->escape( $project_designator ) . "'";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
		{

			//------------------------------------------------------------------------
			// Project not found
			//------------------------------------------------------------------------

			// Set project not found status
			$project_found = false;

		}
		else
		{

			//------------------------------------------------------------------------
			// Project found
			//------------------------------------------------------------------------

			// Set project found status
			$project_found = true;

		}

    // Return status
    return( $project_found );

  }

  //----------------------------------------------------------------------------
  // Check for item exists
  //----------------------------------------------------------------------------

  public function Is_Exist_Project_Item( $project_guid = '', $item_guid = '' )
  {

    // Compose SQL query
    $sql =
    "SELECT " .
      "* " .
    "FROM " .
      "project_items " .
    "WHERE " .
      "item_guid='" . $this->db->escape( $item_guid ) . "' AND " .
      "project_guid='" . $this->db->escape( $project_guid ) . "' ";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      // Set project not found status
      $item_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set project found status
      $item_found = true;

    }

    // Return data
    return( $item_found );

  }
  
  //----------------------------------------------------------------------------
  // Check for project exists
  //----------------------------------------------------------------------------

  public function Is_Exist_Project_Project( $parent_guid = '', $project_guid = '' )
  {

    // Compose SQL query
    $sql =
    "SELECT " .
      "* " .
    "FROM " .
      "project_projects " .
    "WHERE " .
      "parent_guid='" . $this->db->escape( $parent_guid ) . "' AND " .
      "project_guid='" . $this->db->escape( $project_guid ) . "' ";

    // Query database
    $result = $this->db->query( $sql );

    // Test record count
    if ( $result->num_rows == 0 )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      // Set project not found status
      $project_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set project found status
      $project_found = true;

    }

    // Return data
    return( $project_found );

  }

  //----------------------------------------------------------------------------
  // Remove item from project
  //----------------------------------------------------------------------------

  public function Remove_Item_From_Project( $project_guid = '', $item_guid = '' )
  {

    // Compose SQL query
    $sql =
    "DELETE FROM " .
      "`project_items` " .
    "WHERE " .
      "`project_items`.`project_guid`='" . $this->db->escape( $project_guid ) . "' AND " .
      "`project_items`.`item_guid`='". $this->db->escape( $item_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

 //----------------------------------------------------------------------------
  // Get project referenced by GUID existence status information
  //----------------------------------------------------------------------------

  public function Is_Exists_By_GUID( $project_guid = '' )
  {

    // Compose SQL query
    $sql =
      "SELECT " .
        "`projects`.`guid` AS guid " .
      "FROM " .
        "`projects` " .
      "WHERE " .
        "`projects`.`guid`='" . $project_guid . "' " .
      "LIMIT 1";

    // Perform SQL query
    $query = $this->db->query( $sql );

    // Test for project exists
    if ( $query->num_rows != 1 )
    {

      //------------------------------------------------------------------------
      // Project not found
      //------------------------------------------------------------------------

      // Set not found status
      $project_found = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Project found
      //------------------------------------------------------------------------

      // Set project found status
      $project_found = true;

    }

    // Return status
    return( $project_found );

  }

  //----------------------------------------------------------------------------
  // Edit project
  //----------------------------------------------------------------------------

  public function Edit( $project_data )
  {

    // Decompose project designator
    $project_number = $this->Decompose_Project_Number( $project_data[ 'designator' ] );

    // Compose SQL query
    $sql =
      "UPDATE " .
        "`projects` " .
      "SET " .
        "`projects`.`name`='" . $this->db->escape( $project_data[ 'name' ] ) . "', " .
        "`projects`.`designator`='" . $this->db->escape( $project_data[ 'designator' ] ) . "', " .
        "`projects`.`description`='" . $this->db->escape( $project_data[ 'description' ] ) . "', " .
        "`projects`.`number`=" .  $this->db->escape( $project_number[ 'number' ] ) . ", " .   
        "`projects`.`year`=" . $this->db->escape( $project_number[ 'year' ] ) . " " . 
      "WHERE " .
        "`projects`.`guid`='" . $this->db->escape( $project_data[ 'guid' ] ) . "' " ;

//$this->log->Log_Debug( 'sql ' . $sql );

   // Query database
   $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Is Project Designator already Exists
  //----------------------------------------------------------------------------

  public function Is_Edit_Project_Exists( $guid='', $number ='' ) : bool
  {

    // Test for designator or guid empty
    if ( $guid == '' || $number == ''  )
    {

      //------------------------------------------------------------------------
      // ERROR:  Designator or guid  is empty
      //------------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      //  Designator and guid not empty
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql =
        "SELECT " .
          "`projects`.`guid` " .
        "FROM " .
          "`projects` " .
        "WHERE " .
          "`projects`.`designator`='" . $this->db->escape( $number ) . "' AND " .
          "`projects`.`guid`!='" . $this->db->escape( $guid ) . "'" .
        "LIMIT 1";

      // Query database
      $result = $this->db->query( $sql );

      // Test record count
      if ( $result->num_rows == 0 )
      {

        //----------------------------------------------------------------------
        // Project designator not found
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Project designator found
        //----------------------------------------------------------------------

        // Set success code
        $return_code = true;

      }

    }

    // Return status
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Add item to project
  //----------------------------------------------------------------------------

  public function Add_Item( $project_guid = '00000000000000000000000000000000', $item_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`project_items` " .
      "SET " .
        "`project_items`.`project_guid`='" . $this->db->escape( $project_guid ) . "', " .
        "`project_items`.`item_guid`='" . $this->db->escape( $item_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Add project to project
  //----------------------------------------------------------------------------

  public function Add_Project_To_Project( $parent_guid = '00000000000000000000000000000000', $project_guid = '00000000000000000000000000000000' )
  {

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "`project_projects` " .
      "SET " .
        "`project_projects`.`project_guid`='" . $this->db->escape( $project_guid ) . "', " .
        "`project_projects`.`parent_guid`='" . $this->db->escape( $parent_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Return success code
    return( true );

  }

  //----------------------------------------------------------------------------
  // Test for project number valid
  //----------------------------------------------------------------------------

  public function Is_Project_Number_Valid($designator )
  {

    $data = $this->Decompose_Project_Number($designator);

    $return_data = true;

    if( is_numeric( $data[ 'year' ] ) == false )
    {
      $return_data = false;
    }
    else
    {
         // Year is a number
    }

    if( is_numeric( $data[ 'number' ] ) == false )
    {
      $return_data = false;
    }
    else
    {
      // Number is number
    }

    // Get actual year
    $actual_year = date( 'y' );

    if( $data[ 'year' ] > $actual_year )
    {
      $return_data = false;
    }else
    {

    }

    // Return success code
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get teaser projects
  //----------------------------------------------------------------------------

  public function Get_Teaser_Projects()
  {

    // Init return data
    $return_data[ 'data' ] = array();

    // Compose SQL query
    $sql = "SELECT `projects`.`guid`, `projects`.`name` FROM `projects` ORDER BY `projects`.`create_date` DESC LIMIT 5";

    // Query database
    $result = $this->db->query( $sql );

    // Set output data
    $return_data[ 'data' ] = $result->rows;

    // Set success code
    $return_data[ 'return_code' ] = true;
    $return_data[ 'return_code_text' ] = 'Success';

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get projects
  //----------------------------------------------------------------------------

  public function Get_By_Filter( $filter )
  {

//    $return_data = array();
    $return_data[ 'data' ] = array();

    // Test for filter is empty
    if ( isset( $filter ) == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid filter
      //------------------------------------------------------------------------

      // Set error code
      $return_data[ 'return_code' ] = false;
      $return_data[ 'error_code' ] = 'Invalid filter';

    }
    else
    {

      //------------------------------------------------------------------------
      // Filter setted
      //------------------------------------------------------------------------

      // Filter components
      $filter_chunk = array();

      // Join components
      $join_chunk = array();

      //------------------------------------------------------------------------
      // Project identifier
      //------------------------------------------------------------------------

      // Compose filter
      if ( isset( $filter[ 'id' ] ) == true )
      {

        // Test for project type is numeric
        if ( is_numeric( $filter[ 'id' ] ) == true )
        {

          // Compose project identifier chunk
          $filter_chunk[] = "`projects`.`id`='" . (int)$filter[ 'id' ] . "'";

        }

      }

      //------------------------------------------------------------------------
      // Project type
      //------------------------------------------------------------------------

      // Test for project type setted
      if ( isset( $filter[ 'type' ] ) == true )
      {

        // Test for project type is numeric
        if ( is_numeric( $filter[ 'type' ] ) == true )
        {

          // Compose project type chunk
          $filter_chunk[] = "`projects`.`type`='" . (int)$filter[ 'type' ] . "'";

        }

      }

      //------------------------------------------------------------------------
      // Project status
      //------------------------------------------------------------------------

      // Test for project status setted
      if ( isset( $filter[ 'status' ] ) === true )
      {

        // Test for project status is numeric
        if ( is_numeric( $filter[ 'status' ] ) == true )
        {

          // Compose project status chunk
          $filter_chunk[] = "`projects`.`status`='" . (int)$filter[ 'status' ] . "'";

        }

      }

      //------------------------------------------------------------------------
      // Project description test
      //------------------------------------------------------------------------

      // Test for text setted
      if ( isset( $filter[ 'text' ] ) === true )
      {

        // Test for string is not empty
        if ( trim( $filter[ 'text' ] ) != '' )
        {

          $filter_chunk_1 = array();

          // Compose project name chunk
          $filter_chunk_1[] = "`projects`.`name` LIKE '%" . $filter[ 'text' ] . "%'";

          // Compose project description chunk
          $filter_chunk_1[] = "`projects`.`description` LIKE '%" . $filter[ 'text' ] . "%'";

          // Compose full text search
          $filter_chunk[] = '(' . implode( ' OR ', $filter_chunk_1 ) . ')';

        }

      }

      //------------------------------------------------------------------------
      // JOIN clause
      //------------------------------------------------------------------------

      // Set default join clause
      $join_clause = "";

      // Test for filter chuncs present
      if ( sizeof( $join_chunk ) != 0 )
      {

        // Compose join clause
        $join_clause = " " . implode( " ", $join_chunk );

      }

      //------------------------------------------------------------------------
      // WHERE clause
      //------------------------------------------------------------------------

      // Set default filter clause
      $filter_clause = "";

      // Test for filter chuncs present
      if ( sizeof( $filter_chunk ) != 0 )
      {

        // Compose filter clause
        $filter_clause = " WHERE " . implode( " AND ", $filter_chunk );

      }

      //------------------------------------------------------------------------
      // LIMIT clause
      //------------------------------------------------------------------------

      // Set default limit clause
      $limit_clause = "";

      // Test for limit setted
      if ( isset( $filter[ 'limit' ] ) == true )
      {

        // Compose limit clause
        $limit_clause = " LIMIT " . (int)$filter[ 'limit' ];

      }

      //------------------------------------------------------------------------
      // OFFSET clause
      //------------------------------------------------------------------------

      // Set default offset clause
      $offset_clause = "";

      // Test for
      if ( $limit_clause != "" )
      {

        // Test for offset setted
        if ( isset( $filter[ 'offset' ] ) == true )
        {

          // Compose offset clause
          $offset_clause = " OFFSET " . (int)$filter[ 'offset' ];

        }

      }

      //------------------------------------------------------------------------
      // Compose SQL query
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT `projects`.`id` FROM `projects`";

      // Append join clause
      $sql = $sql . $join_clause;

      // Append filter clause
      $sql = $sql . $filter_clause;

      // Append limit clause
      $sql = $sql . $limit_clause;

      // Append offset clause
      $sql = $sql . $offset_clause;

//      trigger_error( 'SQL: ' . $sql );

      // Query database
      $result = $this->db->query( $sql );

      // Set output data
      $return_data[ 'data' ] = $result->rows;

      // Set success code
      $return_data[ 'return_code' ] = true;

    }

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Add project time tracking
  //----------------------------------------------------------------------------

  public function Add_Time_Tracking( $data = array() )
  {

    // Test for data seted
    if ( !isset( $data ) )
    {

      //----------------------------------------------------------------------
      // ERROR: Bad data
      //----------------------------------------------------------------------

      // Set error code
      $return_code = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Data valid
      //------------------------------------------------------------------------

      $data_valid = ( ( isset( $data[ 'customer_id' ] ) === true ) && ( ctype_digit( strval( $data[ 'customer_id' ] ) ) === true ) );
      $data_valid &= ( ( isset( $data[ 'project_id' ] ) === true ) && ( ctype_digit( strval( $data[ 'project_id' ] ) ) === true ) );
      $data_valid &= ( isset( $data[ 'date' ] ) === true );
      $data_valid &= ( ( isset( $data[ 'duration' ] ) === true ) && ( ctype_digit( strval( $data[ 'duration' ] ) ) === true ) );
      $data_valid &= ( isset( $data[ 'description' ] ) === true );

      // Test for data valid
      if ( $data_valid == false )
      {

        //----------------------------------------------------------------------
        // ERROR: Invalid input data
        //----------------------------------------------------------------------

        // Set error code
        $return_code = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Data valid
        //----------------------------------------------------------------------

        // Compose SQL query
        $sql = "INSERT INTO `projects_time_tracking` SET ";
        $sql .= "`projects_time_tracking`.`customer_id`='" . (int)$data[ 'customer_id' ] . "', ";
        $sql .= "`projects_time_tracking`.`project_id`='" . (int)$data[ 'project_id' ] . "', ";
        $sql .= "`projects_time_tracking`.`activity_id`='" . (int)$data[ 'activity_id' ] . "', ";
        $sql .= "`projects_time_tracking`.`date`='" . $data[ 'date' ] . "', ";
        $sql .= "`projects_time_tracking`.`duration`='" . (int)$data[ 'duration' ] . "', ";
        $sql .= "`projects_time_tracking`.`description`='" . $this->db->escape( $data[ 'description' ] ) . "'";

        // Query database
        $this->db->query( $sql );

        // Set success code
        $return_code = true;

      }

    }

    // Return success/error code
    return( $return_code );

  }

  //----------------------------------------------------------------------------
  // Get project time tracking list
  //----------------------------------------------------------------------------

//  public function Get_Project_Time_Tracking( $project_id, $customer_id )
  public function Get_Project_Time_Tracking( $customer_id )
  {

    // Test input parameters
//    if ( ( is_numeric( $project_id ) == false ) || ( is_numeric( $customer_id ) == false ) )
    if ( is_numeric( $customer_id ) == false )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid identifiers
      //------------------------------------------------------------------------

      // Set error code
      $return_data[ 'return_code' ] = false;
      $return_data[ 'error_code' ] = 'Invalid parameters';

    }
    else
    {

      //------------------------------------------------------------------------
      // Identifiers valid
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT `id` FROM `projects_time_tracking` WHERE `customer_id`='" . (int)$customer_id . "'";

      // Query database
      $result = $this->db->query( $sql );

      // Set output data
      $return_data[ 'data' ] = $result->rows;

      // Set success code
      $return_data[ 'return_code' ] = true;

    }

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Get project time tracking information
  //----------------------------------------------------------------------------

  public function Get_Project_Time_Tracking_Information( $filter )
  {

    // Prepare return data
    $return_data = array();
    $return_data[ 'data' ] = array();

    // Test URL value
    if ( is_numeric( $filter[ 'id' ] ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Invalid identifier
      //------------------------------------------------------------------------

      // Set error code
      $return_data[ 'return_code' ] = false;
      $return_data[ 'error_code' ] = 'Bad identifier: ' . $filter[ 'id' ];

    }
    else
    {

      //------------------------------------------------------------------------
      // Identifier valid
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT ";
      $sql .= "`projects_time_tracking`.`id`, ";
      $sql .= "`projects_time_tracking`.`customer_id` AS `customer_id`, ";
      $sql .= "`projects_time_tracking`.`project_id` AS `project_id`, ";
      $sql .= "`projects_time_tracking`.`activity_id` AS `activity_id`, ";
      $sql .= "`projects_time_tracking`.`date` AS `activity_date`, ";
      $sql .= "`projects_time_tracking`.`duration` AS `activity_duration`, ";
      $sql .= "`projects_time_tracking`.`description` AS `activity_description`, ";
      $sql .= "`projects`.`year` AS `project_year`, ";
      $sql .= "`projects`.`number` AS `project_number`, ";
      $sql .= "`projects`.`name` AS `project_name`, ";
      $sql .= "`project_activities`.`name` AS `activity_name` ";
      $sql .= "FROM `projects_time_tracking` ";
      $sql .= "LEFT JOIN `projects` ON `projects_time_tracking`.`project_id`=`projects`.`id` ";
      $sql .= "LEFT JOIN `project_activities` ON `projects_time_tracking`.`activity_id`=`project_activities`.`id` ";
      $sql .= "WHERE `projects_time_tracking`.`id`='" . (int)$filter[ 'id' ] . "' AND `project_activities`.`language_code`='" . $filter[ 'language_code' ] . "' ";
      $sql .= "ORDER BY `projects_time_tracking`.`date` DESC";

      // Query database
      $result = $this->db->query( $sql );

      // Test record count
      switch( $result->num_rows )
      {

        //----------------------------------------------------------------------
        // No project found
        //----------------------------------------------------------------------

        case 0:
        {

          //--------------------------------------------------------------------
          // No project found
          //--------------------------------------------------------------------

          // Set success code
          $return_data[ 'return_code' ] = true;

          // Leave row count decoder
          break;

        }

        //----------------------------------------------------------------------
        // Project found
        //----------------------------------------------------------------------

        case 1:
        {

          //--------------------------------------------------------------------
          // Project found
          //--------------------------------------------------------------------

          // Set return data
          $return_data[ 'data' ][ 'id' ] = $result->row[ 'id' ];
          $return_data[ 'data' ][ 'customer_id' ] = $result->row[ 'customer_id' ];
//          $return_data[ 'data' ][ 'project_id' ] = $result->row[ 'project_id' ];
          $return_data[ 'data' ][ 'project_number' ] = $this->Compose_Project_Number( $result->row[ 'project_year' ], $result->row[ 'project_number' ] );
          $return_data[ 'data' ][ 'project_name' ] = $result->row[ 'project_name' ];
//          $return_data[ 'data' ][ 'activity_id' ] = $result->row[ 'activity_id' ];
          $return_data[ 'data' ][ 'activity_name' ] = $result->row[ 'activity_name' ];
          $return_data[ 'data' ][ 'activity_date' ] = date_format( date_create( $result->row[ 'activity_date' ] ), 'd.m.Y' );
          $return_data[ 'data' ][ 'activity_duration' ] = date( 'H:i:s', mktime( 0, 0, $result->row[ 'activity_duration' ] ) );
          $return_data[ 'data' ][ 'activity_description' ] = $result->row[ 'activity_description' ];

          // Set success code
          $return_data[ 'return_code' ] = true;

          // Leave row count decoder
          break;

        }

        //----------------------------------------------------------------------
        // Several projects found
        //----------------------------------------------------------------------

        default:
        {

          //--------------------------------------------------------------------
          // ERROR: Several projects found
          //--------------------------------------------------------------------

          // Set error code
          $return_data[ 'return_code' ] = false;
          $return_data[ 'error_code' ] = 'Bad row count: ' . $result->num_rows;

          // Leave row count decoder
          break;

        }

      }

    }

    // Return data
    return( $return_data );

  }

  //----------------------------------------------------------------------------
  // Compose project number
  //----------------------------------------------------------------------------

  public function Compose_Project_Number( $project_year, $project_number )
  {

    // Compose full project number
    $full_project_number = 'P' . str_pad( $project_year, 3, "0", STR_PAD_LEFT ) . '.' . str_pad( $project_number, 2, "0", STR_PAD_LEFT );

    // Return project number
    return( $full_project_number );

  }

  //----------------------------------------------------------------------------
  // Decompose project number
  //----------------------------------------------------------------------------

  public function Decompose_Project_Number( $full_project_number )
  {

    // Split full project number
    // PYYY.NN => PYYY + NN
    $number_exploded = explode( '.', $full_project_number );

    // Compose data
    $data[ 'year' ] = substr( $number_exploded[ 0 ], 1 );
    $data[ 'number' ] = $number_exploded[ 1 ];

    // Return decomposed project number
    return( $data );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
