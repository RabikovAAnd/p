<?php
class ModelShippingMethods extends Model
{

  //----------------------------------------------------------------------------
  // Get shipping methods ID
  //----------------------------------------------------------------------------

  public function getMethodsID( $pickup_country_id, $delivery_country_id, $goods )
  {

    // Compose SQL querry
    $sql = "SELECT sm.id FROM shipping_method_to_country smtc ";
    $sql .= "LEFT JOIN shipping_method sm ON smtc.shipping_method_id=sm.id ";
    $sql .= "WHERE smtc.country_id=" . (int)$delivery_country_id . " AND ";
    $sql .= "sm.weight_maximum>='" . (double)$goods[ 'weight' ] . "' AND ";
    $sql .= "sm.length_maximum>='" . (double)$goods[ 'length' ] . "' AND ";
    $sql .= "sm.width_maximum>='" . (double)$goods[ 'width' ] . "' AND ";
    $sql .= "sm.height_maximum>='" . (double)$goods[ 'height' ] . "' AND ";
    $sql .= "sm.value_maximun>='" . (double)$goods[ 'value' ] . "' AND ";
    $sql .= "sm.active=1";

    // Query database
    $query = $this->db->query( $sql );

    // Return shipping methods
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get shipping method information
  //----------------------------------------------------------------------------

  public function getMethodInformation( $method_id )
  {

    // Compose SQL querry
    $sql = "SELECT * FROM shipping_method ";
    $sql .= "WHERE id=" . (int)$method_id;

    // Query database
    $query = $this->db->query( $sql );

    // Return shipping method
    return( $query->row );

  }

  //----------------------------------------------------------------------------
  // Depricated ==> To remove
  //----------------------------------------------------------------------------
  
  public function getMethods( $country_id, $payment_method_id, $total )
  {

    $country_zone_id = 0;

    $sql_query = "SELECT * FROM shipping_method_to_country ";
    $sql_query .= "LEFT JOIN shipping_method ON shipping_method.id=shipping_method_to_country.shipping_method_id ";
    $sql_query .= "WHERE shipping_method_to_country.country_id='" . (int)$country_id . "' AND ";
//    $sql_query .= "shipping_method_to_country.payment_method_id='" . (int)$payment_method_id . "' AND ";
    $sql_query .= "(shipping_method_to_country.country_zone_id='" . (int)$country_zone_id . "' OR shipping_method_to_country.country_zone_id='0')";

    $query = $this->db->query($sql_query);

    $methods = '';

    if ($query->num_rows == 0)
    {

      // No found

    }
    else
    {

      // Get shopping cart properties
//      $weight = $this->cart->getWeight();
//      $sub_total = $this->cart->getSubTotal();

      // Iterate all shipping methods
      foreach ($query->rows as $result)
      {

        $methods[] = array(
          'id'                    => $result['id'],
          'logo'                  => $result['logo'],
          'title'             => $this->language->get('title_shipping_method_' . $result['id'] ),
          'text'              => $this->language->get('text_shipping_method_' . $result['id'] ),
          'shipping_time_minimum' => $result['shipping_time_minimum'],
          'shipping_time_maximum' => $result['shipping_time_maximum'],
          'tracking'        => $result['tracking'],
          'fee'               => $result['shipping_fee']
        );

      }

    }

    return $methods;

    }

  //----------------------------------------------------------------------------

  public function getMethod( $id = 0, $language_id = 0 )
  {

    $sql = "SELECT * FROM shipping_method WHERE id='" . (int)$id . "'";
    $query = $this->db->query($sql);

    $method = array();

    if ($query->num_rows != 1)
    {

      // Not found

    }
    else
    {

      // Iterate all methods
      foreach($query->rows as $result)
      {

        $method = array(
          'code' => $result['code'],
          'shipping_fee' => $result['shipping_fee'],
          'packing_fee' => $result['packing_fee']
        );

        if ( $language_id==0 )
        {
          
          $method['name'] = $this->language->get('text_title');
        
        }
        else
        {

          $method['name'] = $this->language->get('text_title');

        }

      }

    }

    return( $method );

  }

  //----------------------------------------------------------------------------

  public function getFee( $shipping_method_id )
  {

    $fee = '';

    if (isset($shipping_method_id))
    {

      $sql_query = "SELECT * FROM shipping_method ";
      $sql_query .= "WHERE id='" . (int)$shipping_method_id . "'";

      $query = $this->db->query($sql_query);

      if ($query->num_rows != 1)
      {

        // Not found

      }
      else
      {

        foreach ($query->rows as $result)
        {

          $fee = $result['shipping_fee'];

        }

      }

    }

      return $fee;

  }

  //----------------------------------------------------------------------------
  
}
?>