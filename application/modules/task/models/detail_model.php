<?php
class Detail_model extends CI_Model
{
	
# constructor	
	function __construct()
	{
        parent::__construct();
    }
	
	public function get_detail_task($task_id)
	{
		$query = " SELECT * FROM task WHERE task_id = $task_id ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_history_task($task_id)
	{
		$query = " SELECT * FROM task_status_history WHERE tsh_task_id = $task_id ORDER BY tsh_id DESC";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_discussion_task($task_id)
	{
		$query = " SELECT * FROM task_discussion WHERE td_task_id = $task_id ORDER BY td_id DESC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_file_task($task_id)
	{
		$query = " SELECT * FROM task_file WHERE tf_task_id = $task_id ORDER BY tf_id ASC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	public function get_child_task($task_id)
	{
		$query = " SELECT * FROM task WHERE task_parent_id = $task_id ORDER BY task_id ASC ";
		$query = $this->db->query($query);
		return $query->result();
	}
	
	# insert data
	public function save_data($tabel,$data)
	{
		$this->db->insert($tabel,$data);
		return $this->db->insert_id();
	}
	
	# update data
	public function update_data($tabel,$data,$where)
	{
		$this->db->where($where);
		$this->db->update($tabel,$data);
	}
	
	# delete data
	public function delete_data($tabel,$where)
	{
		$this->db->where($where);
		$this->db->delete($tabel);
	}
	
	
	
}