<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_postingan extends CI_model{

	//fungsi check login
	public function get_data()
	{
		$this->db->select('
			u.id AS user_id,
			u.full_name AS user_nama,
			p.id AS post_id,
			p.content AS post_content,
			p.created_at AS post_waktu,
			COUNT(l.id) AS total_like
		');
		$this->db->from('postingan p');
		$this->db->join('tbl_user u', 'p.user_id = u.id');
		$this->db->join('tbl_like l', 'p.id = l.post_id', 'left');
		$this->db->group_by('p.id');
		$this->db->order_by('p.created_at', 'DESC');

		$query = $this->db->get();
		$result = $query->result_array();

		return $result;
	}
}