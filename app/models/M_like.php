<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_like extends CI_model{
	public function get_data_byid($post_id, $user_id){
		$data = $this->db->get_where('tbl_like', ['post_id' => $post_id, 'user_id' => $user_id])->row();
		return $data;
	}
	public function insert($post_id,$user_id) {
        $this->db->insert('tbl_like', [
				'post_id' => $post_id,
				'user_id' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
			]);
    }
}