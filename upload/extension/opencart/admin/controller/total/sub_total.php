<?php
namespace Opencart\Admin\Controller\Extension\Opencart\Total;
class SubTotal extends \Opencart\System\Engine\Controller {
	private $error = [];

	public function index(): void {
		$this->load->language('extension/opencart/total/sub_total');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('total_sub_total', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total'));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/opencart/total/sub_total', 'user_token=' . $this->session->data['user_token'])
		];

		$data['action'] = $this->url->link('extension/opencart/total/sub_total', 'user_token=' . $this->session->data['user_token']);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=total');

		if (isset($this->request->post['total_sub_total_status'])) {
			$data['total_sub_total_status'] = $this->request->post['total_sub_total_status'];
		} else {
			$data['total_sub_total_status'] = $this->config->get('total_sub_total_status');
		}

		if (isset($this->request->post['total_sub_total_sort_order'])) {
			$data['total_sub_total_sort_order'] = $this->request->post['total_sub_total_sort_order'];
		} else {
			$data['total_sub_total_sort_order'] = $this->config->get('total_sub_total_sort_order');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/opencart/total/sub_total', $data));
	}

	protected function validate(): bool {
		if (!$this->user->hasPermission('modify', 'extension/opencart/total/sub_total')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
