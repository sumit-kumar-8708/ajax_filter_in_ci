<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		$this->load->model('user_model');
		$this->load->model('Dashboard_model', 'Dashboard');		
		if (!($_SESSION['user_id'] > 0 && $_SESSION['is_admin'] && $_SESSION['user_type'] == 1)) {
			// print_r($_SESSION);
			redirect('auth/login');
		}			
		$domain_name = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
		$domain_details = $this->Auth_model->get_domain_details_by_name($domain_name);
		if ($domain_details->status < 1) {
			redirect('Deactive_account');
		}
	}

	public function index()
	{		
		$data = array();
		$this->load->model('user_model');
		$result = $this->user_model->getalldata();
		$data['result'] = $result;

        // filter start
		if ($this->input->post()) {
			$post_data = $this->input->post();
			$this->session->set_userdata('user_filter', $post_data);
		}
        // filter end

		$data['menu_active'] = $this->uri->segment(1);
		$this->load->view('include/header_new', $data);
		$this->load->view('users/user_list', $data);
		$this->load->view('include/footer_new');
	}
	
	public function reset_user_filter()
	{
		$_SESSION['user_filter'] = null;
		redirect('user');
	}

?>
