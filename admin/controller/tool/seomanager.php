<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerToolSeoManager extends Controller {
        private $error = array();

        public function index() {
                $this->load->language('tool/seomanager');

                $this->document->setTitle($this->language->get('heading_title'));

                $this->load->model('tool/seomanager');

                $this->getList();
        }

        public function update() {
                $this->load->language('tool/seomanager');
                $this->document->setTitle($this->language->get('heading_title'));
                $this->load->model('tool/seomanager');

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
                        $this->model_tool_seomanager->updateUrlAlias($this->request->post);
                        $this->session->data['success'] = $this->language->get('text_success');
                }
		$this->response->redirect($this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        
        public function clear() {
    		$this->load->language('tool/seomanager');
                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }
                $this->cache->delete('seo_pro');
                $this->cache->delete('seo_url');
                $this->session->data['success'] = $this->language->get('text_success_clear');
		$this->response->redirect($this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        public function delete() {
                $this->load->language('tool/seomanager');
                $this->load->model('tool/seomanager');
                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }

                if (isset($this->request->post['selected']) && $this->validateDelete()) {
                        foreach ($this->request->post['selected'] as $url_alias_id) {
                                $this->model_tool_seomanager->deleteUrlAlias($url_alias_id);
                        }
                        $this->session->data['success'] = $this->language->get('text_success');
                }

                $this->response->redirect($this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        private function getList() {
                if (isset($this->request->get['sort'])) {
                        $sort = $this->request->get['sort'];
                } else {
                        $sort = 'ua.query';
                }

                if (isset($this->request->get['order'])) {
                        $order = $this->request->get['order'];
                } else {
                        $order = 'ASC';
                }

                if (isset($this->request->get['page'])) {
                        $page = $this->request->get['page'];
                } else {
                        $page = 1;
                }

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }
				
				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
				);

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL')
				);

                $data['insert'] = $this->url->link('tool/seomanager/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $data['delete'] = $this->url->link('tool/seomanager/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $data['save'] = $this->url->link('tool/seomanager/update', 'token=' . $this->session->data['token'] . $url, 'SSL');
                $data['clear'] = $this->url->link('tool/seomanager/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');

                $data['url_aliases'] = array();

                $filterdata = array(
            		'sort' => $sort, 
            		'order' => $order, 
            		'start' => ($page - 1) * $this->config->get('config_admin_limit'), 
            		'limit' => $this->config->get('config_admin_limit')
            		);

                $url_alias_total = $this->model_tool_seomanager->getTotalUrlAalias();

                $results = $this->model_tool_seomanager->getUrlAaliases($filterdata);

                foreach ($results as $result) {
                        $data['url_aliases'][] = array(
                    		'url_alias_id' => $result['url_alias_id'], 
                    		'query' => $result['query'],
                    		'keyword' => $result['keyword'],
                    		'selected' => isset($this->request->post['selected']) && in_array($result['url_alias_id'], $this->request->post['selected']), 
                    		'action_text' => $this->language->get('text_edit')
                    		);
                }

                $data['heading_title'] = $this->language->get('heading_title');

                $data['text_no_results'] = $this->language->get('text_no_results');

                $data['column_query'] = $this->language->get('column_query');
                $data['column_keyword'] = $this->language->get('column_keyword');
                $data['column_action'] = $this->language->get('column_action');

                $data['button_insert'] = $this->language->get('button_insert');
                $data['button_delete'] = $this->language->get('button_delete');
                $data['button_save'] = $this->language->get('button_save');
                $data['button_cancel'] = $this->language->get('button_cancel');
                $data['button_clear_cache'] = $this->language->get('button_clear_cache');
				$data['button_edit'] = $this->language->get('button_edit');

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

                $url = '';

                if ($order == 'ASC') {
                        $url .= '&order=DESC';
                } else {
                        $url .= '&order=ASC';
                }

                if (isset($this->request->get['page'])) {
                        $url .= '&page=' . $this->request->get['page'];
                }
				
				$data['breadcrumbs'] = array();

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('text_home'),
					'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
				);

				$data['breadcrumbs'][] = array(
					'text' => $this->language->get('heading_title'),
					'href' => $this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url, 'SSL')
				);

                $data['sort_query'] = $this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . '&sort=ua.query' . $url, 'SSL');
                $data['sort_keyword'] = $this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . '&sort=ua.keyword' . $url, 'SSL');

                $url = '';

                if (isset($this->request->get['sort'])) {
                        $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                        $url .= '&order=' . $this->request->get['order'];
                }

                $pagination = new Pagination();
                $pagination->total = $url_alias_total;
                $pagination->page = $page;
                $pagination->limit = $this->config->get('config_admin_limit');
                $pagination->text = $this->language->get('text_pagination');
                $pagination->url = $this->url->link('tool/seomanager', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

                $data['pagination'] = $pagination->render();

                $data['sort'] = $sort;
                $data['order'] = $order;

				$data['header'] = $this->load->controller('common/header');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');
								
				$this->response->setOutput($this->load->view('tool/seomanager.tpl', $data));
        }

        private function validateForm() {
                if (!$this->user->hasPermission('modify', 'tool/seomanager')) {
                        $this->error['warning'] = $this->language->get('error_permission');
                }
                if (!$this->error) {
                        return true;
                } else {
                        return false;
                }
        }

        private function validateDelete() {
                if (!$this->user->hasPermission('modify', 'tool/seomanager')) {
                        $this->error['warning'] = $this->language->get('error_permission');
                }
                if (!$this->error) {
                        return true;
                } else {
                        return false;
                }
        }

        public function install() {
                $this->load->model('tool/seomanager');
                $this->model_tool_seomanager->install();

        }

        public function uninstall() {
                $this->load->model('tool/seomanager');
                $this->model_tool_seomanager->uninstall();
        }

}
?>
