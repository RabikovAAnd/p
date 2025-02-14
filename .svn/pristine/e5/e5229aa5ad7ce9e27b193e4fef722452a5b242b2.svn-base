<?php
class Template 
{
	
  public $data = array();

  public $messages = array();

  //----------------------------------------------------------------------------
  // Render template
  //----------------------------------------------------------------------------

	public function Render( $filename ) 
  {

    // Compose full template filename
		$file = DIR_TEMPLATE . $filename;

    // Test for template file exists
		if ( file_exists( $file ) ) 
    {

      //------------------------------------------------------------------------
      // Template file found
      //------------------------------------------------------------------------

      // Extract template messages
      extract( $this->messages );

      // Extract template data
			extract( $this->data );

      // Start output buffering
      ob_start();

      // Include tenplate file
	  	include( $file );

      // Clear output buffer
			$content = ob_get_clean();

      // Return rendered content
      return( $content );

    } 
    else 
    {
      
      //------------------------------------------------------------------------
      // ERROR: Template file not found
      //------------------------------------------------------------------------

			trigger_error('Error: Could not load template ' . $file . '!');

//      exit();				

      // Return empty content
      return( '' );

    }
    
	}

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>