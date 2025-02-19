<?php

class ControllerCompanyContactConfirm extends Controller
{

  //----------------------------------------------------------------------------

  private $error = array();

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'company', 'contact_confirm', 'index', $this->language->Get_Language_Code() );

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setRobots( 'index, follow' );

    // Add style
    $this->response->addStyle( 'catalog/view/stylesheet/company/contact.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

  //--------------------------------------------------------------------------

    private function Data_Verification()
    {
      
        // Load strings
        $this->messages->Load( $this->data, 'company', 'contact_confirm', 'Data_Verification', $this->language->Get_Language_Code() );
        
        // Set error code
        if ($this->request->post['code'] !== $this->session->data['code'] || $this->request->post['code'] === null){
            $this->error['code'] = $this->data['company_contact_confirm_code_error'];
        }

        return $this->error;

    }

    //----------------------------------------------------------------------------
    // Add message
    //----------------------------------------------------------------------------

    /**
     * @throws Exception
     */
    public function Add_Message()
    {

        // Init json data
        $json = array();

        // Load language
        $this->messages->Load( $this->data, 'company', 'contact_confirm', 'Add_Message', $this->language->Get_Language_Code() );

        if($this->request->Is_POST_Parameter_Exists('code')
            && $this->session->data['email']
            && $this->session->data['subject']
            && $this->session->data['message']){
            // Load model
            $this->load->model('company/contact');
            if(!$this->Data_Verification()){
                // Get parameters
                $this->data['email'] = $this->session->data['email'];
                $this->data['subject'] = $this->session->data['subject'];
                $this->data['message'] = $this->session->data['message'];
                $this->log->write( 'DEBUG : ' . $this->data['email']);
                if ($this->model_company_contact->Is_Exists($this->data['email'])) {
                    $customer_id = $this->model_company_contact->findCustomerId($this->data['email']);
                    $chat_id = $this->model_company_contact->userHasChat($customer_id);
                    if ($chat_id == NULL) {
                        $chat_id = $this->model_company_contact->createChat($customer_id);
                    }
                }else{
                    $this->data['password'] = base64_encode(random_bytes(8));
                    $customer_id= $this->model_company_contact->createCustomer($this->data);
                    $chat_id = $this->model_company_contact->createChat($customer_id);
                    $this->Send_Password($this->data['email'], $this->data['password']);
                }
                $this->model_company_contact->addMessage($chat_id, $customer_id, $this->data['subject'], $this->data['message']);
                $json['return_code'] = 'company_contact_confirm_text';
                $this->session->data['contact_success'] = 'success';
            }else{
                $json['error'] = $this->Data_Verification();
            }
        }else{
            $json['error']['page'] =  $this->data['company_contact_confirm_page_error'];
        }



        // Render page
        $this->response->Set_Json_Output( $json );

    }

  //----------------------------------------------------------------------------
  
    public function Send_Password($email, $password)
    {
        // Load language
        $this->messages->Load( $this->data, 'company', 'contact_confirm', 'Send_Password', $this->language->Get_Language_Code() );

        $subject = 'Your account created';
        $message = '
            <html>
            <head>
              <title>Send message</title>
            </head>
            <body>
            <span>' . 'Your login' . ': ' . $email . '</span>
            <br><span>' . 'Your password' . ': ' . $password . '</span>
            </body>
            </html>
            ';
        $mail = new Mail();

        $mail->protocol = MAIL_PROTOCOL;
        $mail->parameter = MAIL_PARAMETER;
        $mail->hostname = MAIL_HOSTNAME;
        $mail->username = MAIL_USERNAME;
        $mail->password = MAIL_PASSWORD;
        $mail->port = MAIL_PORT;
        $mail->timeout = MAIL_TIMEOUT;
//        $mail->setHtml($message );
        $mail->setTo($email );
        $mail->setFrom( 'mail.sender@anvilex.com' );
        $mail->setSender( 'ANVILEX' );
        $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
        $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );

        $mail->send();
    }
    
    //--------------------------------------------------------------------------

    public function Resend_Message()
    {
        $chars = '23456789abcdefghklmnprstuvwxyz';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }

        $this->session->data['code'] = strtoupper($code);

        // Load messages
        $this->messages->Load( $this->data, 'company', 'contact_confirm', 'Resend_Message', $this->language->Get_Language_Code() );

        $subject = $this->data[ 'company_contact_confirm_subject_message' ];
//          $message = 'Email body: ' . $hash;
        $message = '
            <html>
            <head>
              <title>Send message</title>
            </head>
            <body>
            <span>' . $this->data[ 'company_contact_confirm_main_text_message' ] . ': ' . $this->session->data['code'] . '</span>
            </body>
            </html>
            ';
        $mail = new Mail();

        $mail->protocol = MAIL_PROTOCOL;
        $mail->parameter = MAIL_PARAMETER;
        $mail->hostname = MAIL_HOSTNAME;
        $mail->username = MAIL_USERNAME;
        $mail->password = MAIL_PASSWORD;
        $mail->port = MAIL_PORT;
        $mail->timeout = MAIL_TIMEOUT;
//        $mail->setHtml($message );
        $mail->setTo($this->session->data['email'] );
        $mail->setFrom( 'mail.sender@anvilex.com' );
        $mail->setSender( 'ANVILEX' );
        $mail->setSubject( html_entity_decode( $subject, ENT_QUOTES, 'UTF-8' ) );
        $mail->setHtml( html_entity_decode( $message, ENT_QUOTES, 'UTF-8' ) );

        $mail->send();
    }
}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
