<?php
class ModelCustomersCustomers extends Model 
{

  //----------------------------------------------------------------------------
  // Get customer information
  //----------------------------------------------------------------------------

	
  public function Search_Customers_Count($search = '', $firstname = true, $lastname = false, $manufacturer=false)
  { 
    if($firstname || $lastname || $manufacturer){
    //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();
    
    if ( $firstname === true )
    {
      $where_or[] = "customer.firstname LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $lastname === true )
    {    
      $where_or[] = "customer.lastname LIKE '%" . $this->db->escape( $search ) . "%'";
    }

    if ( $manufacturer === true )
    {
      $where_or[] = "customer.company_name LIKE '%" . $this->db->escape( $search ) . "%'";
    }
    //--------------------------------------------------------------------------
    // Compose AND part
    //--------------------------------------------------------------------------

 
    $where_and = array();

    if ( count( $where_or ) == 1 )
    {
      $where_and[] = implode( ' OR ', $where_or );
    }
    else
    {
      if ( count( $where_or ) > 1 )
      {
        $where_and[] = '( ' . implode( ' OR ', $where_or ) . ' )';
      }
    }
    
   


    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode(  ' AND ', $where_and  );
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "COUNT(*) " .
      "FROM " .
        "customer " .
      "WHERE " . 
        $where . ";";
    // Query database
    $results = $this->db->query( $sql );
    $result = $results->row[ 0 ] ;
  }else{
    $result = 0;
  }
    // Return data
    return( $result );
  
  }
  public function Get_List_Of_Customers( $page_length, $page_number, $search = '', $firstname = true, $lastname = false, $manufacturer = false)
  {
    if($firstname || $lastname || $manufacturer){
      //--------------------------------------------------------------------------
    // Compose OR part
    //--------------------------------------------------------------------------

    $where_or = array();
        
    if ( $firstname === true )
    {
      $where_or[] = "customer.firstname LIKE '%" . $this->db->escape( $search ) . "%' ";
    }

    if ( $lastname === true )
    {    
      $where_or[] = "customer.lastname LIKE '%" . $this->db->escape( $search ) . "%'";
    }

    if ( $manufacturer === true )
    {
      $where_or[] = "customer.company_name LIKE '%" . $this->db->escape( $search ) . "%'";
    }
    //--------------------------------------------------------------------------
    // Compose AND part
    //--------------------------------------------------------------------------


    $where_and = array();

    if ( count( $where_or ) == 1 )
    {
      $where_and[] = implode( ' OR ', $where_or );
    }
    else
    {
      if ( count( $where_or ) > 1 )
      {
        $where_and[] = '( ' . implode( ' OR ', $where_or ) . ' )';
      }
    }
   

    //--------------------------------------------------------------------------
    // Compose WHERE clause
    //--------------------------------------------------------------------------

    $where = implode(  ' AND ', $where_and );
    //--------------------------------------------------------------------------
    // Compose SQL query
    //--------------------------------------------------------------------------

    $sql =
      "SELECT " .
        "customer.guid AS guid, " .
        "customer.customer_id AS id, " .
        "customer.lastname AS lastname, " .
        "customer.status AS status, " .
        "customer.firstname AS name, " .
        "customer.registration_country AS registration_country, " .
        "customer.company_name AS company_name " .
      "FROM " .
        "customer " .
      "WHERE " . 
        $where . " " .
    //! @note ANVILEX KM: Sorting caused increase server response time.
    //      "ORDER BY product.mpn ASC " .
      "LIMIT " . $this->db->escape( $page_length ) . " " .
      "OFFSET " . $this->db->escape( $page_length * ( $page_number - 1 ) ) . ";";

//      $this->log->Log_Debug( $sql );

    // Query database
    $results = $this->db->query( $sql );

    $result = $results->rows;

    }
    else
    {

      $result = [];

    }

    // Return data
    return( $result );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
