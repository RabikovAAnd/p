<?php
class ModelNewsNews extends Model 
{

  public function Get_Teaser_Latest_News( $language_code = "XX" )
  {

    // Compose SQL query
    $sql = "SELECT ";
    $sql .= "`company_news`.`id`, ";
    $sql .= "`company_news`.`creation_date`, ";
    $sql .= "`company_news`.`image_type`, ";
    $sql .= "`company_news`.`image_data`, ";
    $sql .= "`company_news_content`.`headline`, ";
    $sql .= "`company_news_content`.`agenda`, ";
    $sql .= "`company_news_content`.`body` ";
    $sql .= "FROM `company_news` ";
    $sql .= "INNER JOIN ";
    $sql .= "`company_news_content` ";
    $sql .= "ON ";
    $sql .= "`company_news`.`id` = `company_news_content`.`news_id` ";
    $sql .= "WHERE ";
    $sql .= "`company_news`.`status` = 'active' ";
    $sql .= "AND ";
    $sql .= "`company_news_content`.`language_code` = '" . $language_code . "' ";
    $sql .= "ORDER BY `company_news`.`creation_date` DESC ";
    $sql .= "LIMIT 1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows[0]);

  }

  //----------------------------------------------------------------------------
  // Get teaser news
  //----------------------------------------------------------------------------
  
  public function Get_Teaser_News( $language_code = "XX" )
  {

    // Compose SQL query
    $sql = "SELECT ";
    $sql .= "`company_news`.`id`, ";
    $sql .= "`company_news`.`creation_date`, ";
    $sql .= "`company_news_content`.`headline` ";
    $sql .= "FROM `company_news` ";
    $sql .= "INNER JOIN ";
    $sql .= "`company_news_content` ";
    $sql .= "ON ";
    $sql .= "`company_news`.`id` = `company_news_content`.`news_id` ";
    $sql .= "WHERE ";
    $sql .= "`company_news`.`status` = 'active' ";
    $sql .= "AND ";
    $sql .= "`company_news_content`.`language_code` = '" . $language_code . "' ";
    $sql .= "ORDER BY `company_news`.`creation_date` DESC ";
    $sql .= "LIMIT 3 ";
    $sql .= "OFFSET 1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->rows);

  }

  //----------------------------------------------------------------------------
  // Get news list
  //----------------------------------------------------------------------------

  public function getNews( $data = array() )
  {
    
    // Compose SQL query
    $sql = "SELECT cn.id, cn.creation_date, cnc.headline, cnc.body FROM company_news cn INNER JOIN company_news_content cnc ON cn.id=cnc.news_id WHERE cn.status='" . $data['status'] . "' ORDER BY cn.creation_date DESC LIMIT " . (int)$data['limit'];
//    $sql = "SELECT cn.id, cn.creation_date, cnc.headline, cnc.agenda, cnc.body FROM company_news_content cnc INNER JOIN company_news cn ON cnc.news_id=cn.id WHERE cn.status='" . $data['status'] . "' AND cnc.language_id=" . (int)$language_id . " ORDER BY cn.creation_date DESC LIMIT " . (int)$data['limit'];

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return( $query->rows );
    
  }

  //----------------------------------------------------------------------------
  // Get news item
  //----------------------------------------------------------------------------

  public function Get_News_Item( $id, $language_code ) 
  {

    // ANVILEX KM: Check id validity

    // Compose SQL query
    $sql = "SELECT cn.id, cn.creation_date, cnc.headline, cnc.agenda, cnc.body " .
      "FROM company_news_content cnc " .
      "INNER JOIN company_news cn " .
      "ON cnc.news_id=cn.id " .
      "WHERE cnc.news_id=" . (int)$id . " AND cnc.language_code='" . $language_code . "'";

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
    $sql = "SELECT image_type, image_data FROM company_news WHERE id=" . (int)$id;

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
  // Add new subscriber
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