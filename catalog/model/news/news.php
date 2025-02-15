<?php
class ModelNewsNews extends Model 
{

  //----------------------------------------------------------------------------
  // Get teaser latest news line
  //----------------------------------------------------------------------------

  public function Get_Teaser_Latest_News( $language_code = "XX" )
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`company_news`.`id`, " .
        "`company_news`.`creation_date`, " .
        "`company_news`.`image_type`, " .
        "`company_news`.`image_data`, " .
        "`company_news_content`.`headline`, " .
        "`company_news_content`.`agenda`, " .
        "`company_news_content`.`body` " .
      "FROM " .
        "`company_news` " .
      "INNER JOIN " .
        "`company_news_content` " .
      "ON " .
        "`company_news`.`id`=`company_news_content`.`news_id` " .
      "WHERE " .
        "`company_news`.`status`='active' AND " .
        "`company_news_content`.`language_code`='" . $this->db->escape( $language_code ) . "' " .
      "ORDER BY `company_news`.`creation_date` DESC " .
      "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows[ 0 ] );

  }

  //----------------------------------------------------------------------------
  // Get teaser news
  //----------------------------------------------------------------------------
  
  public function Get_Teaser_News( $count = 1, $language_code = "XX" )
  {

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`company_news`.`id`, " .
        "`company_news`.`creation_date`, " .
        "`company_news_content`.`headline` " .
      "FROM " .
        "`company_news` " .
      "INNER JOIN " .
        "`company_news_content` " .
      "ON " .
        "`company_news`.`id`=`company_news_content`.`news_id` " .
      "WHERE " .
        "`company_news`.`status`='active' " .
      "AND " .
        "`company_news_content`.`language_code` = '" . $this->db->escape( $language_code ) . "' " .
      "ORDER BY `company_news`.`creation_date` DESC " .
      "LIMIT " . $this->db->escape( (string)$count ) . " " .
      "OFFSET 1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows );

  }

  //----------------------------------------------------------------------------
  // Get news item
  //----------------------------------------------------------------------------

  public function Get_News_Item( $id, $language_code = "XX" ) 
  {

    // ANVILEX KM: Check id validity

    // Compose SQL query
    $sql = 
      "SELECT " .
        "cn.id, " .
        "cn.creation_date, " .
        "cnc.headline, " .
        "cnc.agenda, " .
        "cnc.body " .
      "FROM " . 
        "company_news_content cnc " .
      "INNER JOIN " .
        "company_news cn " .
      "ON " .
        "cnc.news_id=cn.id " .
      "WHERE " .
        "cnc.news_id=" . (int)$id . " AND " .
        "cnc.language_code='" . $this->db->escape( $language_code ) . "'";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test result
    if ( $result->num_rows != 1 )
    {
      
      //------------------------------------------------------------------------
      // ERROR: No news found
      //------------------------------------------------------------------------
      
      // Set default data
      $data[ 'valid' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // News item found, continue processing
      //------------------------------------------------------------------------
      
      // Extraxt information
      $data[ 'valid' ] = true;
      $data[ 'id' ] = $result->row[ 'id' ];
      $data[ 'creation_date' ] = $result->row[ 'creation_date' ];
      $data[ 'headline' ] = $result->row[ 'headline' ];
      $data[ 'agenda' ] = $result->row[ 'agenda' ];
      $data[ 'body' ] = $result->row[ 'body' ];

    }

    // Return data
    return( $data );
    
  }

  //----------------------------------------------------------------------------
  // Get news image
  //----------------------------------------------------------------------------
  
  public function getNews_Item_Image( $id )
  {

    // ANVILEX KM: Check id validity
     
    // Compose SQL query
    $sql = 
      "SELECT " .
        "image_type, " .
        "image_data " .
      "FROM " .
        "company_news " .
      "WHERE " .
        "id=" . (int)$id;

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return( $query->row );

  }

  //----------------------------------------------------------------------------
  // Get news years
  //----------------------------------------------------------------------------

  public function Get_News_Years()
  {

    // Compose SQL query
    $sql = "SELECT YEAR(creation_date) AS creation_year FROM company_news WHERE status='active' GROUP BY creation_year ORDER BY creation_year DESC";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test result
    if ( $result->num_rows < 1 )
    {
      
      //------------------------------------------------------------------------
      // ERROR: Years not found
      //------------------------------------------------------------------------
      
      // Set default data
      $data[ 'valid' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Years found, continue processing
      //------------------------------------------------------------------------
      
      // Extraxt years information
      $data[ 'valid' ] = true;
      
      // Iterate all years
      foreach( $result->rows as $row )
      {
        
        // Assign year
        $data[ 'years' ][] = $row[ 'creation_year' ];
      
      }
      
    }

    // Return data
    return( $data );
    
  }

  //----------------------------------------------------------------------------
  // Get news ID by year
  //----------------------------------------------------------------------------

  public function Get_News_Id_By_Year( $year )
  {

    // Compose SQL query
    $sql = "SELECT id FROM company_news WHERE YEAR(creation_date)=" . (int)$year . " AND status='active' ORDER BY creation_date DESC";

    // Execute SQL query
    $result = $this->db->query( $sql );

    // Test result
    if ( $result->num_rows < 1 )
    {
      
      //------------------------------------------------------------------------
      // ERROR: News items not found
      //------------------------------------------------------------------------
      
      // Set default data
      $data[ 'valid' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // News items found, continue processing
      //------------------------------------------------------------------------
      
      // Extraxt information
      $data[ 'valid' ] = true;
      
      // Iterate all records
      foreach( $result->rows as $row )
      {

        // Set ID
        $data[ 'data' ][] = $row[ 'id' ];

      }
    
    }

    // Return data
    return( $data );

  }

  //----------------------------------------------------------------------------
  // Add new news subscriber
  //----------------------------------------------------------------------------

  public function Add_Subscriber( $email )
  {
    
     $sql = "INSERT emails(email) VALUES ('" . $this->db->escape( $email ) . "')";

      // Query database
      $this->db->query( $sql );

      // Set success code
      $return_code = true;


      // Return status
      return( $return_code );
    
  }

  //----------------------------------------------------------------------------
  //
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
  
}

//----------------------------------------------------------------------------
// End of file
//----------------------------------------------------------------------------
?>