<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerDesignMenu extends Controller {
	
    private $error = array();

    public function index() {
        $this->load->language('design/menu');
        $this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_setting->editSetting('configmenu', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_list'] = $this->language->get('text_list');
		
		$data['text_success'] = $this->language->get('text_success');
		$data['text_new_menu_item'] = $this->language->get('text_new_menu_item');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_product'] = $this->language->get('text_product');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_information'] = $this->language->get('text_information');
		$data['text_custom'] = $this->language->get('text_custom');
		$data['text_confirm'] = $this->language->get('text_confirm');
		
		$data['text_menu_title'] = $this->language->get('text_menu_title');
		$data['text_menu_description'] = $this->language->get('text_menu_description');
		$data['text_sub_item'] = $this->language->get('text_sub_item');
		$data['text_menu_name'] = $this->language->get('text_menu_name');
		$data['text_menu_link'] = $this->language->get('text_menu_link');
		
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');
		
		$data['column_custom_name'] = $this->language->get('column_custom_name');
		$data['column_custom_link'] = $this->language->get('column_custom_link');
		$data['column_category_name'] = $this->language->get('column_category_name');
		$data['column_product_name'] = $this->language->get('column_product_name');
		$data['column_manufacturer_name'] = $this->language->get('column_manufacturer_name');
		$data['column_information_name'] = $this->language->get('column_information_name');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_columns'] = $this->language->get('entry_columns');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_store'] = $this->language->get('entry_store');
		
		$data['button_custom'] = $this->language->get('button_custom');
		$data['button_categories'] = $this->language->get('button_categories');
		$data['button_products'] = $this->language->get('button_products');
		$data['button_manufacturers'] = $this->language->get('button_manufacturers');
		$data['button_informations'] = $this->language->get('button_informations');
		
		$data['button_disable'] = $this->language->get('button_disable');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_delete'] = $this->language->get('button_delete');
		
		$data['error_permission'] = $this->language->get('error_permission');
		$data['error_name'] = $this->language->get('error_name');
		$data['error_link'] = $this->language->get('error_link');
		
		$data['text_menu_enable'] = $this->language->get('text_menu_enable');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		
        $this->load->model('design/menu');

        $this->document->addStyle('view/javascript/jquery/layout/jquery-ui.css');
        $this->document->addStyle('view/stylesheet/menu.css');
        $this->document->addStyle('view/stylesheet/layout.css');
		
		$this->document->addScript('view/javascript/jquery/layout/jquery-ui.js');
        $this->document->addScript('view/javascript/jquery/layout/jquery-lockfixed.js');
        $this->document->addScript('view/javascript/menu/menu.js');
		
		$data['changeMenuPosition'] = $this->url->link('design/menu/changeMenuPosition', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['deleteMenu'] = $this->url->link('design/menu/deleteMenu', 'token=' . $this->session->data['token'], 'SSL');
		$data['deleteChildMenu'] = $this->url->link('design/menu/deleteChildMenu', 'token=' . $this->session->data['token'], 'SSL');
				
		$data['enableMenu'] = $this->url->link('design/menu/enableMenu', 'token=' . $this->session->data['token'], 'SSL');
		$data['enableChildMenu'] = $this->url->link('design/menu/enableChildMenu', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['disableMenu'] = $this->url->link('design/menu/disableMenu', 'token=' . $this->session->data['token'], 'SSL');
		$data['disableChildMenu'] = $this->url->link('design/menu/disableChildMenu', 'token=' . $this->session->data['token'], 'SSL');

		$data['refresch'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');
		$data['add'] = $this->url->link('design/menu/add', 'token=' . $this->session->data['token'], 'SSL');
		$data['save'] = $this->url->link('design/menu/save', 'token=' . $this->session->data['token'], 'SSL');

		$data['menu_child'] = array();

		$menus = $this->model_design_menu->getMenus();
        $menu_child = $this->model_design_menu->getChildMenus();

        $rent_menu = array();

        $this->load->model('catalog/product');
		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

        foreach($menus as $id => $menu) {
            $rent_menu[] = array(
                'name'          => $menu['name'] ,
                'menu_id'       => $menu['menu_id'],
                'menu_type'     => $menu['menu_type'],
                'status'        => $menu['status'],
                'store'         => $this->model_design_menu->getMenuStores($menu['menu_id']),
                'isSubMenu'     => ''
            );

            foreach($menu_child as $child_id => $child_menu) {
                if (($menu['menu_id'] != $child_menu['menu_id']) or !is_numeric($child_id)) {
                    continue;
                }

                $rent_menu[] = array(
                    'name'          => $child_menu['name'],
                    'menu_id'       => $child_menu['menu_child_id'],
                    'menu_type'     => $child_menu['menu_type'],
                    'status'        => $child_menu['status'],
                    'store'         => $this->model_design_menu->getChildMenuStores($child_menu['menu_child_id']),
                    'isSubMenu'     => $menu['menu_id']
                );
            }
        }

		$data['menu_desc'] = $this->model_design_menu->getMenuDesc();
		$data['menu_child_desc'] = $this->model_design_menu->getMenuChildDesc();

        $data['menus'] = $rent_menu;

        $this->load->model('setting/store');

        $data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['token'] = $this->session->data['token'];
		
		$data['action'] = $this->url->link('design/menu', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['configmenu_menu'])) {
			$data['configmenu_menu'] = $this->request->post['configmenu_menu'];
		} else {
			$data['configmenu_menu'] = $this->config->get('configmenu_menu');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('design/menu.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/menu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/menu')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

    public function add() {
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->load->model('design/menu');
            $this->load->model('localisation/language');

            $languages = $this->model_localisation_language->getLanguages();

            $menu = $this->model_design_menu->add($this->request->post, $languages);

            if (!empty($menu)) {
                echo $this->addHtml($menu, $languages);
            }
        }
    }

    protected function addHtml($menu, $languages){
        $this->load->language('design/menu');

        $count = '0';

        $html  = '<li id="menu-item-' . $menu['menu_id'] . '" class="menu-item menu-item-depth-0 menu-item-page menu-item-edit-inactive pending">';
        $html .= '	<dl class="menu-item-bar">';
        $html .= '		<dt class="menu-item-handle">';
        $html .= '			<span class="item-title"><span class="menu-item-title">' . $menu['name'] .'</span> <span class="is-submenu" style="display: none;">' . $this->language->get('text_sub_item') . '</span></span>';
        $html .= '          <span class="item-controls">';
        $html .= '			<span class="item-type">' . ucwords($menu['menu_type']) . '</span>';
        $html .= '				<a class="item-edit openMenuItem ' . $menu['menu_type'] . '" id="edit-' . $menu['menu_id'] . '" title="">';
        $html .= '                <i class="fa fa-caret-down"></i>';
        $html .= '              </a>';
        $html .= '			</span>';
        $html .= '      </dt>';
        $html .= ' </dl>';

        $menu_desc = $this->model_design_menu->getMenuDesc();

        $html .= '<div class="menu-item-settings" id="menu-item-settings-edit-' . $menu['menu_id'] . '">';
        $html .= $this->language->get('text_menu_name') . '</br>';

        foreach ($languages as $language) {
            $html .= '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/' . $language["image"] . '" title="' . $language["name"] . '"/></span>';
            $html .= '   <input type="text" name="menu_name[' . $language['language_id'] . ']" value="' . $menu_desc[$menu['menu_id']][$language['language_id']]['name']. '" placeholder="' . $this->language->get('text_menu_name') . '" class="form-control" />';
            $html .= '</div>';
        }
        $html .= '<br>';

        if ($menu['menu_type'] == 'custom') {
            $html .= $this->language->get('text_menu_link') . '<br>';

            foreach ($languages as $language) {
                $html .= '<div class="input-group"><span class="input-group-addon"><img src="view/image/flags/' . $language['image'] . '" title="' . $language['name'] . '" /></span>';
                $html .= '   <input type="text" name="menu_link[' . $language['language_id'] . ']" value="' . $menu_desc[$menu['menu_id']][$language['language_id']]['link'] . '" placeholder="' . $this->language->get('text_menu_link') . '" class="form-control" />';
                $html .= '</div>';
            }

            $html .= '<br>';
        }

        $html .= $this->language->get('entry_columns');
        $html .= '<div class="input-group">';
        $html .= '  <input type="text" name="menu_columns" value="1" placeholder="" id="input-columns" class="form-control" />';
        $html .= '</div>';
        $html .= '<br>';
        $html .= '<div class="pull-right">';
        $html .= ' <a id="disableMenu-'. $count . '" onclick="statusMenu(\'disable\', \'' . $menu['menu_id'] . '\', \'menu-item-' . $menu['menu_id'] . '\', \'disableMenu-' . $count .'\')" data-type="iframe" data-toggle="tooltip" style="top:2px!important;font-size:1.2em !important;" title="' . $this->language->get('button_disable') . '" class="btn btn-danger btn-xs btn-edit btn-group"><i class="fa fa-times-circle"></i></a>';
        $html .= ' <a onclick="saveMenu(\'menu-item-settings-edit-' . $menu['menu_id'] . '\', \'menu-item-' . $menu['menu_id'] . '\')" data-type="iframe" data-toggle="tooltip" style="top:2px!important;font-size:1.2em !important;" title="' . $this->language->get('button_save') . '" class="btn btn-success btn-xs btn-edit btn-group"><i class="fa fa-save"></i></a>';
        $html .= ' <button type="button" data-toggle="tooltip" title="" style="top:2px!important;font-size:1.2em !important;" class="btn btn-danger btn-xs btn-edit btn-group btn-loading" onclick="confirm(\'Are you sure?\') ? deleteMenu(\'' . $menu['menu_id'] . '\', \'menu-item-' . $menu['menu_id'] . '\') : false;" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>';
        $html .= '</div>';
        $html .= '<br><br>';

        $html .= '<input class="menu-item-data-typeMenu" type="hidden" name="menu-item-typeMenu[MainMenu-' . $menu['menu_id'].']" value="MainMenu">';
        $html .= '<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[MainMenu-' . $menu['menu_id'] . ']" value="' . $menu['menu_id'] . '">';
        $html .= '<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[MainMenu-' . $menu['menu_id'] .']" value="0">';
        $html .= '<input class="menu-item-data-position" type="hidden" name="menu-item-position[MainMenu-' . $menu['menu_id'] . ']" value="' . $menu['menu_id'] . '">';
        $html .= '<input class="menu-item-data-type" type="hidden" name="menu-item-type[MainMenu-' . $menu['menu_id'] . ']" value="post_type">';

        $html .= '</div>';
        $html .= '<ul class="menu-item-transport"></ul>';
        $html .= '</li>';

        return $html;
    }

    public function save() {
        $this->load->language('design/menu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('design/menu');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            if($this->request->get['type'] == 'child') {
                $this->model_design_menu->saveChild($this->request->post);
            } else {
                $this->model_design_menu->save($this->request->post);
            }

            $this->session->data['success'] = $this->language->get('text_success');
        }
    }

    public function deleteMenu() {
        $this->load->language('design/menu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('design/menu');

        if (isset($this->request->post['menu_id']) && $this->validateDelete()) {
            $this->model_design_menu->deleteMenu($this->request->post['menu_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $json['success'] = $this->language->get('text_success');
            $json['error']   = $this->language->get('text_error');

        } else {
            $this->session->data['error'] = $this->language->get('text_error');

            $json['success'] = '';
            $json['error']   = $this->language->get('text_error');
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function deleteChildMenu() {
        $this->load->language('design/menu');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('design/menu');

        if (isset($this->request->post['menu_id']) && $this->validateDelete()) {
            $this->model_design_menu->deleteChildMenu($this->request->post['menu_id']);

            $this->session->data['success'] = $this->language->get('text_success');

            $json['success'] = $this->language->get('text_success');
            $json['error']   = '';

        } else {
            $this->session->data['error'] = $this->language->get('text_error');

            $json['success'] = '';
            $json['error']   = $this->language->get('text_error');
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

	public function enableMenu() {
        $this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_menu->enableMenu($this->request->post['menu_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			 
		}
		
		$id = explode('-', $this->request->post['id']);

		$button = "<a id=\"disableMenu-" . $id[1] . "\" onclick=\"statusMenu('disable', '" . $this->request->post['menu_id'] . "', 'menu-item-" .  $this->request->post['menu_id'] . "', 'disableMenu-" . $id[1] . "')\" data-type=\"iframe\" data-toggle=\"tooltip\" style=\"top:2px!important;font-size:1.2em !important;\" title=\"\" class=\"btn btn-danger btn-xs btn-edit btn-group\"><i class=\"fa fa-times-circle\"></i></a>";
		
		echo $button;
		exit();
	}	

	public function disableMenu() {
        $this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_menu->disableMenu($this->request->post['menu_id']);
			$this->session->data['success'] = $this->language->get('text_success');
			 
		}
		
		$id = explode('-', $this->request->post['id']);
		
		$button = "<a id=\"enableMenu-" . $id[1] . "\" onclick=\"statusMenu('enable', '" . $this->request->post['menu_id'] . "', 'menu-item-" .  $this->request->post['menu_id'] . "', 'enableMenu-" . $id[1] . "')\" data-type=\"iframe\" data-toggle=\"tooltip\" style=\"top:2px!important;font-size:1.2em !important;\" title=\"\" class=\"btn btn-success btn-xs btn-edit btn-group\"><i class=\"fa fa-check-circle\"></i></a>";

		echo $button;
		exit();
	}	
	
	public function enableChildMenu() {
        $this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_menu->enableChildMenu($this->request->post['menu_id']);
			$this->session->data['success'] = $this->language->get('text_success');	 
		}

		$id = explode('-', $this->request->post['id']);
		
		$button = "<a id=\"disableMenu-" . $id[1] . "\" onclick=\"statusMenu('disable', '" . $this->request->post['menu_id'] . "', 'menu-child-item-" .  $this->request->post['menu_id'] . "', 'disableMenu-" . $id[1] . "')\" data-type=\"iframe\" data-toggle=\"tooltip\" style=\"top:2px!important;font-size:1.2em !important;\" title=\"\" class=\"btn btn-danger btn-xs btn-edit btn-group\"><i class=\"fa fa-times-circle\"></i></a>";

		echo $button;
		exit();
	}	

	public function disableChildMenu() {
        $this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_menu->disableChildMenu($this->request->post['menu_id']);
			$this->session->data['success'] = $this->language->get('text_success');	 
		}
		
		$id = explode('-', $this->request->post['id']);

		$button = "<a id=\"enableMenu-" . $id[1] . "\" onclick=\"statusMenu('enable', '" . $this->request->post['menu_id'] . "', 'menu-child-item-" .  $this->request->post['menu_id'] . "', 'enableMenu-" . $id[1] . "')\" data-type=\"iframe\" data-toggle=\"tooltip\" style=\"top:2px!important;font-size:1.2em !important;\" title=\"\" class=\"btn btn-success btn-xs btn-edit btn-group\"><i class=\"fa fa-check-circle\"></i></a>";
		
		echo $button;
		exit();
	}	

	public function changeMenuPosition() {
        $this->load->language('design/menu');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('design/menu');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_design_menu->changeMenuPosition($this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

		}
	}	

	public function autocomplete() {
		$json = array();

		#Category
		if (isset($this->request->get['filter_category_name'])) {
			$this->load->model('catalog/category');
			
			if (isset($this->request->get['filter_category_name'])) {
				$filter_name = $this->request->get['filter_category_name'];
			} else {
				$filter_name = '';
			}
			
			$filter_data = array(
				'filter_name' => $filter_name,
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				
				$result['index'] = $result['name'];
				if(strpos($result['name'], '&nbsp;&nbsp;&gt;&nbsp;&nbsp;')) {
					$result['name'] = explode ('&nbsp;&nbsp;&gt;&nbsp;&nbsp;', $result['name']);
					$result['name'] = end($result['name']);
				}
				
				$json[] = array(
					'category_id' => $result['category_id'],
					'index'		  => $result['index'],
					'name'		  => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		
		#Product
		if (isset($this->request->get['filter_product_name'])) {
			$this->load->model('catalog/product');

			if (isset($this->request->get['filter_product_name'])) {
				$filter_name = $this->request->get['filter_product_name'];
			} else {
				$filter_name = '';
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'start'        => 0,
				'limit'        => 5
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'index'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}
		
		#Manufacturer
		if (isset($this->request->get['filter_manufacturer_name'])) {
			$this->load->model('catalog/manufacturer');
			
			if (isset($this->request->get['filter_manufacturer_name'])) {
				$filter_name = $this->request->get['filter_manufacturer_name'];
			} else {
				$filter_name = '';
			}
			
			$filter_data = array(
				'filter_name' => $filter_name,
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_manufacturer->getManufacturers($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'index'           => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		#Information
		if (isset($this->request->get['filter_information_name'])) {
			$this->load->model('catalog/information');
			
			if (isset($this->request->get['filter_manufacturer_name'])) {
				$filter_name = $this->request->get['filter_manufacturer_name'];
			} else {
				$filter_name = '';
			}
			
			$filter_data = array(
				'filter_name' => $filter_name,
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_information->getInformations($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'information_id' => $result['information_id'],
					'name'            => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8')),
					'index'           => strip_tags(html_entity_decode($result['title'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}	
}