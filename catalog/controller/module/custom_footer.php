<?php
class ControllerModuleCustomFooter extends Controller {
	public function index() {
		$this->load->language('module/custom_footer');

		$data['heading_title'] = $this->language->get('heading_title');
		
		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		
		if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/custom_footer.css')) {
				$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/custom_footer.css');
			} else {
				$this->document->addStyle('catalog/view/theme/default/stylesheet/custom_footer.css');
		}
		
		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}
		
		$data['name'] = $this->config->get('config_name');
		$data['welcome'] = html_entity_decode($this->config->get('custom_footer_welcome'), ENT_QUOTES, 'UTF-8');
		$data['telephone'] = html_entity_decode($this->config->get('custom_footer_telephone'), ENT_QUOTES, 'UTF-8');
		$data['telephone2'] = html_entity_decode($this->config->get('custom_footer_telephone2'), ENT_QUOTES, 'UTF-8');
		$data['telephone3'] = html_entity_decode($this->config->get('custom_footer_telephone3'), ENT_QUOTES, 'UTF-8');
		$data['email'] = html_entity_decode($this->config->get('custom_footer_email'), ENT_QUOTES, 'UTF-8');
		$data['address'] = html_entity_decode($this->config->get('custom_footer_address'), ENT_QUOTES, 'UTF-8');
		$data['time'] = html_entity_decode($this->config->get('custom_footer_time'), ENT_QUOTES, 'UTF-8');
		
		$data['vk'] = html_entity_decode($this->config->get('custom_footer_vk'), ENT_QUOTES, 'UTF-8');
		$data['fb'] = html_entity_decode($this->config->get('custom_footer_fb'), ENT_QUOTES, 'UTF-8');
		$data['googleplus'] = html_entity_decode($this->config->get('custom_footer_googleplus'), ENT_QUOTES, 'UTF-8');
		$data['youtube'] = html_entity_decode($this->config->get('custom_footer_youtube'), ENT_QUOTES, 'UTF-8');
		$data['twitter'] = html_entity_decode($this->config->get('custom_footer_twitter'), ENT_QUOTES, 'UTF-8');
		
		$data['maps'] = html_entity_decode($this->config->get('custom_footer_maps'), ENT_QUOTES, 'UTF-8');
			

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/custom_footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/custom_footer.tpl', $data);
		} else {
			return $this->load->view('default/template/module/custom_footer.tpl', $data);
		}
	}
}