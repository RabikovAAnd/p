<?php
class ControllerWorkplacePropertiesGroupsList extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {


      //------------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'properties', 'index', $this->language->Get_Language_Code() );


      //----------------------------------------------------------------------
      // Item general data
      //----------------------------------------------------------------------

      // Load data models
      $this->load->model( 'items/properties' );



      // Compose links
      $this->data[ 'add_group_button_href' ] = $this->url->link( 'workplace/properties/groups/add', '', 'SSL' );
      //----------------------------------------------------------------------
      // Item properties
      //----------------------------------------------------------------------

      // Initialise properties groups data section
      $this->data[ 'groups' ] = array();

      // Set properties groups
      $groups= $this->model_items_properties->Get_Properties_Groups( $this->language->Get_Language_Code() );

    // Process item properties
      foreach (  $groups as $group )
      {

        // Set property data
        $this->data[ 'groups' ][]= array(
          'element_href' => 'group' . $group[ 'guid' ],
          'guid' => $group[ 'guid' ],
          'href' =>  $this->url->link( 'workplace/properties/groups/info', 'guid=' . $group[ 'guid' ], 'SSL' ), 
          'name' => $group[ 'name' ],
          'status' => $group[ 'status' ],
          'edit_button_href' => $this->url->link( 'workplace/properties/groups/edit',  'guid=' . $group[ 'guid' ], 'SSL' ),    
          'clone_button_href' => $this->url->link( 'workplace/properties/groups/clone', 'guid=' .$group['guid'], 'SSL' ),              
          'remove_button_href' => $this->url->link( 'workplace/properties/groups/remove/Remove',  'guid=' . $group[ 'guid' ] . '&remove=true' , 'SSL' )              
        );


      }

    

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
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