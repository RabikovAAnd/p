<?php

class ControllerCompanyContact extends Controller
{

  private $error = array();

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'contact', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );

    // Add style
    $this->response->addStyle( 'catalog/view/stylesheet/company/contact.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //----------------------------------------------------------------------------

  private function dataVerification()
  {
  }

  //----------------------------------------------------------------------------
  // Add message
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

  /**
    * @throws Exception
  */
  public function add()
  {

    // Init json data
    $json = array();

    $return_code = true;
    $error = array();

    // Load messages
    $this->messages->Load( $this->data, 'company', 'contact', 'add', $this->language->Get_Language_Code() );

    //------------------------------------------------------------------------

    // Test email parameter
    if ( $this->request->Is_POST_Parameter_Email( 'email' ) === false )
    {

      // Set error code
      $return_code = false;
      $error['email'] = $this->data[ 'company_contact_invalid_email_format_error' ];

    }
    else
    {

      $this->data[ 'email' ] = $this->request->Get_POST_Parameter_As_String( 'email' );

    }
/*
      $req = $this->request->Post_Parameter_Is_Mail( 'email' );

      // Set error code
      if (!$req['check'])
      {
        $this->error['email'] = $this->data['company_contact_' . $req['response']];
      }
*/

    //------------------------------------------------------------------------

    // Test for subject parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'subject' ) === false )
    {

      // Set error code
      $return_code = false;
      $error[ 'subject' ] = $this->data[ 'company_contact_empty_subject_error' ];

    }
    else
    {

      // Get subject
      $this->data[ 'subject' ] = trim( $this->request->Get_POST_Parameter_As_String( 'subject' ) );

      // Test for subject empty
      if ( $this->data[ 'subject' ] === '' )
      {

        // Set error code
        $return_code = false;
        $error[ 'subject' ] = $this->data[ 'company_contact_empty_subject_error' ];

      }

    }

    //------------------------------------------------------------------------

    // Test for message parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'message' ) === false )
    {

      // Set error code
      $return_code = false;
      $this->error[ 'message' ] = $this->data[ 'company_contact_empty_message_error' ];

    }
    else
    {

      // Get message
      $this->data[ 'message' ] = trim( $this->request->Get_POST_Parameter_As_String( 'message' ) );

      // Test for message empty
      if ( $this->data[ 'message' ] === '' )
      {

        // Set error code
        $return_code = false;
        $error[ 'message' ] = $this->data[ 'company_contact_empty_message_error' ];

      }

    }

    //------------------------------------------------------------------------

    // Test for agreement parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'agreement' ) === false )
    {

      // Set error code
      $return_code = false;
      $error[ 'agreement' ] = $this->data[ 'company_contact_not_agree_error' ];

    }
    else
    {

      if ( $this->request->Is_POST_Parameter_Boolean( 'agreement' ) === false )
      {

        // Set error code
        $return_code = false;
        $error[ 'agreement' ] = $this->data[ 'company_contact_not_agree_error' ];

      }
      else
      {

        // Get agreement
        $this->data[ 'agreement' ] = $this->request->Get_POST_Parameter_As_Boolean( 'agreement' );

        if ( $this->data[ 'agreement' ] === false )
        {

          // Set error code
          $return_code = false;
          $error[ 'agreement' ] = $this->data[ 'company_contact_not_agree_error' ];

        }

      }

    }

    //------------------------------------------------------------------------

    // Test for captcha parameter exists
    if ( $this->request->Is_POST_Parameter_Exists( 'captcha' ) === false )
    {

      // Set error code
      $return_code = false;
      $error[ 'captcha' ] = $this->data[ 'company_contact_empty_captcha_error' ];

    }
    else
    {

      // Get captcha
      $this->data[ 'captcha' ] = trim( $this->request->Get_POST_Parameter_As_String( 'captcha' ) );

      // Test for captcha empty
      if ( $this->data[ 'captcha' ] === '' )
      {

        // Set error code
        $return_code = false;
        $error[ 'captcha' ] = $this->data[ 'company_contact_empty_captcha_error' ];

      }
      else
      {

        if ( $this->session->data['captcha'] !== strtoupper( $this->data[ 'captcha' ] ) )
        {

          $return_code = false;
          $error[ 'captcha' ]  = $this->data['company_contact_incorrect_captcha_error'];

        }

      }

    }

    return $error;

    //------------------------------------------------------------------------

    if ( $return_code === true )
    {
/*
                if ($this->model_company_contact->Is_Exists($this->data['email'])) {
                    $customer_id = $this->model_company_contact->findCustomerId($this->data['email']);
                    $chat_id = $this->model_company_contact->userHasChat($customer_id);
                    if ($chat_id == NULL) {
                        $chat_id = $this->model_company_contact->createChat($customer_id);
                    }
                }else{
                    $this->data['password'] = base64_encode(random_bytes(8));
                    $this->session->data['password'] = $this->data['password'];
                    $customer_id= $this->model_company_contact->createCustomer($this->data);
                    $chat_id = $this->model_company_contact->createChat($customer_id);
                }
*/
      $this->session->data['email'] = $this->data['email'];
      $this->session->data['subject'] = $this->data['subject'];
      $this->session->data['message'] = $this->data['message'];

      // Add message
      $this->model_company_contact->addMessage( $chat_id, $this->customer->Get_GUID(), $this->data[ 'subject' ], $this->data[ 'message' ] );

      //------------------------------------------------------------------------
      // Send email with confirmation data
      //------------------------------------------------------------------------

      $chars = '23456789abcdefghklmnprstuvwxyz';
      $code = '';
      for ( $i = 0; $i < 6; $i++ )
      {
        $code .= $chars[ random_int( 0, strlen( $chars ) - 1 ) ];
      }

      $this->session->data['code'] = strtoupper( $code );

      // Load email messages
      $this->messages->Load( $this->data, 'company', 'contact', 'Send_Message', $this->language->Get_Language_Code() );

      // Create template
      $email_template = new Template();

      // Set email messages
      $email_template->messages = $this->data;

      // Set email data
      $email_template->data[ 'code' ] = $this->session->data['code'];

      // Set email data
      $mail->setTo( $this->data['email'] );
      $mail->setSubject( html_entity_decode( $this->data[ 'company_contact_subject_message' ], ENT_QUOTES, 'UTF-8' ) );
      $mail->setHtml( html_entity_decode( $email_template->Render( 'contact/confirm.tpl' ), ENT_QUOTES, 'UTF-8' ) );

      // Send email
      $mail->send();

    }

    // Set JSON data
    $json[ 'return_code' ] = $return_code;
    $json[ 'return_code' ] = 'company_contact_success_text';
    $json[ 'error' ] = $error;

    // Render page
    $this->response->Set_Json_Output( $json );

  }

  //--------------------------------------------------------------------------

                //----------------------------------------------------------------------
                // Message added successfull
                //----------------------------------------------------------------------

                // Send email

//    if ( $this->request->Is_POST_Request() && $this->validate() )

//                $email_subject = $this->messages->Get_String('common', 'contact', 'notification_email', 'subject_text');
//                $email_body = $this->messages->Get_String('common', 'contact', 'notification_email', 'body_text');

                //----------------------------------------------------------------------
                // Send notification email
                //----------------------------------------------------------------------

//                $mail = new Mail();
//                $mail->protocol = $this->config->get('config_mail_protocol');
//                $mail->parameter = $this->config->get('config_mail_parameter');
//                $mail->hostname = $this->config->get('config_smtp_host');
//                $mail->username = $this->config->get('config_smtp_username');
//                $mail->password = $this->config->get('config_smtp_password');
//                $mail->port = $this->config->get('config_smtp_port');
//                $mail->timeout = $this->config->get('config_smtp_timeout');
//
//                $mail->setTo($this->config->get('config_email'));
//                $mail->setFrom($data['email']);
//                $mail->setSender('ANVILEX');
//                $mail->setSubject(html_entity_decode($email_subject, ENT_QUOTES, 'UTF-8'));
//                $mail->setText(strip_tags(html_entity_decode($email_body, ENT_QUOTES, 'UTF-8')));
//
//                $mail->send();

                //----------------------------------------------------------------------
                // Send confirmation email
                //----------------------------------------------------------------------

//                $mail->setTo($data['email']);
//                $mail->setFrom($this->config->get('config_email'));
//                $mail->setSender('ANVILEX');
//                $mail->setSubject(html_entity_decode($email_subject, ENT_QUOTES, 'UTF-8'));
//                $mail->setText(strip_tags(html_entity_decode($email_body, ENT_QUOTES, 'UTF-8')));

//	  		$this->response->Redirect( $this->url->link( 'company/contact/success' ) );

        // Encode and send json data
//        $this->response->Set_Json_Output( $json );
//
//        // Verify input data
//        $json['email_valid'] = $this->model_company_contact->Is_Email_Valid($data['email']);
//        $json['subject_valid'] = $this->model_company_contact->Is_Subject_Valid($data['subject']);
//        $json['message_valid'] = $this->model_company_contact->Is_Message_Valid($data['message']);
//
//        if (($json['email_valid'] == false) ||
//            ($json['subject_valid'] == false) ||
//            ($json['message_valid'] == false)) {

            //------------------------------------------------------------------------
            // ERROR: Bad input data
            //------------------------------------------------------------------------

            // Set error code
//            $json['return_code'] = 'error';
//
//        } else {



//        }

    //----------------------------------------------------------------------------
    /*
      protected function validate()
      {

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32))
        {
                  $this->error['name'] = $this->language->get('error_name');
        }

            if (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email']))
            {
                  $this->error['email'] = $this->language->get('error_email');
            }

            if ((utf8_strlen($this->request->post['enquiry']) < 10) || (utf8_strlen($this->request->post['enquiry']) > 3000))
            {
                  $this->error['enquiry'] = $this->language->get('error_enquiry');
            }

            if (empty($this->session->data['captcha']) || ($this->session->data['captcha'] != $this->request->post['captcha']))
            {
                  $this->error['captcha'] = $this->language->get('error_captcha');
            }

            if (!$this->error)
            {
                  return true;
            }
            else
            {
                  return false;
            }
          }
    */

  //----------------------------------------------------------------------------
  // Get captcha method
  //----------------------------------------------------------------------------
  // Caller: AJAX
  //----------------------------------------------------------------------------

	public function captcha()
	{

    // Init json data
    $json = array();

    // Load library
    $this->load->library( 'captcha' );

    // Create captcha object
		$captcha = new Captcha();

    // Store captcha in session
		$this->session->data[ 'captcha' ] = $captcha->getCode();

    // Set captcha image
    $json[ 'captcha' ] = 'data:' . 'jpeg' . ';base64,' . base64_encode( $captcha->showImage() );

    // Render page
    $this->response->Set_Json_Output( $json );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
