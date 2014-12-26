<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
		$this->load->model('task_model', '', TRUE);
		
		# user restriction
		if ($this->session->userdata('logged_in')):
			if($this->module_management->module_active('module_active') == FALSE):redirect('messages/error/module_inactive');endif;
			if($this->user_access->level('user_access')==0):redirect('messages/error/not_authorized');endif;
		else:
			redirect('user/pin_login'); 	
		endif;
    }
	
	public function index()
	{
		redirect('tms/task/manage', 'REFRESH');
	}
	
	public function add()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		$data['master_id'] = $this->input->post('master_id');
		$data['parent_id'] = $this->input->post('parent_id');
		$data['main_field'] = $this->uri->segment(4, "master");
		# get option data
		$data['list_cat'] = $this->task_model->get_task_category();
		if($data['master_id'] > 0){$data['cat'] = $this->task_model->get_task_master_category($data["master_id"]);}
		else{$data['cat'] = "";}
		if($data['main_field'] == "master"){$this->load->view("add_task_master",$data);}
		else{$this->load->view("add_task",$data);}
	}
	
	public function save_task()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;

		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_id = $session_data['ui_id'];
		$data['ui_id'] = $ui_id;
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_master_id' => $this->input->post('task_master_id'),
			'task_status' => 'open',
			'task_name' => $this->input->post('task_name'),
			'task_category' => $this->input->post('task_category'),
			'task_point' => $this->input->post('task_point'),
			'task_sch_start' => $this->input->post('task_sch_start'),
			'task_sch_finish' => $this->input->post('task_sch_finish'),
			'task_sch_duration' => $this->input->post('task_sch_duration'),
			'task_description' => $this->input->post('task_description'), 
			'task_created' => $ui_id, 
			'task_created_by' => $ui_nama, 
			'task_created_on' => date("Y-m-d H:i:s"), 
 			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
 		);
		$task_id = $this->task_model->save_data("task",$data);
		
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "open", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	
	function take()
	{
		# xreada user restriction [ x=0 r=10 a=30 e=40 d=40 a=50 ]
		if($this->user_access->level('user_access')<30):redirect('messages/error/not_authorized');endif;
		$task_id = $this->input->post("task_id");
		
		# get data from session
		$session_data = $this->session->userdata('logged_in');
		  
		# data
		$ui_nama = $session_data['ui_nama'];
		$data['ui_nama'] = $ui_nama;
		$ui_nipp = $session_data['ui_nipp'];
		$data['ui_nipp'] = $ui_nipp;
		
		$data = array(
			'task_status' => "take", 
			'task_update_by' => $ui_nama, 
			'task_update_on' => date("Y-m-d H:i:s"), 
			'task_taken' => $ui_id, 
			'task_taken_by' => $ui_nama, 
			'task_taken_on' => date("Y-m-d H:i:s"), 
 		);
		$where = array(
			'task_id'	=>	$task_id, 
		);
		$this->task_model->update_data("task_access",$data,$where);
		
		$data = array(
			'tsh_task_id' => $task_id, 
			'tsh_status' => "take", 
			'tsh_update_by' => $ui_nama, 
			'tsh_update_on' => date("Y-m-d H:i:s"), 
		);
		$this->task_model->save_data("task_status_history",$data);
		redirect('task/manage/','refresh');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */