<?php
class Payment
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

//  private $cache;
//  private $session;
  private $db;
//  private $log;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store links to objects
//    $this->cache = $registry->get( 'cache' );
//    $this->session = $registry->get( 'session' );
    $this->db = $registry->get( 'db' );
//    $this->log = $registry->get( 'log' );

  }

  //----------------------------------------------------------------------------
  // Get list of active payment methods related to country
  //----------------------------------------------------------------------------

  public function Get_Methods( $language_code = '', $country_code = '0' )
  {

    // Initialise payment methods data
    $payment_methods_data = array();

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`payment_method`.`id`, " .
        "`payment_method_description`.`name` AS name, " .
        "`payment_method_description`.`description` AS description " .
      "FROM " .
        "`payment_method` " .
      "LEFT JOIN " .
        "`payment_method_description` " .
      "ON " .
        "`payment_method_description`.`payment_method_id`=`payment_method`.`id` " .      
      "WHERE " . 
        "`payment_method`.`active`=1 AND " .
        "`payment_method_description`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`payment_method`.`name` " .
      "ASC";
        
    // Execute SQL query
    $reselt = $this->db->query( $sql );

    // Assign country data
    $payment_methods_data = $reselt->rows;

    // Return payment methods
    return( $payment_methods_data );

  }
  
  //----------------------------------------------------------------------------
  // Resolve list of active payment methods based on order
  //----------------------------------------------------------------------------

  public function Get_Sutable_Methods( $language_code = '', $country_code = '0', $amount = 0 )
  {

    // Initialise payment methods data
    $payment_methods_data = array();

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`payment_method`.`id`, " .
        "`payment_method_description`.`name` AS name, " .
        "`payment_method_description`.`description` AS description " .
      "FROM " .
        "`payment_method` " .
      "LEFT JOIN " .
        "`payment_method_description` " .
      "ON " .
        "`payment_method_description`.`payment_method_id`=`payment_method`.`id` " .      
      "WHERE " . 
        "`payment_method`.`active`=1 AND " .
        "`payment_method_description`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`payment_method`.`name` " .
      "ASC";
        
    // Execute SQL query
    $reselt = $this->db->query( $sql );

    // Assign country data
    $payment_methods_data = $reselt->rows;

    // Return payment methods
    return( $payment_methods_data );

  }
  
}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>