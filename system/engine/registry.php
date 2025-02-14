<?php
final class Registry
{

  // Retistery data storage
  private $data = array();

  //----------------------------------------------------------------------------
  // Get value by given key method
  //----------------------------------------------------------------------------

  public function get( $key )
  {
    
    // Return value
    return ( isset( $this->data[ $key ] ) ? $this->data[ $key ] : null );
  
  }

  //----------------------------------------------------------------------------
  // Set value by given key method
  //----------------------------------------------------------------------------

  public function set( $key, $value )
  {
    
    // Store value
    $this->data[ $key ] = $value;
  
  }

  //----------------------------------------------------------------------------
  // Has a value given by a key method
  //----------------------------------------------------------------------------

  public function has( $key )
  {
    
    // Return status
    return isset( $this->data[ $key ] );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>