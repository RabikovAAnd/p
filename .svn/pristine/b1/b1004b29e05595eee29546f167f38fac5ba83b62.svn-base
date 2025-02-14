<?php
class ControllerWorkplacePropertiesGroupsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {


    // Test for Group GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) {

      //----------------------------------------------------------------------
      // ERROR: Group GUID parameter not found
      //----------------------------------------------------------------------


    } else {

      //------------------------------------------------------------------------
      // Group GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'properties_info', 'index', $this->language->Get_Language_Code());

      // Get group guid
      $group_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      //----------------------------------------------------------------------
      // Group general data
      //----------------------------------------------------------------------

      // Load data models
      $this->load->model('properties/properties');

      // Get group information
      $this->data['group'] = $this->model_properties_properties->Get_Group_Information($group_guid, $this->language->Get_Language_Code());
      
      // Get properties information
      $properties = $this->model_properties_properties->Get_Group_Properties($group_guid, $this->language->Get_Language_Code());

      if (count($properties) > 0) {
        // Process group properties
        foreach ($properties as $property) {
          // Set property data
          $this->data['properties'][] = array(
            'element_href' => 'property' . $property['guid'],
            'guid' => $property['guid'],
            'units_guid' => $property['units_guid'],
            'unit' => $this->units->Get_Unit_Group_Info($property['units_guid']),
            'href' =>  $this->url->link( 'workplace/properties/info', 'guid=' . $property[ 'guid' ], 'SSL' ), 
            'name' => $property['name'],
            'description' => $property['description'],

            'status' => $property[ 'status' ],
            'edit_button_href' => $this->url->link( 'workplace/properties/edit', 'guid=' .$property['guid'], 'SSL' ),                 
            'remove_button_href' => $this->url->link( 'workplace/properties/remove/Remove', 'guid=' .$property['guid'], 'SSL' )              
          );


        }
      }

      //set links
      $this->data['edit_button_href'] = $this->url->link('workplace/properties/groups/edit', 'guid=' . $group_guid, 'SSL');
      $this->data['add_property_button_href'] = $this->url->link('workplace/properties/add', 'guid=' . $group_guid, 'SSL');
    }

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle($this->messages->Get_Message('document_title_text'));
    $this->response->setDescription($this->messages->Get_Message('document_description_text'));
    $this->response->setKeywords('');
    $this->response->setRobots('index, follow');

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