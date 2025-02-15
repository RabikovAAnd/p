<?php
class Location
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

  private $cache;
  private $session;
  private $db;
  private $log;
  
  private $country_code;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store links to objects
    $this->cache = $registry->get( 'cache' );
    $this->session = $registry->get( 'session' );
    $this->db = $registry->get( 'db' );
    $this->log = $registry->get( 'log' );

    // Use country settings from active session
    $this->country_code = $this->Get_Country_Code();

  }

  //----------------------------------------------------------------------------
  // Set language code
  //----------------------------------------------------------------------------

  public function Set_Country_Code( $country_code )
  {
    
    // Store country
    $this->country_code = strtoupper( $country_code );
    
    // Store country code in session
    $this->session->Set( 'country_code', $this->country_code );
  
  }

  //----------------------------------------------------------------------------
  // Get country code
  //----------------------------------------------------------------------------
  
  public function Get_Country_Code()
  {

    // Test for country code setted
    if ( $this->session->Is_Exists( 'country_code' ) === false )
    {
      
      //------------------------------------------------------------------------
      // Country not setted, return default country
      //------------------------------------------------------------------------
      
      // Set default default country
      $country_code = 'RU';
    
      // Store country code in session
      $this->session->Set( 'country_code', $country_code );

      // Set country
      $this->country_code = $country_code;

    }
    else
    {
      
      //------------------------------------------------------------------------
      // Country code setted
      //------------------------------------------------------------------------

      // Get country code from session
      $this->country_code = $this->session->Get( 'country_code' );
    
    }
    
    // Return country code
    return( $this->country_code );

  }

  //----------------------------------------------------------------------------
  // Is country ISO2 code valid
  //----------------------------------------------------------------------------
  
  public function Is_Country_ISO2_Code_Exists( $iso_code_2 = '' )
  {
    
    // Compose SQL query
    $sql = 
      "SELECT " .
        "COUNT(*) " . 
      "FROM " .
        "`country` " .
      "WHERE " . 
        "`country`.`iso_code_2`='" . $this->db->escape( $iso_code_2 ) . "'";

    // Execute SQL query
    $this->db->query( $sql );

    return( true );

  }
  
  //----------------------------------------------------------------------------
  // Get list of active countries
  //----------------------------------------------------------------------------

  public function Get_Countries( $language_code = 'XX' )
  {

    // Try get country information from cache
//    $countries = $this->cache->get( 'country.status' );

    // Initialise countries data
    $countries_data = array();
    
    // Test cached country information
//    if ( !$countries )
//    {

        //------------------------------------------------------------------------
        // Countries list not cached, fetch from database
        //------------------------------------------------------------------------

        // Compose SQL query
        $sql = 
          "SELECT " .
            "`country`.`country_id`, " . 
            "`country_description`.`description` AS name, " .
            "`country`.`iso_code_2`, " .
            "`country`.`iso_code_3`, " .
            "`country`.`address_format`, " .
            "`country`.`postcode_required`, " .
            "`country`.`status` " .
          "FROM " .
            "`country` " .
          "LEFT JOIN " .
            "`country_description` ON `country`.`country_id`=`country_description`.`country_id` " .
          "WHERE " . 
            "`country`.`status`=1 AND " .
            "`country_description`.`language_id`='" . $this->db->escape( $language_code ) . "' " .
          "ORDER BY " .
            "`country_description`.`description` " .
          "ASC";

        // Execute SQL query
        $reselt = $this->db->query( $sql );

        // Assign country data
        $countries_data = $reselt->rows;

//      // Set country cache information
//      $this->cache->set( 'country.status', $country_data );

//    }

    // Return list of the countries
    return( $countries_data );

  }

  //----------------------------------------------------------------------------
  // Get zones
  //----------------------------------------------------------------------------

  public function Get_Zones( $language_code = '' )
  {

    //------------------------------------------------------------------------
    // Countries list not cached, fetch from database
    //------------------------------------------------------------------------

    // Get list of active zones
    $query = $this->db->query( "SELECT * FROM zone WHERE status=1 ORDER BY name ASC" );

    // Assign country data
    $zones = $query->rows;

    // Return zones
    return( $zones );

  }

  //----------------------------------------------------------------------------
  // Get country information
  //----------------------------------------------------------------------------

  public function Get_Country_Info( $country_id, $language_code = '' )
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
  // Get country 
  //----------------------------------------------------------------------------

  public function Get_Country_By_ISO2( $iso_code_2, $language_code = '' )
  {

 $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`country` " .
      "LEFT JOIN " .
        "`country_description` " .
      "ON " .
        "`country`.`country_id`=`country_description`.`country_id` " .
      "WHERE " .
        "`country`.`iso_code_2`='" . $iso_code_2 . "' AND ".
        "`country_description`.`language_id`='" . $language_code . "' ".
        "LIMIT 1";

      // Query database
      $query = $this->db->query( $sql );

    // Test record count
    if ( $query->num_rows != 1 )
    {

      // Set default data
      $return_data[ 'valid' ] = false;
      $return_data[ 'country_id' ] = 0;
      $return_data[ 'description' ] =  '';
      $return_data[ 'iso_code_2' ] =  '';
      $return_data[ 'iso_code_3' ] = '';

    }
    else
    {

      // Set properties description
      $return_data[ 'valid' ] = true;
      $return_data[ 'country_id' ] = $query->row[ 'country_id' ];
      $return_data[ 'description' ] = $query->row[ 'description' ];
      $return_data[ 'iso_code_2' ] = $query->row[ 'iso_code_2' ];
      $return_data[ 'iso_code_3' ] = $query->row[ 'iso_code_3' ];

    }

    // Return country
    return( $return_data );

  }
  //----------------------------------------------------------------------------
  // Get country name
  //----------------------------------------------------------------------------

  public function Get_Country_Name( $country_id, $language_code = '' )
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
  // Get country zones
  //----------------------------------------------------------------------------

  public function Get_Country_Zones( $country_id )
  {

    // Try to get data from cache
    $zone_data = $this->cache->get( 'zone.' . (int)$country_id );

    // Test cache data
    if ( !$zone_data )
    {

      // Compose query
      $sql = "SELECT * FROM zone WHERE country_id =" . (int)$country_id . " AND status=1 ORDER BY name";

      // Query database
      $result = $this->db->query( $sql );

      // Get zone data
      $zone_data = $result->rows;

      // Store data in cache
      $this->cache->set( 'zone.' . (int)$country_id, $zone_data );

    }

    // Return data
    return( $zone_data );

  }

  //----------------------------------------------------------------------------
  // Get country zone information
  //----------------------------------------------------------------------------

  public function Get_Country_Zone_Info( $zone_id )
  {

    // Compose query
    $sql = "SELECT * FROM zone WHERE zone_id=" . (int)$zone_id . " AND status=1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->row );

  }

  //----------------------------------------------------------------------------
  // Get country zone name
  //----------------------------------------------------------------------------

  public function Get_Zone_Name( $zone_id, $language_code = '' )
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
//      $sql = "SELECT description AS name FROM zone_description WHERE zone_id=" . (int)$zone_id . " AND language_id='". $language_code . "' LIMIT 1";
      $sql = "SELECT name FROM zone WHERE zone_id=" . (int)$zone_id;

      // Query database
      $result = $this->db->query( $sql );

      // Get country name
      $name = $result->row[ 'name' ];

    }

    // Return country name
    return( $name );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>