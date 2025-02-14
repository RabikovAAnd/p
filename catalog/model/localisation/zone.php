<?php
class ModelLocalisationZone extends Model
{

  //----------------------------------------------------------------------------
  // Get zone information
  //----------------------------------------------------------------------------

  public function getZone( $zone_id )
  {

    // Compose query
    $sql = "SELECT * FROM zone WHERE zone_id=" . (int)$zone_id . " AND status=1";

    // Query database
    $result = $this->db->query( $sql );

    // Return data
    return( $result->row );

  }

  //----------------------------------------------------------------------------
  // Get zones by country
  //----------------------------------------------------------------------------

  public function getZonesByCountryId( $country_id )
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
  // Get zone name
  //----------------------------------------------------------------------------

  public function getZoneName( $zone_id, $language_code = 'XX' )
  {


    // Test language code
    if ( $language_code == 'CC' )
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
//      $sql = "SELECT description AS name FROM zone_description WHERE zone_id=" . (int)$zone_id . " AND language_code='". $language_code . "' LIMIT 1";
      $sql = "SELECT name FROM zone WHERE zone_id=" . (int)$zone_id;

      // Query database
      $result = $this->db->query( $sql );

      // Get country name
      $name = $result->row[ 'name' ];

    }


    // Return country zone name
    return( $name );

  }

  //----------------------------------------------------------------------------

}
?>