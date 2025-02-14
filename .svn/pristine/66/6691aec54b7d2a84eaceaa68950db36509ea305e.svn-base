<?php
abstract class Model
{

  // Registery object
  protected $registry;

  // Database object
  protected $database;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------
  
  public function __construct( $registry, $database = '' )
  {

    // Store registery object
    $this->registry = $registry;

    // Store database object
    $this->database = $this->registry->get( $database );

  }

  //----------------------------------------------------------------------------
  // Get value by given key method
  //----------------------------------------------------------------------------

  public function __get( $key )
  {

    // Return value
    return( $this->registry->get( $key ) );

  }

  //----------------------------------------------------------------------------
  // Set value by given key method
  //----------------------------------------------------------------------------

  public function __set( $key, $value )
  {

    // Store value
    $this->registry->set( $key, $value );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>