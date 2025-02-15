<?php
class ControllerWorkplacePropertiesInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'property_info', 'index', $this->language->Get_Language_Code() );

    // Test for Group GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID('guid') === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Property GUID parameter not found
      //------------------------------------------------------------------------

    }
    else
    {

      //------------------------------------------------------------------------
      // Property GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get group guid
      $property_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //------------------------------------------------------------------------
      // Property general data
      //------------------------------------------------------------------------

      // Load data models
      $this->load->model( 'properties/properties' );

      // Get property information
      $this->data[ 'property' ] = $this->model_properties_properties->Get_Property_Information( $property_guid, $this->language->Get_Language_Code() );
      $this->data[ 'units' ] = $this->units->Get_Unit_Group_Info( $this->data[ 'property' ][ 'units_guid' ], $this->language->Get_Language_Code() );

      // Set links
      $this->data[ 'edit_button_href'] = $this->url->link( 'workplace/properties/edit', 'guid=' . $property_guid, 'SSL' );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>