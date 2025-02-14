<?php
class ControllerWorkplaceCategoriesMove extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for Property GUID parameter exists
    if ($this->request->Is_GET_Parameter_GUID('guid') === false) {

      //----------------------------------------------------------------------
      // ERROR: Property GUID parameter not found
      //----------------------------------------------------------------------


    } else {

      //------------------------------------------------------------------------
      // Property GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load($this->data, 'workplace', 'categories_move', 'index', $this->language->Get_Language_Code());

      // Load models
      $this->load->model('categories/categories');
      $this->load->model('items/items');

      // Get Property guid
      $category_guid = $this->request->Get_GET_Parameter_As_GUID('guid');

      // Get current category information
      $this->data['current_category'] = $this->model_categories_categories->Get_Category($category_guid, $this->language->Get_Language_Code());
      $this->data['forbidden_category'] = array_merge([$category_guid], $this->Get_Children($category_guid));

      // Get category information
      $this->data['categories'] = $this->model_categories_categories->Get_Categories($this->language->Get_Language_Code());

       // Set links
       $this->data['move_button_href'] = $this->url->link('workplace/categories/move/Move', 'category_guid=' . $category_guid, 'SSL');
       $this->data['cancel_button_href'] =  $this->request->Get_Request_Referer();
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

  //----------------------------------------------------------------------------
  // Get category Children
  //----------------------------------------------------------------------------

  public function Get_Children($parent_guid)
  {
    // Load models
    $this->load->model('categories/categories');
    $children = $this->model_categories_categories->Get_Subcategories($parent_guid, $this->language->Get_Language_Code());
    $tree = [];
    if(count( $children)>0)
    {
      foreach( $children as $child )
      {
        $tree[] = $child['guid'];
        $tree = array_merge($tree, $this->Get_Children($child['guid'])) ;
      }
    }else{
      // $tree[] = $this->model_categories_categories->Get_Category($parent_guid, $this->language->Get_Language_Code());
    }
    return $tree;
  }


  //----------------------------------------------------------------------------
  // Move category
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  public function Move()
  {

    // Init json data
    $json = array();

    // Load messages
    $this->messages->Load($this->data, 'workplace', 'categories_move', 'Move', $this->language->Get_Language_Code());

    // Init customer data
    $data = array();

    // Clear request data valid sataus
    $request_data_valid = true;
      
   
    //------------------------------------------------------------------------
    // Category GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'category_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Category GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'guid' ] = $this->data['workplace_categories_move_' . 'category_guid' . '_error'];

      // Clear request data valid sataus
      $request_data_valid = false;

    }
    else
    {

      //----------------------------------------------------------------------
      // Category GUID parameter found
      //----------------------------------------------------------------------

      $data[ 'guid' ] = trim( $this->request->Get_GET_Parameter_As_GUID( 'category_guid' ) );

    }
  
    //------------------------------------------------------------------------
    // Parent category GUID
    //------------------------------------------------------------------------

    // Test for parameter exists
    if ( $this->request->Is_POST_Parameter_GUID( 'parent_guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Parent category GUID not found
      //----------------------------------------------------------------------

      // Set error message text
      $json[ 'error' ][ 'parent_guid' ] = $this->data['workplace_categories_move_' . 'parent_guid' . '_error'];

      // Clear request data valid status
      $request_data_valid = false;

    }
    else
    {
     
      //----------------------------------------------------------------------
      // Parent category GUID parameter found
      //----------------------------------------------------------------------

      $data[ 'parent_guid' ] = trim( $this->request->Get_POST_Parameter_As_GUID( 'parent_guid' ) );

    }

    if ($request_data_valid === true)
    {
      $this->data['forbidden_category'] = array_merge([ $data[ 'guid' ]], $this->Get_Children( $data[ 'guid' ]));
      if (in_array($data[ 'parent_guid' ], $this->data['forbidden_category'] )  )
      {
        $json[ 'error' ][ 'parent_guid' ] = $this->data['workplace_categories_move_' . 'parent_guid_not_valid' . '_error'];
        $request_data_valid = false;
      }else
      {
      //----------------------------------------------------------------------
      // Parent category GUID valid
      //----------------------------------------------------------------------
      }
    }
    
    
    //------------------------------------------------------------------------
    // Process data
    //------------------------------------------------------------------------

    // Is request data valid
    if ($request_data_valid === false) {

      //------------------------------------------------------------------------
      // ERROR: Parameters not valid
      //------------------------------------------------------------------------

      // Set error code
      $json['return_code'] = false;

    } else
    {

      //--------------------------------------------------------------------
      // Parameters present and valid
      //--------------------------------------------------------------------

      // Load data models
      $this->load->model('categories/categories');

      // Move Category
      $this->model_categories_categories->Move_Category($data);

      // Set redirect URL
      $json['redirect_url'] = $this->url->link('workplace/categories/info', 'guid=' . $data[ 'parent_guid' ], 'SSL');

      // Set success code
      $json['return_code'] = true;

    }

    // Encode and send json data
    $this->response->Set_Json_Output($json);

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>