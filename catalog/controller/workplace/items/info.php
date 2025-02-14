<?php
class ControllerWorkplaceItemsInfo extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page

    }
    else
    {

      //------------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Load messages
      $this->messages->Load( $this->data, 'workplace', 'item', 'index', $this->language->Get_Language_Code() );

      // Get item guid
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      //----------------------------------------------------------------------
      // Item general data
      //----------------------------------------------------------------------

      // Load data models
      $this->load->model( 'items/items' );
      $this->load->model( 'items/properties' );
      $this->load->model( 'items/images' );
      $this->load->model( 'items/subitems/subitems' );
      $this->load->model( 'items/subitems/alternatives' );
      $this->load->model( 'properties/properties' );

      // Get item information
      $this->data[ 'item' ] = $this->model_items_items->Get_Information( $item_guid );

      //! @todo ANVILEX KM: Check for item exists.

      // Get item description
      //! @todo ANVILEX KM: Better to integrate description in $this->model_items_items->Get_Information( $item_guid ) request.
      $this->data[ 'item' ][ 'description' ] = $this->model_items_items->Get_Description( $item_guid, $this->language->Get_Language_Code() )[ 'description' ];

      // Get images
      $images = $this->model_items_images->Get_Item_Images( $item_guid );

      if( count( $images ) <= 0 )
      {

        //----------------------------------------------------------------------
        // No images linked to item
        //----------------------------------------------------------------------

      }
      else
      {

        //----------------------------------------------------------------------
        // Process main image
        //----------------------------------------------------------------------

        // Create main image object
        $main_image = new Image();
        $main_image->Create_From_String( $images[ 0 ][ 'data' ] );

        // Resize main image
        $main_image->resize( 300, 300, 'w' );

        // Get main image information
        $main_image_info = $main_image->Get_Info();

        // Set main image data
        $this->data[ 'item' ][ 'main_image' ] = array(

          'image_type' => $main_image_info[ 'mime' ],
          'image_data' => $main_image->Get_Encoded()
        );

        // Destroy main image object
        unset( $main_image );

        // Test for other images
        if( count( $images ) > 1 )
        {

          // Iterate over other images
          foreach ( array_slice( $images, 1 ) as $image )
          {

            // Create gallery image object
            $gallery_image = new Image();
            $gallery_image->Create_From_String( $image[ 'data' ] );

            // Resize gallery image
            $gallery_image->resize( 150, 150, 'w' );

            // Get gallery image information
            $gallery_image_info = $gallery_image->Get_Info();

            // Set gallery image data
            $this->data[ 'item' ][ 'images' ][] = array(
              'image_type' => $gallery_image_info[ 'mime' ],
              'image_data' => $gallery_image->Get_Encoded()
            );

            // Destroy main image object
            unset( $gallery_image );

          }

        }

      }
/*
      // Get item pictures
      $item_picture = $this->model_items_items->Get_Pictures( $item_guid );

      // Set pictures data
      $product_data[ 'product_image_name' ] = $product['mpn'];
      $product_data[ 'product_image_link' ] = ($prodict_image['valid'] === false) ? '' : 'data:' . $prodict_image['type'] . ';base64, ' . base64_encode($prodict_image['data']);
*/
      // Get favorite item status
      $this->data[ 'item' ][ 'favorite' ] = $this->model_items_items->Is_In_Favorites( $this->customer->Get_GUID(), $item_guid );

      // Compose links
      $this->data[ 'add_item_image_button_href' ] = $this->url->link( 'workplace/items/images/add', 'guid=' . $item_guid, 'SSL' );
      $this->data[ 'export_ebay_item_button_href' ] = $this->url->link( 'workplace/items/export/ebay', 'guid=' . $item_guid, 'SSL' );
      $this->data[ 'clone_item_button_href' ] = $this->url->link( 'workplace/items/create', 'guid=' . $item_guid, 'SSL' );
      $this->data[ 'edit_item_button_href' ] = $this->url->link( 'workplace/items/edit', 'guid=' . $item_guid, 'SSL' );
      $this->data[ 'add_item_to_favorites_button_href' ] = $this->url->link( 'workplace/favorites/items/add/add_to_favorites', '', 'SSL' );
      $this->data[ 'remove_item_from_favorites_button_href' ] = $this->url->link( 'workplace/favorites/items/remove/remove_from_favorites', '', 'SSL' );

      //----------------------------------------------------------------------
      // Item properties
      //----------------------------------------------------------------------

      // Initialise properties groups data section
      $this->data[ 'groups' ] = array();

      // Set properties groups
      $groups= $this->model_items_properties->Get_Properties_Groups( $this->language->Get_Language_Code() );

      // Get item properties
      $properties = $this->model_items_properties->Get_Item_Properties( $item_guid );

      // Process item properties
      foreach ( $properties as $property )
      {

        // Get item property data
        $property_data = $this->model_properties_properties->Get_Property_Information( $property[ 'property_guid' ], $this->language->Get_Language_Code() );

        // Set property data
        $this->data[ 'groups' ][ $property_data[ 'group_guid' ] ][ 'property_data' ][]= array(
          'element_href' => 'property' . $property[ 'property_guid' ],
          'property_guid' => $property[ 'property_guid' ],
          'group_guid' => $property_data[ 'group_guid' ],
          'name' => $property_data[ 'name' ],
          'value' => $property[ 'value' ],
          'units_guid' => $property_data[ 'units_guid' ],
          'description' => $property_data[ 'description' ],
          'edit_button_href' => $this->url->link( 'workplace/items/properties/edit', 'item_guid=' .  $item_guid.'&property_guid=' . $property[ 'property_guid' ], 'SSL' ),              
          'remove_button_href' => $this->url->link( 'workplace/items/properties/remove', '', 'SSL' )              
        );

        // Test for property group name not set
        if( isset( $this->data[ 'groups' ][ $property_data[ 'group_guid' ] ][ 'name' ] ) === false )
        {

          $this->data[ 'groups' ][ $property_data[ 'group_guid' ] ][ 'group_data' ] = $this->model_items_properties->Get_Group_Data( $property_data[ 'group_guid' ], $this->language->Get_Language_Code() );

        }

      }

      // Properties menu links
      $this->data[ 'add_property_button_href' ] =$this->url->link( 'workplace/items/properties/add','item_guid=' . $item_guid, 'SSL' );

      // Purchase menu links
      $this->data[ 'purchase_button_href' ] =$this->url->link( 'workplace/items/warehouses/add','item_guid=' . $item_guid, 'SSL' );

      //----------------------------------------------------------------------
      // Item subitems
      //----------------------------------------------------------------------

      // Test for non atomic item
      if ( $this->data[ 'item' ][ 'atomic_item' ] === false )
      {

        //--------------------------------------------------------------------
        // Item is non atomic
        //--------------------------------------------------------------------

        // Initialise item subitems data section
        $this->data[ 'subitems' ] = array();

        // Get item subitems
        $subitems = $this->model_items_subitems_subitems->Get_Item_Subitems( $item_guid );
       
        // Test return code for any error
        if ( $subitems[ 'return_code' ] === false )
        {

          //--------------------------------------------------------------------
          // ERROR: Get item subitems failed
          //--------------------------------------------------------------------

          //! @todo ANVILEX KM: Redirect to error page

        }
        else
        {
          // Process item subitems
          foreach ( $subitems['data'] as $subitem )
          {

            // Get item subitem data
            $subitem_data = $this->model_items_items->Get_Information( $subitem[ 'subitem_guid' ] );

            // Init item subitem alternative information
            $alternatives_info = array();
            
            // Get subitem alternatives data
            $alternatives = $this->model_items_subitems_alternatives->Get_Subitem_Alternatives( $subitem[ 'subitem_index_guid' ] );
            
            // Process item subitem alternative information
            foreach ( $alternatives as $alternative )
            {
            
              $alternative_data = $this->model_items_items->Get_Information( $alternative[ 'guid']);
              
              // Set subitem alternative information
              $alternatives_info[] = array(
                'item_id' => $alternative_data[ 'item_id' ],
                'mpn' => $alternative_data[ 'mpn' ],
                'manufacturer_name' => $alternative_data[ 'manufacturer_name' ],
                'href' => $this->url->link( 'workplace/items/info', 'guid=' . $alternative_data[ 'guid' ], 'SSL' )
              );
            
            }

            // Set subitem data
            $this->data[ 'subitems' ][] = array(
              'element_href' => 'subitem' . $subitem[ 'subitem_index_guid' ],
              'subitem_index_guid' => $subitem[ 'subitem_index_guid' ],
              'subitem_guid' => $subitem[ 'subitem_guid' ],
              'designator' => $subitem[ 'designator' ],
              'quantity' => $subitem[ 'quantity' ],
              'item_id' => $subitem_data[ 'item_id' ],
              'mpn' => $subitem_data[ 'product_mpn' ],
              'manufacturer_name' => $subitem_data[ 'manufacturer_name' ],
              'subitem_href' => $this->url->link( 'workplace/items/info', 'guid=' . $subitem[ 'subitem_guid' ], 'SSL' ),
              'add_subitem_alternatives_button_href' => $this->url->link( 'workplace/items/subitems/alternatives/add', 'subitem_index_guid=' . $subitem[ 'subitem_index_guid' ], 'SSL' ),
              'edit_button_href' => $this->url->link( 'workplace/items/subitems/edit', 'subitem_index_guid=' . $subitem[ 'subitem_index_guid' ], 'SSL' ),
              'replace_button_href' => $this->url->link( 'workplace/items/subitems/replace', 'subitem_index_guid=' . $subitem[ 'subitem_index_guid' ] .'&current_subitem_guid=' . $subitem[ 'subitem_guid' ], 'SSL' ),
              'remove_button_href' => $this->url->link( 'workplace/items/subitems/remove', 'subitem_index_guid=' . $subitem[ 'subitem_index_guid' ], 'SSL' ),

              'alternatives'=> $alternatives_info
            );

          }
        }
        // Compose links
        $this->data[ 'subitems_export_bom_button_href' ] = $this->url->link( 'workplace/items/subitems/download', 'guid=' . $item_guid, 'SSL' );
        $this->data[ 'subitems_export_smt_button_href' ] = $this->url->link( 'workplace/items/subitems/download', 'guid=' . $item_guid, 'SSL' );
        $this->data[ 'subitems_import_button_href' ] = $this->url->link( 'workplace/items/subitems/import', 'item_guid=' . $item_guid, 'SSL' );
        $this->data[ 'subitem_add_button_href' ] =$this->url->link( 'workplace/items/subitems/add', 'item_guid=' . $item_guid, 'SSL' );

      }

      //----------------------------------------------------------------------
      // Process tasks
      //----------------------------------------------------------------------

      // Initialise tasks data section
      $this->data[ 'tasks' ] = array();

      // Load data model
      $this->load->model( 'tasks/tasks' );

      // Get tasks
      $tasks = $this->model_tasks_tasks->Get_Task_List_For_Item( $this->customer->Get_GUID(), $item_guid );

      // Process each task
      foreach ( $tasks as $task )
      {

        // Get task creator information
        $creator_data = $this->customer->Get_Contact_Information( $task[ 'creator_guid' ] );

        // Get task worker information
        $customer_data = $this->customer->Get_Contact_Information( $task[ 'customer_guid' ] );

        //--------------------------------------------------------------------
        // Process menu buttons activity
        //--------------------------------------------------------------------

        // Task status decoder
        switch( $task[ 'status' ] )
        {

          //----------------------------------------------------------------
          // Unconfirmed task
          //----------------------------------------------------------------

          case 'unconfirmed':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = true;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = true;

            $confirm_button_enabled = true;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // New task
          //----------------------------------------------------------------

          case 'new':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = true;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //------------------------------------------------------------------
          // Wait for processing task
          //------------------------------------------------------------------

          case 'wait_for_processing':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = true;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = true;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Processing task
          //----------------------------------------------------------------

          case 'processing':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = true;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = true;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Paused task
          //----------------------------------------------------------------

          case 'paused':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = true;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Complete task
          //----------------------------------------------------------------

          case 'complete':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = true;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Wait for verification task
          //----------------------------------------------------------------

          case 'wait_for_verification':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = true;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Verification task
          //----------------------------------------------------------------

          case 'verification':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = true;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = true;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = true;
            $decline_button_enabled = true;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Wait for fixing task
          //----------------------------------------------------------------

          case 'wait_for_fixing':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = true;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Closed task
          //----------------------------------------------------------------

          case 'closed':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Discarded task
          //----------------------------------------------------------------

          case 'discarded':
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = false;
            $edit_button_enabled = false;
            $start_button_enabled = false;
            $done_button_enabled = false;
            $observe_button_enabled = false;
            $delegate_button_enabled = false;
            $move_button_enabled = false;
            $close_button_enabled = false;
            $discard_button_enabled = false;
            $confirm_button_enabled = false;
            $assign_developer_button_enabled = false;
            $assign_verifier_button_enabled = false;
            $verify_button_enabled = false;
            $accept_button_enabled = false;
            $pause_button_enabled = false;
            $resume_button_enabled = false;
            $reopen_button_enabled = false;
            $decline_button_enabled = false;
            $reject_developer_button_enabled = false;

            // Leave status decoder
            break;

          }

          //----------------------------------------------------------------
          // Other statuses
          //----------------------------------------------------------------

          default:
          {

            // ANVILEX KM: Implement logic
            $delete_button_enabled = true;
            $confirm_button_enabled = true;
            $edit_button_enabled = true;
            $start_button_enabled = true;
            $done_button_enabled = true;
            $observe_button_enabled = true;
            $delegate_button_enabled = true;
            $move_button_enabled = true;
            $close_button_enabled = true;
            $discard_button_enabled = true;
            $assign_developer_button_enabled = true;
            $assign_verifier_button_enabled = true;
            $verify_button_enabled = true;
            $accept_button_enabled = true;
            $pause_button_enabled = true;
            $resume_button_enabled = true;
            $reopen_button_enabled = true;
            $decline_button_enabled = true;
            $reject_developer_button_enabled = true;

            // Leave status decoder
            break;

          }

        }

        //------------------------------------------------------------------

        // Compose task information
        $this->data['tasks'][] = array(
          'id' => $task[ 'id' ],
          'header' => $task[ 'header' ],
          'description' => $task[ 'description' ],
          'status' => $task[ 'status' ],
          'priority' => $this->model_tasks_tasks->Get_Priority_Name( $task[ 'priority' ], $this->language->Get_Language_Code() ),
          'lead_time' => $task[ 'lead_time' ],
          'creator' => $creator_data[ 'lastname' ] . " " . $creator_data[ 'firstname' ],
          'customer' =>  $customer_data[ 'lastname' ] . " " . $customer_data[ 'firstname' ],
          'edit_task_href' => $this->url->link( 'tasks/edit_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'confirm_task_href' => $this->url->link( 'tasks/confirm_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'discard_task_href' => $this->url->link( 'tasks/discard_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'start_task_href' => $this->url->link( 'tasks/start_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'assign_developer_task_href' => $this->url->link( 'tasks/assign_developer_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'assign_verifier_task_href' => $this->url->link( 'tasks/assign_verifier_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'verify_task_href' => $this->url->link( 'tasks/verify_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'reject_task_href' => $this->url->link( 'tasks/reject_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'accept_task_href' => $this->url->link( 'tasks/accept_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'done_task_href' => $this->url->link( 'tasks/done_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'pause_task_href' => $this->url->link( 'tasks/pause_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'resume_task_href' => $this->url->link( 'tasks/resume_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'reopen_task_href' => $this->url->link( 'tasks/reopen_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'decline_task_href' => $this->url->link( 'tasks/decline_task', 'id=' . $task[ 'id' ], 'SSL' ),
          'item_guid' =>$task[ 'item_guid' ],
          'item_href' => $this->url->link( 'workplace/items/list', 'guid=' . $task[ 'item_guid' ], 'SSL' ),
          'item_mpn' =>$this->model_items_items->Get_Information( $task[ 'item_guid' ])[ 'mpn' ],
          'create_date' => $task[ 'create_date' ],
          'date_start' => $task[ 'date_start' ],
          'deadline' => $task[ 'deadline' ],
          'delete_button_enabled' => $delete_button_enabled,
          'reject_button_enabled' => $reject_developer_button_enabled,
          'assign_developer_button_enabled' => $assign_developer_button_enabled,
          'assign_verifier_button_enabled' => $assign_verifier_button_enabled,
          'confirm_button_enabled' => $confirm_button_enabled,
          'edit_button_enabled' => $edit_button_enabled,
          'start_button_enabled' => $start_button_enabled,
          'done_button_enabled' => $done_button_enabled,
          'observe_button_enabled' => $observe_button_enabled,
          'delegate_button_enabled' => $delegate_button_enabled,
          'move_button_enabled' => $move_button_enabled,
          'close_button_enabled' => $close_button_enabled,
          'verify_button_enabled' => $verify_button_enabled,
          'accept_button_enabled' => $accept_button_enabled,
          'pause_button_enabled' => $pause_button_enabled,
          'resume_button_enabled' => $resume_button_enabled,
          'reopen_button_enabled' => $reopen_button_enabled,
          'decline_button_enabled' => $decline_button_enabled,
          'discard_button_enabled' => $discard_button_enabled

        );

      }

      // Task menu links
      $this->data[ 'add_task_href' ] = $this->url->link( 'tasks/add_task', 'item_guid=' . $item_guid, 'SSL' );

      //----------------------------------------------------------------------
      // Documents linked to item
      //----------------------------------------------------------------------

      // Initialise documents section
      $this->data[ 'documents' ] = array();

      // Get item linked documents
      $documents = $this->model_items_items->Get_Documents( $item_guid );

      // Process item linked documents
      foreach ( $documents as $document )
      {

        // Set document data
        $this->data[ 'documents' ][] = array(
          'element_href' => 'document' . $document[ 'guid' ],
          'name' => $document[ 'name' ],
          'document_guid' => $document[ 'guid' ],
          'date' => $document[ 'date' ],
          'number' => $document[ 'number' ],
          'version' => $document[ 'version' ],
          'revision' => $document[ 'revision' ],
          'href' => $this->url->link( 'documents/download', 'document_guid=' . $document[ 'guid' ], 'SSL' ),
          'remove_button_href' => $this->url->link( 'workplace/items/documents/remove', '', 'SSL' )
        );

      }

      // Documents menu links
      $this->data[ 'add_document_button_href' ] = $this->url->link( 'documents/add','item_guid=' . $item_guid, 'SSL' );

      //----------------------------------------------------------------------
      // Item suppliers
      //----------------------------------------------------------------------

      // Initialise item suppliers data section
      $this->data[ 'suppliers' ] = array();

      // Load data models
      $this->load->model( 'customers/suppliers' );

      // Get item subitems
      $suppliers = $this->model_customers_suppliers->Get_Item_Suppliers( $item_guid );

      // Process item subitems
      foreach ( $suppliers as $supplier )
      {

        // Get item subitem data
        $supplier_data = $this->customer->Get_Contact_Information( $supplier[ 'supplier_guid' ] );

        // Set subitem data
        $this->data[ 'suppliers' ][] = array(
          'element_href' => 'supplier' . $supplier_data[ 'guid' ],
          'supplier_guid' => $supplier_data[ 'guid' ],
          'name' => $supplier_data[ 'firstname' ],
          'lastname' => $supplier_data[ 'lastname' ],
          'company_name' => $supplier_data[ 'company_name' ],
          'manufacturer' => $supplier_data[ 'manufacturer' ],
          'email' => $supplier_data[ 'email' ],
          'phone' => $supplier_data[ 'phone' ],
          'supplier_href' => $this->url->link( 'workplace/customers/info', 'guid=' . $supplier_data[ 'guid' ], 'SSL' ),
          'remove_button_href' => $this->url->link( 'workplace/items/suppliers/remove', '', 'SSL' ),
        );

      }

      // Supplier menu links
      $this->data[ 'add_supplier_button_href' ] = $this->url->link( 'workplace/items/suppliers/add', 'item_guid=' . $item_guid, 'SSL' );

    }

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->data[ 'item' ][ 'product_mpn' ] );
    $this->response->setDescription( $this->data[ 'item' ][ 'description' ] );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'workplace/menu',
      'common/header'
    );

  }


  //----------------------------------------------------------------------------
  // Delete task
  //----------------------------------------------------------------------------

  public function Delete_Task()
  {

    // Init json data
    $json = array();

    // Test for customer logged in
    if ( $this->customer->Is_Logged() === false )
    {

      //------------------------------------------------------------------------
      // ERROR: Customer not logged in
      //------------------------------------------------------------------------

      // Set redirect link
      $json['redirect_url'] = $this->url->link('account/login', '', 'SSL');

      // Set error code
      $json['return_code'] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // Customer logged in
      //------------------------------------------------------------------------

      // Set error code
      //! @todo ANVILEX KM: Clean code
      $json['return_code'] = false;

      if ( $this->request->Is_POST_Parameter_Exists( 'task_id' ) )
      {

        // Load data model
        $this->load->model( 'projects/projects' );

        $json[ 'return_code' ] = $this->model_tasks_tasks->Delete_Task( $this->request->Get_POST_Parameter_As_Integer( 'task_id' ) );

      }

    }

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>