<?php
class ControllerModuleGoogleAdsense extends Controller {
	protected function index($setting) {

      	$this->data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['code'] = str_replace('http', 'https', html_entity_decode($this->config->get('google_adsense_code')));
		} else {
		$this->data['code'] = html_entity_decode($this->config->get('google_adsense_code'));
		}

		$this->Render( 'module/google_adsense.tpl' );
	}
}
?>