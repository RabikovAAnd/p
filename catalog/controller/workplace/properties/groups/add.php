<?php
class ControllerWorkplacePropertiesGroupsAdd extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {


    // Load messages
    $this->messages->Load($this->data, 'workplace', 'add_group', 'index', $this->language->Get_Language_Code());

   // Set links
   $this->data['add_button_href'] = $this->url->link('workplace/properties/groups/add/Add', '', 'SSL');
   $this->data['cancel_button_href'] = $this->url->link('workplace/properties/groups/list', '', 'SSL');
   $languages =$this->language->Get_Languages();
   foreach($languages as $language) {
       // Set group languages data
       $this->data['groups_languages'][] = array(
        'id' => 'group_name_' . $language['code'],
        'label' => $this->data['workplace_add_group_' . $language['code'] . '_name_label'] ,
        'hint' => $this->data['workplace_add_group_'.$language['code'] . '_name_hint'] ,
        'placeholder' =>$this->data['workplace_add_group_'.$language['code'] . '_name_placeholder'] ,
      );
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

  //----------------------------------------------------------------------------
  // Add new group
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Add()
  {

    // Init json data
    $json = array();

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'add_group', 'add', $this->language->Get_Language_Code() );

      // Init customer data
      $data = array();

      // Clear request data valid status
      $request_data_valid = true;
      $languages =$this->language->Get_Languages();
      
      foreach($languages as $language) {
      //------------------------------------------------------------------------
      // Name
      //------------------------------------------------------------------------

      // Test for parameter exists
      if( $this->request->Is_POST_Parameter_Exists( 'group_name_'.  $language['code']) === false )
      {
        //----------------------------------------------------------------------
        // ERROR: Name parameter not found
        //----------------------------------------------------------------------

        // Set error message text
        $json[ 'error' ][ 'group_name_'. $language['code'] ] = $this->data[ 'workplace_add_group_' . 'group_name_'. $language['code'] . '_error' ];

        // Clear request data valid status
        $request_data_valid = false;

      }
      else
      {

        //----------------------------------------------------------------------
        // Name parameter found
        //----------------------------------------------------------------------

        // Store data
        $data[ 'group_name_' . $language['code'] ] = trim( $this->request->Get_POST_Parameter_As_String( 'group_name_' .  $language['code'] ) );

        // Test group name validity
        if (
          (utf8_strlen( $data[ 'group_name_' .  $language['code'] ] ) < 1 ) ||
          ( utf8_strlen( $data[ 'group_name_' .  $language['code'] ] ) > 255 )
        )
        {

          //--------------------------------------------------------------------
          // ERROR: Name invalid
          //--------------------------------------------------------------------

          // Set error message text
          $json[ 'error' ][ 'group_name_' .  $language['code'] ] = $this->data[ 'workplace_add_group_' . 'group_name_' .  $language['code'] . '_error' ];
          
          // Clear request data valid status
          $request_data_valid = false;

        }
        else
        {

          //--------------------------------------------------------------------
          // Name valid
          //--------------------------------------------------------------------

        }

      }
      }
     

    //------------------------------------------------------------------------
    // Category status
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_Boolean( 'status' ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Category status not found
      //------------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'status' ] = $this->data[ 'workplace_add_group_' . 'status' . '_error' ];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Category status parameter found
      //------------------------------------------------------------------------

      // Store category status
      $data[ 'status' ] = trim( $this->request->Get_POST_Parameter_As_Boolean( 'status' ) ) ? 'active' : 'inactive';

    }
    

      //------------------------------------------------------------------------
      // Process data
      //------------------------------------------------------------------------

      // Is request data valid
      if ( $request_data_valid === false )
      {

        //------------------------------------------------------------------------
        // ERROR: Parameters not valid
        //------------------------------------------------------------------------

        // Set error code
        $json[ 'return_code' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Parameters present and valid
        //--------------------------------------------------------------------

        // Generate group GUID
        $guid = UUID_V4_T1();

        // Load data models
        $this->load->model('properties/properties');

        // Create new group
        $this->model_properties_properties->Create_Group( $guid, $data );

        // Set redirect URL
        $json[ 'redirect_url' ]= $this->url->link( 'workplace/properties/groups/list', '', 'SSL' );

        // Set success code
        $json[ 'return_code' ] = true;

      }

//    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>