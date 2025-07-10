<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_comment extends CI_model{
	public function insert($data) {
		$this->db->insert('tbl_comment', $data);
    }
}