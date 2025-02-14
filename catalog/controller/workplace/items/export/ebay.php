<?php
class ControllerWorkplaceItemsExportEbay extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {
    // Load messages
    $this->messages->Load($this->data, 'workplace', 'items_export_ebay', 'index', $this->language->Get_Language_Code());

    //--------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle('');
    $this->response->setDescription('');
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