<?php
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// ANVILEX KM: Model is depricated, don't use it
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
class ModelLocalisationCountry extends Model
{

  //----------------------------------------------------------------------------
  // Get countries
  //----------------------------------------------------------------------------
/*
  public function getCountries()
  {

    // Try get country information from cache
    $country_data = $this->cache->get( 'country.status' );

    // Test cached country information
    if ( !$country_data )
    {

      //------------------------------------------------------------------------
      // Countries list not cached, fetch from database
      //------------------------------------------------------------------------

      // Get list of active countries
      $query = $this->db->query( "SELECT * FROM country WHERE status=1 ORDER BY name ASC" );

      // Assign country data
      $country_data = $query->rows;

      // Set country cache information
      $this->cache->set( 'country.status', $country_data );

    }

    // Return list of the countries
    return( $country_data );

  }
*/
  //----------------------------------------------------------------------------
  // Get country information
  //----------------------------------------------------------------------------

  public function getCountry( $country_id, $language_code = '' )
  {

    // Test language code
    if ( $language_code == '' )
    {

      //------------------------------------------------------------------------
      // No language specified
      //------------------------------------------------------------------------
      
      $sql = "SELECT * FROM country WHERE country_id=" . (int)$country_id . " LIMIT 1";

    }
    else
    {

      //------------------------------------------------------------------------
      // Language specified
      //------------------------------------------------------------------------

      $sql = "SELECT c.*, cd.description FROM country c LEFT JOIN country_description cd ON c.country_id=cd.country_id WHERE c.country_id=" . (int)$country_id . " AND cd.language_id='". $language_code . "' LIMIT 1";

    }
    
    // Get country information
    $query = $this->db->query( $sql );

    // Return country information
    return( $query->row );

  }

  //----------------------------------------------------------------------------
  // Get country name
  //----------------------------------------------------------------------------

  public function getCountryName( $country_id, $language_code = '' )
  {

    
    // Test language code
    if ( $language_code == '' )
    {

      //------------------------------------------------------------------------
      // No language specified
      //------------------------------------------------------------------------

      // Set default country name
      $name = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Language specified
      //------------------------------------------------------------------------

      // Compose SQL query
      $sql = "SELECT description AS name FROM country_description WHERE country_id=" . (int)$country_id . " AND language_id='". $language_code . "' LIMIT 1";

      // Query database
      $query = $this->db->query( $sql );

      // Get country name
      $name = $query->row[ 'name' ];


    }
    

    // Return country name
    return( $name );

  }
  
  //----------------------------------------------------------------------------
  // Get countries
  //----------------------------------------------------------------------------
  // ANVILEX KM: User global object "Location"

  public function Search_Countries($search = '' , $language_code = 'XX')
  {

   
 // Compose SQL query
 $sql =
 "SELECT * " .
 "FROM " .
   "`country_description` " .
 "WHERE " .
   "country_description.description LIKE '%" . $this->db->escape( $search ) . "%' AND " .
   "`country_description`.`language_id`='" . $this->db->escape( $language_code ) . "' " ;


    // Perform SQL query
    $query = $this->db->query( $sql );


  // Return list of the countries
  return(  $query->rows);

    

  }

}
?>