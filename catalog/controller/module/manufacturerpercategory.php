<?php
// *	@copyright	OCSHOP.CMS \ ocshop.net 2011 - 2015.
// *	@demo	http://ocshop.net
// *	@blog	http://ocshop.info
// *	@forum	http://forum.ocshop.info
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerModuleManufacturerpercategory extends Controller {
	public function index($setting) {
		$this->load->language('module/manufacturerpercategory');
		
    	$data['heading_title'] = $this->language->get('heading_title');
		
		if (isset($this->request->get['path'])) {            $path = '';            $parts = explode('_', (string)$this->request->get['path']);            foreach ($parts as $path_id) {                if (!$path) {                    $path = $path_id;                } else {                    $path .= '_' . $path_id;                }            }            $category_id = array_pop($parts);        } else {            $category_id = null;        }		
		$this->load->model('module/manufacturerpercategory');					
		$this->load->model('catalog/manufacturer');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		$data['manufactureres'] = array();
					
		if (isset($category_id)) {				$results = $this->model_module_manufacturerpercategory->getManufacturersByCategory($category_id);		} else {		   	$results = $this->model_catalog_manufacturer->getManufacturers(0);		}		foreach($results as $result)
		{
			
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 40, 40);
				}
			
			$data['manufactureres'][] = array(
				'thumb'       => $image,
				'manufacturer_id' => $result['manufacturer_id'],
				'name'        => $result['name'] ,
				'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id'])
		
			);
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/manufacturerpercategory.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/manufacturerpercategory.tpl', $data);
		} else {
			return $this->load->view('default/template/module/manufacturerpercategory.tpl', $data);
		}
		
  	}
}
?>