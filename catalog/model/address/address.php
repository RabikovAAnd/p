<?php
class ModelAddressAddress extends Model
{

  // Database fields size definitions
  private const address_postcode_field_size = 15;
  private const address_city_field_size = 127;
  private const address_street_field_size = 127;
  private const address_house_field_size = 127;
  private const address_building_field_size = 127;
  private const address_apartment_field_size = 127;

  //----------------------------------------------------------------------------
  // Return maximum string size of address postcode database field
  //----------------------------------------------------------------------------

  public function Get_Address_Postcode_Maximum_String_Size()
  {

    // Return maximum string size of address postcode database field
    return ( self::address_postcode_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of address city database field
  //----------------------------------------------------------------------------

  public function Get_Address_City_Maximum_String_Size()
  {

    // Return maximum string size of address city database field
    return ( self::address_city_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of address street database field
  //----------------------------------------------------------------------------

  public function Get_Address_Street_Maximum_String_Size()
  {

    // Return maximum string size of address street database field
    return ( self::address_street_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of address house database field
  //----------------------------------------------------------------------------

  public function Get_Address_House_Maximum_String_Size()
  {

    // Return maximum string size of address house database field
    return ( self::address_house_field_size );

  }

  //----------------------------------------------------------------------------
  // Return maximum string size of address building database field
  //----------------------------------------------------------------------------

  public function Get_Address_Building_Maximum_String_Size()
  {

    // Return maximum string size of address building database field
    return ( self::address_building_field_size );

  }
  //----------------------------------------------------------------------------
  // Return maximum string size of address apartment database field
  //----------------------------------------------------------------------------

  public function Get_Address_Apartment_Maximum_String_Size()
  {

    // Return maximum string size of address apartment database field
    return ( self::address_apartment_field_size );

  }
  //----------------------------------------------------------------------------
  // Get adresses by customer guid
  //----------------------------------------------------------------------------

  public function Get_Addresses( $customer_guid = '' )
  {

    $address_data = array();

    // Compose SQL query
    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`addresses` " .
      "WHERE " .
        "`addresses`.`customer_guid`='" . $customer_guid . "'";

    // Execute SQL query
    $query = $this->db->query($sql);

    if ( $query->num_rows == 0 ) 
    {

      //      $address_data = [];

    } 
    else 
    {

      foreach ($query->rows as $result) 
      {

        $country_query = $this->db->query("SELECT * FROM country WHERE country_id = '" . (int) $result['country_id'] . "'");

        if ($country_query->num_rows) 
        {
          $country = $country_query->row['name'];
          $iso_code_2 = $country_query->row['iso_code_2'];
          $iso_code_3 = $country_query->row['iso_code_3'];
          $address_format = $country_query->row['address_format'];
        } 
        else 
        {
          $country = '';
          $iso_code_2 = '';
          $iso_code_3 = '';
          $address_format = '';
        }

        $zone_query = $this->db->query("SELECT * FROM zone WHERE zone_id = '" . (int) $result['zone_id'] . "'");

        if ($zone_query->num_rows) 
        {
          $zone = $zone_query->row['name'];
          $zone_code = $zone_query->row['code'];
        } 
        else 
        {
          $zone = '';
          $zone_code = '';
        }

        $address_data[ $result[ 'address_id' ] ] = array(
          //          'address_id' => $result[ 'address_id' ],
          'guid' => $result['guid'],
          'apartment' => $result['apartment'],
          'building' => $result['building'],
          'street' => $result['street'],
          'house' => $result['house'],
          'postcode' => $result['postcode'],
          'city' => $result['city'],
          'zone_id' => $result['zone_id'],
          'zone' => $zone,
          'zone_code' => $zone_code,
          'country_id' => $result['country_id'],
          'country' => $country,
          'iso_code_2' => $iso_code_2,
          'iso_code_3' => $iso_code_3,
          'address_format' => $address_format,
          'active' => $result['active']
        );

      }

    }

    return ( $address_data );

  }

  //----------------------------------------------------------------------------
  // Get address
  //----------------------------------------------------------------------------

  public function Get_Address( $guid = '' )
  {

    $data = array();

    $sql = "SELECT DISTINCT * FROM addresses WHERE guid = '" . $guid . "'";

    $address_query = $this->db->query($sql);

    if ($address_query->num_rows != 1) {

      $data = array(
        'valid' => false,
        'guid' => '',
        'apartment' => '',
        'building' => '',
        'street' => '',
        'house' => '',
        'postcode' => '',
        'city' => '',
        'zone_id' => '',
        'zone' => '',
        'zone_code' => '',
        'country_id' => '',
        'country' => '',
        'iso_code_2' => '',
        'iso_code_3' => '',
        'address_format' => '',
      );

    } 
    else 
    {

      $country_query = $this->db->query( "SELECT * FROM country WHERE country_id = '" . (int)$address_query->row[ 'country_id' ] . "'" );

      if ($country_query->num_rows) 
      {
        $country = $country_query->row[ 'name' ];
        $iso_code_2 = $country_query->row[ 'iso_code_2' ];
        $iso_code_3 = $country_query->row[ 'iso_code_3' ];
        $address_format = $country_query->row[ 'address_format' ];
      } 
      else 
      {
        $country = '';
        $iso_code_2 = '';
        $iso_code_3 = '';
        $address_format = '';
      }

      $zone_query = $this->db->query( "SELECT * FROM zone WHERE zone_id = '" . (int)$address_query->row[ 'zone_id' ] . "'" );

      if ( $zone_query->num_rows ) 
      {
        $zone = $zone_query->row[ 'name' ];
        $zone_code = $zone_query->row[ 'code' ];
      } 
      else 
      {
        $zone = '';
        $zone_code = '';
      }

      $data = array(

        'valid' => true,
        'guid' => $address_query->row[ 'guid' ],
        'apartment' => $address_query->row[ 'apartment' ],
        'building' => $address_query->row[ 'building' ],
        'street' => $address_query->row[ 'street' ],
        'house' => $address_query->row[ 'house' ],
        'postcode' => $address_query->row[ 'postcode' ],
        'city' => $address_query->row[ 'city' ],
        'zone_id' => $address_query->row[ 'zone_id' ],
        'zone' => $zone,
        'zone_code' => $zone_code,
        'country_id' => $address_query->row[ 'country_id' ],
        'country' => $country,
        'iso_code_2' => $iso_code_2,
        'iso_code_3' => $iso_code_3,
        'address_format' => $address_format
      );
    }

    // Return address data
    return ( $data );

  }

  //----------------------------------------------------------------------------
  // Add address
  //----------------------------------------------------------------------------

  public function Add( $customer_guid = '', $data = array() )
  {

    // Generate address GUID
    $guid = UUID_V4_T1();

    // Compose SQL query
    $sql =
      "INSERT INTO " .
        "addresses " .
      "SET " .
        "guid='" . $guid . "', " .
        "customer_guid='" . $this->db->escape($customer_guid) . "', " .
        "country_id='" . (int) $data['country_id'] . "', " .
        "zone_id='" . (int) $data['zone_id'] . "', " .
        "postcode='" . $this->db->escape($data['postcode']) . "', " .
        "city='" . $this->db->escape($data['city']) . "', " .
        "street='" . $this->db->escape($data['street']) . "', " .
        "house='" . $this->db->escape($data['house']) . "', " .
        "building='" . $this->db->escape($data['building']) . "', " .
        "apartment='" . $this->db->escape($data['apartment']) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error
    return( $return_code );

  }


  //----------------------------------------------------------------------------
  // Update address
  //----------------------------------------------------------------------------

  public function Update($customer_guid, $address_guid, $data)
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
        "addresses " .
      "SET " .
        "country_id='" . $this->db->escape((int) $data['country_id']) . "', " .
        "zone_id='" . $this->db->escape((int) $data['zone_id']) . "', " .
        "postcode='" . $this->db->escape($data['postcode']) . "', " .
        "city='" . $this->db->escape($data['city']) . "', " .
        "street='" . $this->db->escape($data['street']) . "', " .
        "house='" . $this->db->escape($data['house']) . "', " .
        "building='" . $this->db->escape($data['building']) . "', " .
        "apartment='" . $this->db->escape($data['apartment']) . "' " .
      "WHERE " .
        "guid='" . $this->db->escape($address_guid) . "' AND " .
        "customer_guid='" . $this->db->escape($customer_guid) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return ($return_code);

  }

  //----------------------------------------------------------------------------
  // Inactivate address
  //----------------------------------------------------------------------------

  public function Inactivate( $address_guid )
  {

    // Compose SQL query
    $sql =
      "UPDATE " .
      "`addresses` " .
      "SET " .
      "`active`='0' " .
      "WHERE " .
      "`guid`='" . $this->db->escape( $address_guid ) . "'";

    // Query database
    $this->db->query( $sql );

    // Set success code
    $return_code = true;

    // Return success/error code
    return ( $return_code );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>