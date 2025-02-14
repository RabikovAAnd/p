<?php
class ModelServicesServices extends Model 
{

  //----------------------------------------------------------------------------
  // Get company service categores
  //----------------------------------------------------------------------------

  public function getServiceCategories( $data = array() )
  {
    
    // Compose SQL query
    $sql = "SELECT cs.id, csd.name, csd.description FROM company_services cs INNER JOIN company_services_description csd ON cs.id=csd.service_id WHERE cs.status='" . (int)$data['status'] . "' AND csd.language_id='1' LIMIT " . (int)$data['limit'];

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return $query->rows;

  }

  //----------------------------------------------------------------------------

  public function getServiceImage( $id )
  {

    // Compose SQL query
    $sql = "SELECT image_type, image_data FROM company_services WHERE id=" . (int)$id . ' LIMIT 1';

    // Execute SQL query
    $query = $this->db->query( $sql );

    // Return query
    return $query->row;

  }

  //----------------------------------------------------------------------------
  
/*
  public function updateViewed($product_id) 
  {

    $this->db->query("INSERT INTO product_impressions SET product_id='" . (int)$product_id . "', date=NOW(), ip='" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', url_source='', source= '1'");

  }
*/
}
?>