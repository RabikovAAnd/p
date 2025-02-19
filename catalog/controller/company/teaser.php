<?php  
class ControllerCompanyTeaser extends Controller 
{
  
  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

	protected function index() 
	{
    
    // Load messages
    $this->messages->Load( $this->data, 'company', 'teaser', 'index', $this->language->Get_Language_Code() );
		
//    // Load model
//		$this->load->model( 'company/company' );

    // Load model
		$this->load->model( 'projects/projects' );

    //--------------------------------------------------------------------------
    // About company section
    //--------------------------------------------------------------------------

    //! @todo ANVILEX KM: Get data from database
    $this->data[ 'company_teaser_image_hint' ] = '';
    $this->data[ 'company_teaser_about_text' ] = 'Seit der Gründung von ANVILEX im Jahr 2009 wächst das Unternehmen zusammen mit seinen Kunden, sammelt Erfahrungen und baut einen guten Ruf für die Bereitstellung hochwertiger Dienstleistungen, Lösungen und Produkte im Bereich der Stromumwandlung auf.';

    //--------------------------------------------------------------------------
    // Company projects section
    //--------------------------------------------------------------------------

    $this->data[ 'company_teaser_projects_list' ] = $this->model_projects_projects->Get_Teaser_Projects();
    		
    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add CSS file to document
//    $this->response->addStyle( 'catalog/view/stylesheet/company/teaser.css' );
		
		// Render page
//		$this->Render( 'company/teaser.tpl' );
		
	}
	
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>