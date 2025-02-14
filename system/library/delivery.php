<?php
class Delivery
{

  //----------------------------------------------------------------------------
  // Private variables
  //----------------------------------------------------------------------------

//  private $cache;
  private $db;
//  private $log;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store links to objects
//    $this->cache = $registry->get( 'cache' );
    $this->db = $registry->get( 'db' );
//    $this->log = $registry->get( 'log' );

  }

  //----------------------------------------------------------------------------
  // Get forwarder information method
  //----------------------------------------------------------------------------

  public function Get_Forwarders( $language_code = '' )
  {
    
    // Initialise forwarders data
    $forwarders_data = array();

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`delivery_method_groups`.`id`, " .
        "`delivery_method_groups`.`name` AS name, " .
        "`delivery_method`.`description` AS description, " .
        "`delivery_method_groups`.`description` AS description, " .
        "`delivery_method_groups`.`image_type` AS image_type, " .
        "`delivery_method_groups`.`image_data` AS image_data " .
      "FROM " .
        "`delivery_method_groups` " .
//      "LEFT JOIN " .
//        "`delivery_method_description` " .
//      "ON " .
//        "`delivery_method_description`.`delivery_method_id`=`delivery_method`.`id` " .      
      "WHERE " . 
        "`delivery_method_groups`.`active`=1 " .
//        "`delivery_method_groups`.`active`=1 AND " .
//        "`delivery_method_description`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`delivery_method_groups`.`name` " .
      "ASC";

    // Execute SQL query
    $forwarders = $this->db->query( $sql );

    // Assign forwarders data
    $forwarders_data = $forwarders->rows;

    // Return forwarders
    return( $forwarders_data );

  }
  
  //----------------------------------------------------------------------------
  // Get list of active delivery methods related to country
  //----------------------------------------------------------------------------

  public function Get_Methods( $language_code = '', $forwarder_id = 0, $pick_country_code = '', $destination_country_code = '' )
  {

    // Initialise delivery methods data
    $delivery_methods_data = array();

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`delivery_method`.`id`, " .
        "`delivery_method`.`name` AS name, " .
        "`delivery_method`.`description` AS description, " .
        "`delivery_method`.`tracking` AS tracking, " .
        "`delivery_method`.`delivery_time_minimum` AS delivery_time_minimum, " .
        "`delivery_method`.`delivery_time_maximum` AS delivery_time_maximum, " .
        "`delivery_method`.`price` AS price, " .
        "`delivery_method`.`total` AS total, " .
        "`delivery_method`.`currency_code` AS currency_code " .        
      "FROM " .
        "`delivery_method` " .
//      "LEFT JOIN " .
//        "`delivery_method_description` " .
//      "ON " .
//        "`delivery_method_description`.`delivery_method_id`=`delivery_method`.`id` " .      
      "WHERE " . 
        "`delivery_method`.`forwarder_id`=" . (int)$forwarder_id . " AND " .
        "`delivery_method`.`active`=1 " .
//        "`delivery_method_description`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`delivery_method`.`name` " .
      "ASC";
        
    // Execute SQL query
    $reselt = $this->db->query( $sql );

    // Assign delivery methods data
    $delivery_methods_data = $reselt->rows;

    // Return delivery methods
    return( $delivery_methods_data );

  }
  
  //----------------------------------------------------------------------------
  // Resolve list of active delivery methods based on order
  //----------------------------------------------------------------------------

  public function Get_Sutable_Methods( $language_code = '', $pick_country_code = '', $destination_country_code = '', $amount = 0 )
  {

    // Initialise delivery methods data
    $delivery_methods_data = array();

    // Compose SQL query
    $sql = 
      "SELECT " .
        "`delivery_method`.`id`, " .
        "`delivery_method`.`name` AS name, " .
        "`delivery_method`.`description` AS description, " .
        "`delivery_method`.`tracking` AS tracking, " .
        "`delivery_method`.`delivery_time_minimum` AS delivery_time_minimum, " .
        "`delivery_method`.`delivery_time_maximum` AS delivery_time_maximum, " .
        "`delivery_method`.`price` AS price, " .
        "`delivery_method`.`total` AS total, " .
        "`delivery_method`.`currency_code` AS currency_code " .        
      "FROM " .
        "`delivery_method_to_country` " .
      "LEFT JOIN " .
        "`delivery_method` " .
      "ON " .
        "`delivery_method`.`id`=`delivery_method_to_country`.`delivery_method_id` " .      
//      "LEFT JOIN " .
//        "`delivery_method_description` " .
//      "ON " .
//        "`delivery_method_description`.`delivery_method_id`=`delivery_method`.`id` " .      
      "WHERE " . 
        "`delivery_method`.`active`=1 AND " .
        "`delivery_method_to_country`.`pick_country_code`='" . $pick_country_code . "' " .
//        "`delivery_method_description`.`language_code`='" . $language_code . "' " .
      "ORDER BY " .
        "`delivery_method`.`name` " .
      "ASC";
        
    // Execute SQL query
    $delivery_methods = $this->db->query( $sql );

    // Assign delivery metods data
    $delivery_methods_data = $delivery_methods->rows;

    // Return delivery methods
    return( $delivery_methods_data );

  }
  
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>