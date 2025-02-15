<?php

class ControllerNewsSubscribe extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  protected function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'news', 'subscribe', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add CSS file to document
    $this->response->addStyle( 'catalog/view/stylesheet/news/teaser.css' );

    // Render page
//    $this->Render( 'news/subscribe.tpl' );

  }

  //----------------------------------------------------------------------------
  // Subscribe method
  //----------------------------------------------------------------------------

  public function add()
  {

    // Load messages
    $this->messages->Load( $this->data, 'news', 'subscribe', 'add', $this->language->Get_Language_Code() );
    $json[ 'return_code' ] = false;
    
    // Init json data
    $json = array();
    
    if (
      ($this->request->Is_POST_Parameter_Exists('email') === true ) &&
      ($this->request->Is_POST_Parameter_Exists('agreement') === true )
    )
    {
      
      if($this->request->Get_POST_Parameter_As_String('agreement') === 'false' )
      {
        $json[ 'error' ]['agreement'] = $this->data[ 'news_subscribe_agreement_error' ];
      }
      else
      {
        
        //Checking data for accuracy
        $req = $this->request->Post_Parameter_Is_Mail( 'email' );

        if ( $req[ 'check' ] )
        {

          // Load news model
          $this->load->model( 'news/news' );

          if ( $this->model_news_news->Is_Exists( $req[ 'response' ] ) )
          {

            // Set error code
            $json[ 'error' ] = array('email' => $this->data[ 'news_subscribe_already_subscribed_error' ] );

          }
          else
          {

            // Add subscriber
            $json[ 'return_code' ] = $this->model_news_news->Add_Subscriber( $req[ 'response' ] );

            $json['animation'] = [$this->data['news_subscribe_subscribe_button_text'], $this->data['news_subscribe_subscribe_button_success_text']];
          
          }

        }
        else
        {

          // Set error code
          $json[ 'error' ] = array('email' => $this->data[ 'news_subscribe_' . $req[ 'response' ] ] );

        }
      }   
    }

    // Encode and send json data
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of class
//------------------------------------------------------------------------------
?>