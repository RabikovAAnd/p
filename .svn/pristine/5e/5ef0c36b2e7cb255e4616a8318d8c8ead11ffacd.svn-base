<?php
class ControllerFeedEMail extends Controller 
{
	public function index() 
	{

		$this->load->model('feed/email');

		$email_id = isset($this->request->get['id']) ? $this->request->get['id'] : '';

		$this->model_feed_email->getOrder($email_id);

	}

	public function order()
	{
		
		
	}

}
