<?php
class ModelManufacturersManufacturers extends Model
{

  //----------------------------------------------------------------------------
  // Get manufacturer information
  //----------------------------------------------------------------------------

  public function getManufacturer( $manufacturer_id, $language_code = 'XX' )
  {

    // Compose SQL query
    $sql = "SELECT m.name, m.name_short, m_d.description ";
    $sql .= "FROM manufacturer m ";
    $sql .= "INNER JOIN manufacturer_description m_d ";
    $sql .= "ON m.manufacturer_id = m_d.manufacturer_id ";
    $sql .= "WHERE m.manufacturer_id = '";
    $sql .= $this->db->escape( $manufacturer_id ) . "' ";
    $sql .= " AND m_d.language_code = '";
    $sql .= $this->db->escape( $language_code ) . "'";

    // Process SQL query
    $query = $this->db->query( $sql );

    //
    if ( $query->num_rows < 1 )
    {

      $sql = "SELECT * ";
      $sql .= "FROM manufacturer m ";
      $sql .= "WHERE m.manufacturer_id = ";
      $sql .= (int)$manufacturer_id;

      $query = $this->db->query( $sql );

    }

    return( $query->row );

  }

  //----------------------------------------------------------------------------
  // Get manufacturers list
  //----------------------------------------------------------------------------

	public function getManufacturers( $data = array() )
	{

		if ($data)
		{

			$sql = "SELECT * FROM manufacturer m";

			$sort_data = array(
				'name',
				'sort_order'
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

      $manufacturer_data = $query->rows;

		}
		else
		{

//			$manufacturer_data = $this->cache->get('manufacturer');

//			if (!$manufacturer_data)
//			{
				$query = $this->db->query( "SELECT * FROM manufacturer m ORDER BY name" );

				$manufacturer_data = $query->rows;

//				$this->cache->set('manufacturer', $manufacturer_data);
//			}


		}

    return $manufacturer_data;

	}

  //----------------------------------------------------------------------------

  public function getManufacturers1( $data = array() )
  {

    if ($data)
    {

        $sql = "SELECT * FROM manufacturer m";

        $sort_data = array(
            'name',
            'sort_order'
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
    else
    {

//        $manufacturer_data = $this->cache->get('manufacturer');

        if (!$manufacturer_data)
        {
            $query = $this->db->query( "SELECT * FROM manufacturer m ORDER BY name ");

            $manufacturer_data = $query->rows;

//            $this->cache->set('manufacturer', $manufacturer_data);
        }

        return $manufacturer_data;
    }

  }
  
  //----------------------------------------------------------------------------

  public function Get_List_Of_Manufacturers( $page_length = 30, $search = '' )
  {
    
  //  if( $search === ''){
  //   return( [] );
  //  }
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "* " .
      "FROM " .
        "`customer` " .
      "WHERE " . 
        "`company_name` LIKE '%" . $this->db->escape( $search ) . "%' AND " .
        "`manufacturer`=1 " .
      "LIMIT " . $this->db->escape( $page_length ) . ";";
    
    // Query database
    $results = $this->db->query( $sql );

    // Return data
    return( $results->rows );

  }
  
  //----------------------------------------------------------------------------

  public function Is_Manufacturer_Exist( $manufacturer_guid)
  {

    $sql =
    "SELECT * " .
    "FROM " .
      "customer " .
    "WHERE guid ='" . $this->db->escape( $manufacturer_guid ) . "'  AND " .
    "manufacturer =1 " .
    "LIMIT 1 ;";
     // Query database

     $result = $this->db->query( $sql );
    // Test record count
    if ( $result->num_rows == 1 )
    {
    
      //------------------------------------------------------------------------
      // Manufacturer found
      //------------------------------------------------------------------------

      // Set manufacturer found status
      $result = true;
      
    }
    else
    {

      //------------------------------------------------------------------------
      // Manufacturer not found
      //------------------------------------------------------------------------
      
      // Set project not found status
      $result = false;
      
    }

    return( $result );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>