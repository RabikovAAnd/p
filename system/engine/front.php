<?php
final class Front
{

  // Protected properties
  protected $registry;
  protected $pre_action = array();
  protected $error;
  public $final_action;

  private $acl;
  private $customer;

  //----------------------------------------------------------------------------
  // Constructor
  //----------------------------------------------------------------------------

  public function __construct( $registry )
  {

    // Store registery object
    $this->registry = $registry;

    $this->acl = $this->registry->get( 'acl' );
    $this->customer = $this->registry->get( 'customer' );

  }

  //----------------------------------------------------------------------------
  // Add pre action method
  //----------------------------------------------------------------------------

  public function addPreAction( $pre_action )
  {

    // Store pre action
    $this->pre_action[] = $pre_action;

  }

  //----------------------------------------------------------------------------
  // Dispatch request method
  //----------------------------------------------------------------------------

  public function dispatch( $action, $error )
  {

    // Store error action
    $this->error = $error;

    // Iterate all pre actions
    foreach ( $this->pre_action as $pre_action )
    {

      // Execute pre action
      $result = $this->execute( $pre_action );

      // Check pre action execution result
      if ( $result )
      {

        // Store result as action
        $action = $result;

        // Terminate execution
        break;

      }

    }

    // Execute chain of the actions
    while ( $action )
    {

      // Execute action
      $action = $this->execute( $action );

    }

    // Execute final action
//    $this->execute( $this->final_action );

  }

  //----------------------------------------------------------------------------
  // Execute action method
  //----------------------------------------------------------------------------

  private function execute( $action )
  {

    // Get controller file name
    $controller_file_name = $action->Get_Controller_File();
    
    // Test for action file exists
    if ( file_exists( $controller_file_name ) === false )
    {

      //------------------------------------------------------------------------
      // ERROR: File not found
      //------------------------------------------------------------------------

      // Set error action as next action to execute
      $next_action = $this->error;

      // Clear stored error action
      $this->error = '';

    }
    else
    {

      //------------------------------------------------------------------------
      // Action file exists, continue processing
      //------------------------------------------------------------------------

      // Load controller file
      require_once( $controller_file_name );

      // Get controller class
      $class = $action->getClass();

      // Create controller object
      $controller = new $class( $this->registry );

      // Test for method of the action callable
      if ( is_callable( array( $controller, $action->getMethod() ) ) === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Method of the action not callable
        //----------------------------------------------------------------------

        // Set error action as next action to execute
        $next_action = $this->error;

        // Clear stored error action
        $this->error = '';

      }
      else
      {

        //----------------------------------------------------------------------
        // Method of the action callable
        //----------------------------------------------------------------------

        // Get endpoint name
        $endpoint_name = $action->Get_Endpoint_Name();

        // Add endpoint to ACL
        $this->acl->Add_Endpoint( $endpoint_name );

//$controller->log->Log_Debug( 'ENDPOINT: ' . $endpoint_name );

        // Test for customer login requered
        if ( $this->acl->Get_Check_Login( $endpoint_name ) === true )
        {

          //--------------------------------------------------------------------
          // Endpoint requered customer login
          //--------------------------------------------------------------------

          // Test for customer logged in
          if ( $this->customer->Is_Logged() === false )
          {

            //------------------------------------------------------------------------
            // ERROR: Customer not logged in
            //------------------------------------------------------------------------

//$controller->log->Log_Debug( $endpoint_name . ' Not logged' );

            // Redirect to login page
            $controller->response->Redirect( $controller->url->link( 'account/login', '', 'SSL' ) );

          }
          else
          {

            //------------------------------------------------------------------------
            // Customer logged in
            //------------------------------------------------------------------------
/*
//$controller->log->Log_Debug( $endpoint_name . ' Logged' );

            // Get check access permission status
            if ( $this->acl->Get_Check_Permission( $endpoint_name ) === true )
            {

//$controller->log->Log_Debug( $endpoint_name . ' Check permission');

            }
            else
            {

//$controller->log->Log_Debug( $endpoint_name . ' No check permission');

            }
*/

            // Get response object
            $response = $this->registry->get( 'response' );

            // Add stylesheet file
            $response->addStyle( $action->Get_Client_Stylesheet_File() );

            // Execute controller method and set next action to execute
            $next_action = call_user_func_array( array( $controller, $action->getMethod() ), $action->getArgs() );
            
            if ( $controller->Is_Template_Requered() === false )
            {

//              $output = call_user_func_array( array( $controller, 'Render1' ), array( '' ) );
              
//              $response->Set_HTTP_Output( $output );

            }
            else
            {

              if ( $action->getMethod() == 'index' )
              {

                $output = call_user_func_array( array( $controller, 'Render1' ), array( $action->Get_Template_File() ) );
              
                $response->Set_HTTP_Output( $output );
            
              }

            }
            
          }

        }
        else
        {

          //--------------------------------------------------------------------
          // Endpoint not requered customer login
          //--------------------------------------------------------------------

//$controller->log->Log_Debug( $endpoint_name . ' Not needed' );

          // Get response object
          $response = $this->registry->get( 'response' );

          // Add stylesheet file
          $response->addStyle( $action->Get_Client_Stylesheet_File() );

          // Execute controller method and set next action to execute
          $next_action = call_user_func_array( array( $controller, $action->getMethod() ), $action->getArgs() );

          if ( $controller->Is_Template_Requered() === false )
          {

//            $output = call_user_func_array( array( $controller, 'Render1' ), array( '' ) );
              
//            $response->Set_RAW_Output( $output );

          }
          else
          {

            if ( $action->getMethod() == 'index' )
            {

              $output = call_user_func_array( array( $controller, 'Render1' ), array( $action->Get_Template_File() ) );
              
              $response->Set_HTTP_Output( $output );
            
            }

          }

        }

      }

    }

    // Return next action to execute
    return ( $next_action );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>