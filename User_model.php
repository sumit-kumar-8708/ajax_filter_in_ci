<?php
class User_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function ajax_user_list($iDisplayStart, $iDisplayLength, $sorting, $sSearch, $sEcho, $bSearchable, $custom_search = array())
	{
		$user_filters = $this->session->userdata('user_filter');
		$this->db->select('count(users.id) as total');
		$this->db->from('users');
		$this->db->join('users_product_map', 'users.id=users_product_map.user_id');
		$this->db->where('users_product_map.domain_id', $_SESSION['domain_registration_id']);
		// 1st place:
		if ($user_filters) {
			if ($user_filters['email_phone']) {
				$this->db->group_start();
				$this->db->where('users.email', trim($user_filters['email_phone']));
				$this->db->or_where('users.phone', trim($user_filters['email_phone']));
				$this->db->or_where('users.id', trim($user_filters['email_phone']));
				$this->db->group_end();
			}
			if ($user_filters['user_type']) {
				$this->db->where('users.user_type', $user_filters['user_type']);
			}
			if ($user_filters['status']) {
				$this->db->where('users_product_map.status', ($user_filters['status']-1));
			}
		}

		$query = $this->db->get();

		$result = $query->row();
		$iTotalRecords = $result->total;
		$this->db->select('count(users.id) as total');
		$this->db->from('users');
		$this->db->join('users_product_map', 'users.id=users_product_map.user_id');
		$this->db->where('users_product_map.domain_id', $_SESSION['domain_registration_id']);
		//2 nd place :
		if ($user_filters) {
			if ($user_filters['email_phone']) {
				$this->db->group_start();
				$this->db->where('users.email', trim($user_filters['email_phone']));
				$this->db->or_where('users.phone', trim($user_filters['email_phone']));
				$this->db->or_where('users.id', trim($user_filters['email_phone']));
				$this->db->group_end();
			}
			if ($user_filters['user_type']) {
				$this->db->where('users.user_type', $user_filters['user_type']);
			}
			if ($user_filters['status']) {
				$this->db->where('users_product_map.status', ($user_filters['status']-1));
			}
		}

		if ($sSearch) {
			$this->db->group_start();
			$this->db->like('users.id', $sSearch);
			$this->db->or_like('name', $sSearch);
			$this->db->group_end();
		}

		$query = $this->db->get();

		$result = $query->row();
		$iTotalDisplayRecords = $result->total;

		$this->db->select('users.*,users_product_map.status as map_status');
		$this->db->from('users');
		$this->db->join('users_product_map', 'users.id=users_product_map.user_id');
		$this->db->where('users_product_map.domain_id', $_SESSION['domain_registration_id']);

		// 3rd place :
		if ($user_filters) {
			if ($user_filters['email_phone']) {
				$this->db->group_start();
				$this->db->where('users.email', trim($user_filters['email_phone']));
				$this->db->or_where('users.phone', trim($user_filters['email_phone']));
				$this->db->or_where('users.id', trim($user_filters['email_phone']));
				$this->db->group_end();
			}
			if ($user_filters['user_type']) {
				$this->db->where('users.user_type', $user_filters['user_type']);
			}
			if ($user_filters['status']) {
				$this->db->where('users_product_map.status', ($user_filters['status']-1));
			}
		}

		if ($sSearch) {
			$this->db->group_start();
			$this->db->like('users.id', $sSearch);
			$this->db->or_like('users.name', $sSearch);
			$this->db->group_end();
		}

		foreach ($sorting as $key => $sort) {
			if ($key == 1) {
				$this->db->order_by('users.id',	$sort);
			} else {
				$this->db->order_by('users.id', 'DESC');
			}
		}
		$this->db->order_by('users.id', 'desc');

		$this->db->limit($iDisplayLength, $iDisplayStart);
		$query = $this->db->get();

		$result = $query->result();
		// print_r($result);

		$aaData	=	array();

		$key = $iDisplayStart;
		foreach ($result as $key => $row) {
			$status = '';
			$userType = '';

			if ($row->map_status == 1) {
				$status = '<a href="user/user_active_deactive/' . $row->id . ' " >Active</a>';
			} else {
				$status = '<a href="user/user_active_deactive/' . $row->id . '">Deactive</a>';
			}

			// userType condition
			if ($row->user_type == 1) {
				$userType =  "Admin";
			} else if ($row->user_type == 2) {
				$userType = "Staff Academic";
			} else if ($row->user_type == 3) {
				$userType = "Mentor";
			} else if ($row->user_type == 4) {
				$userType = "Student";
			} else {
				$userType = "Staff Counsellor";
			}

			$edit = '<a href="' . base_url() . 'user/edit_user/' . $row->id . '" class="btn btn-sm text-white" style="background-color: #0f8493" title="Edit User"> <i class="fa fa-pencil" aria-hidden="true"></i></a>';
			$information = '<a href="' . base_url() . 'user/details/' . $row->id . '" class="btn btn-sm text-white" title="User Info" style="background-color: rgba(26, 131, 147 );"  >  <i class="fa fa-info" aria-hidden="true"></i></a>';
			$map = ' <a href="' . base_url() . 'user/user_assign_course/' . $row->id . '" class="btn btn-sm text-white" style="background-color:#1094a4" title=" Exam Map">Assign <i class="fa fa-plus-circle" aria-hidden="true"></i></a>';
			$reset = ' <a href="' . base_url() . 'user/user_reset_password/' . $row->id . '"  onclick="return confirm(\'Are You Sure to Reset this User?\')" class="btn btn-sm text-white" style="background-color: rgba(26, 131, 147 );" title=" Reset User">Pwd <i class="fa fa-exchange" aria-hidden="true"></i></a>';
			$delete = ' <a  href="' . base_url() . 'user/delete/' . $row->id . '" onclick="return confirm(\'Do you really want to delete this User?\')" class="btn btn-sm btn-danger text-white" title="Delete User"><i class="fa fa-trash" aria-hidden="true"></i></a>';

			$aaData[]	=	array(
				$key + 1,
				// $row->id,
				$row->name,
				$row->email,
				$row->phone,
				$status,
				$userType,
				$edit . ' ' . $information . '' . $map . '' . $reset . '' . $delete,

			);
		}

		$output	= array(
			"sEcho"		=> 	$sEcho,
			"iTotalRecords"	=>	$iTotalRecords,
			"iTotalDisplayRecords" 	=>	$iTotalDisplayRecords,
			"aaData"	=>	$aaData
		);

		return	$output;
	}
?>