<?php
class ControllerApiFunctionblockgroup extends Controller
{

  //----------------------------------------------------------------------------
  // Default index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Local variables
    $json = array();

    // Set error code
    $json[ 'return_code' ] = false;
    $json[ 'tocken' ] = 'XXX';

    // Add headers
    $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 400 Bad Request' );

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function group()
  {

    // Local variables
    $json = array();

    // Request method decoder
    switch ( $this->request->server[ 'REQUEST_METHOD' ] )
    {

      // GET request
      case 'GET':
      {

        // Extract request data
        $guid = $this->request->get[ 'guid' ];

        // Load model
        $this->load->model( 'api/data' );

        // Get data from DB
        $json[ 'data' ] = $this->model_api_data->Get_Function_Block_Group( $guid );

        $json[ 'return_code' ] = true;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 200 OK' );

        // Leave decoder
        break;

      }

      // POST request
      case 'POST':
      {

        $json[ 'return_code' ] = false;

        // Extract request data
        $guid = $this->request->get[ 'guid' ];

        // Load model
        $this->load->model( 'api/data' );

        // Get data from DB
        $json[ 'data' ] = $this->model_api_data->Get_Function_Block_Group( $guid );

        $json[ 'return_code' ] = true;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 200 OK' );

        // Leave decoder
        break;

      }

      // Other requests
      default:
      {

        $json[ 'return_code' ] = false;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 400 Bad Request' );

        // Leave decoder
        break;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function groups()
  {

    // Local variables
    $json = array();

    // Request method decoder
    switch ( $this->request->server[ 'REQUEST_METHOD' ] )
    {

      // GET request
      case 'GET':
      {

        // Load model
        $this->load->model( 'api/data' );

        // Get data from DB
        $json[ 'data' ] = $this->model_api_data->Get_Function_Block_Groups();

        $json[ 'return_code' ] = true;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 200 OK' );

        // Leave decoder
        break;

      }

      // POST request
      case 'POST':
      {

        $json[ 'return_code' ] = false;

        // Load model
        $this->load->model( 'api/data' );

        // Get data from DB
        $json[ 'data' ] = $this->model_api_data->Get_Function_Block_Groups();

        $json[ 'return_code' ] = true;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 200 OK' );

        // Leave decoder
        break;

      }

      // Other requests
      default:
      {

        $json[ 'return_code' ] = false;
        $json[ 'tocken' ] = 'XXX';

        // Add headers
        $this->response->Add_Header( $this->request->server[ 'SERVER_PROTOCOL' ] . '/1.1 400 Bad Request' );

        // Leave decoder
        break;

      }

    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

  //----------------------------------------------------------------------------

  public function test()
  {

    $json = array();

    $json[ 'success' ] = false;
    $json[ 'error' ] = "Item not found.";

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>