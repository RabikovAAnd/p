<?php
class ModelPaymentMethods extends Model
{

  //----------------------------------------------------------------------------
  // Get payment methods ID
  //----------------------------------------------------------------------------

  public function getMethodsID( $pickup_country_id, $delivery_country_id, $goods )
  {

    // Compose SQL querry
    $sql = "SELECT pm.id FROM payment_method_to_country pmtc ";
    $sql .= "LEFT JOIN payment_method pm ON pmtc.payment_method_id=pm.id ";
    $sql .= "WHERE pmtc.country_id=" . (int)$delivery_country_id . " AND ";
    $sql .= "pm.active=1";

    // Query database
    $query = $this->db->query( $sql );

    // Return shipping methods
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
  // Get payment method information
  //----------------------------------------------------------------------------

  public function getMethodInformation( $method_id )
  {

    // Compose SQL querry
    $sql = "SELECT * FROM payment_method ";
    $sql .= "WHERE id=" . (int)$method_id;

    // Query database
    $query = $this->db->query( $sql );

    // Return shipping method
    return( $query->row );

  }

  //----------------------------------------------------------------------------

  public function getMethods($country_id, $total, $buisness)
  {

    $country_zone_id = 0;

    $sql_query = "SELECT * FROM payment_method_to_country ";
    $sql_query .= "LEFT JOIN payment_method ON payment_method.id=payment_method_to_country.payment_method_id ";
    $sql_query .= "WHERE payment_method_to_country.country_id='" . (int)$country_id . "' AND ";
    $sql_query .= "(payment_method_to_country.country_zone_id='" . (int)$country_zone_id . "' OR payment_method_to_country.country_zone_id='0')";

    $query = $this->db->query($sql_query);

    $methods = array();

    if ($query->num_rows == 0)
    {

      // Not found

    }
    else
    {

      // Iterate all methods
      foreach($query->rows as $result)
      {

        $methods[] = array(
          'id'            => $result['id'],
          'code'        => $result['code'],
          'logo'          => $result['logo'],
          'title'       => '',
          'text'          => '',
          'fixed_fee'   => $result['fixed_fee'],
          'variable_fee'  => $result['variable_fee'],
          'sort_order'  => 0
        );

      }

    }

    return $methods;

  }

  //----------------------------------------------------------------------------
  
  public function getMethod($id=0,$language_id=0)
  {

    $sql = "SELECT * FROM payment_method WHERE id='" . (int)$id . "'";
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
              'code' => $result['code']
        );

        if ($language_id==0)
        {

          $this->language->load('payment/' . $result['code']);
          $method['name'] = $this->language->get('text_title');

        }
        else
        {

          $method['name'] = $this->language->get('text_title');

        }

      }

    }

    return $method;

  }

  //----------------------------------------------------------------------------

  public function getFee($payment_method_id, $shipping_fee, $net_cart_amount)
  {

    $sql_query = "SELECT * FROM payment_method ";
    $sql_query .= "WHERE id='" . (int)$payment_method_id . "'";

    $query = $this->db->query($sql_query);

    $fee = '';

    if ($query->num_rows != 1)
    {

      // Not found

    }
    else
    {

      foreach ($query->rows as $result)
      {

        $fixed_fee = $result['fixed_fee'];
        $variable_fee = $result['variable_fee'];

        $fee = $fixed_fee + $variable_fee * ( $net_cart_amount + $shipping_fee ) ;

      }

    }

    return $fee;

  }

  //----------------------------------------------------------------------------
  
}
?>