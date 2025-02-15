<?php

class ControllerCapchaCapcha extends Controller
{

  //----------------------------------------------------------------------------

  public function index()
  {
  
    $code = base64_encode(random_bytes(6));

    // Load model 
    $this->load->model('company/contact');

    $image = imagecreate(100, 40);
    $background_color = imagecolorallocate($image, 0, 153, 0);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 5, 180, 100,  $code, $text_color);
    
    header("Content-Type: image/png");
    $this->session->data['captcha'] -> $image;
    imagepng($image);
    imagedestroy($image);

//        $this->load->library('captcha');
//
//        $captcha = new Captcha();
//
//        $this->session->data['captcha'] = $captcha->getCode();
//
//        $captcha->showImage();

    $this->response->addStyle( 'catalog/view/stylesheet/contact.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

    // Render page
    $this->Render( 'company/contact.tpl' );

  }

}
?>