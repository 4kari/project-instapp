<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_postingan extends CI_model{

	public function get_data()
	{
		$this->db->select('
			u.id as user_id,
			u.full_name as user_nama,
			p.id as post_id,
			p.content as post_content,
			p.created_at as post_waktu,
			p.image,
			COUNT(l.id) as total_like
		');
		$this->db->from('postingan p');
		$this->db->join('tbl_user u', 'p.user_id = u.id');
		$this->db->join('tbl_like l', 'p.id = l.post_id', 'left');
		$this->db->group_by('p.id');
		$this->db->order_by('p.id', 'DESC');

		$posts = $this->db->get()->result();

		$finalPosts = [];
		foreach ($posts as $p) {
			// Ambil komentar terbaru dari tbl_comment
			$comments = $this->db
							->select('c.comment, u.full_name')
							->from('tbl_comment c')
							->join('tbl_user u', 'c.user_id = u.id')
							->where('c.post_id', $p->post_id)
							->order_by('c.created_at', 'DESC')
							->limit(3)
							->get()
							->result();

			$p->comments = $comments;
			$finalPosts[] = $p;
		}
		return $finalPosts;
	}
	public function insert_post($data) {
        return $this->db->insert('postingan', $data);
    }
}