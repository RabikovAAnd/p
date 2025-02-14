<?php
class ModelApiData extends Model
{

  //----------------------------------------------------------------------------

  public function Get_Function_Block_Group( $guid )
  {

    // Compose SQL request
    $query = $this->db_vdc->query( "SELECT `id`, `guid`, `name`, `description`, `key` FROM `vdc_database`.`block_groups` WHERE `guid` = '" . $guid . "'" );
//    $query = $this->db->query( "SELECT `id`, `guid`, `name`, `description`, `key` FROM `vdc_database`.`block_groups` WHERE `guid` = '" . $guid . "'" );

    // Return result
    return( $query->row );

  }

  //----------------------------------------------------------------------------

  public function Get_Function_Block_Groups()
  {

    // Compose SQL request
    $query = $this->db_vdc->query( "SELECT `id`, `guid`, `name`, `description`, `key` FROM `vdc_database`.`block_groups`" );
//    $query = $this->db->query( "SELECT `id`, `guid`, `name`, `description`, `key` FROM `vdc_database`.`block_groups`" );

    // Return result
    return( $query->rows );

  }

  //----------------------------------------------------------------------------
/*
  public function addData( $data )
  {

    // Compose SQL query
    $query = "INSERT INTO `kg_data` SET ";
    $query .= "`key`='" . $this->db->escape( $data[ 'key' ] ) . "', ";
    $query .= "`data`='" . $this->db->escape( $data[ 'data' ] ) . "', ";
//    $query .= "`ip`='" . $this->db->escape( $this->request->server[ 'REMOTE_ADDR' ] ) . "', ";
    $query .= "`date`=NOW()";

    // Query database
    $this->db->query( $query );

  }
*/
  //----------------------------------------------------------------------------
/*
  public function getCustomers( $data = array() )
  {

    $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM customer c LEFT JOIN customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

    $implode = array();

    if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
      $implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
    }

    if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
      $implode[] = "LCASE(c.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
    }

    if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
      $implode[] = "c.status = '" . (int)$data['filter_status'] . "'";
    }

    if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
      $implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
    }

    if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
      $implode[] = "c.customer_id IN (SELECT customer_id FROM customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
    }

    if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
      $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
    }

    if ($implode)
    {
      $sql .= " WHERE " . implode(" AND ", $implode);
    }

    $sort_data = array(
      'name',
      'c.email',
      'c.status',
      'c.ip',
      'c.date_added'
    );

    if (isset($data['sort']) && in_array($data['sort'], $sort_data))
    {
      $sql .= " ORDER BY " . $data['sort'];
    }
    else
    {
      $sql .= " ORDER BY name";
    }

    if (isset($data['order']) && ($data['order'] == 'DESC'))
    {
      $sql .= " DESC";
    }
    else
    {
      $sql .= " ASC";
    }

    if (isset($data['start']) || isset($data['limit']))
    {
      if ($data['start'] < 0)
      {
        $data['start'] = 0;
      }

      if ($data['limit'] < 1)
      {
        $data['limit'] = 20;
      }

      $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    }

    $query = $this->db->query($sql);

    return $query->rows;

  }
*/
  //------------------------------------------------------------------------------------------------

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
