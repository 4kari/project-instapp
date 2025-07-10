<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('m_postingan');
    }
	public function index()
	{
		if(!$this->session->userdata('apps_id')){
			redirect("login");
		}
		$this->load->view('part/header');
		$this->load->view('layout/web/posts/posts');
		$this->load->view('part/footer');
		//digunakan untuk menampilkan mypost
	}
	public function get_data(){
		$data = $this->m_postingan->get_data();
		echo json_encode($data);
	}
	public function likepost(){
		if(!$this->session->userdata('apps_id')){
			redirect("login");
		}
		$post_id = $this->input->post('post_id');
		$user_id = $this->session->userdata('apps_id');//userid

		// Cek apakah sudah like sebelumnya
		$cek = $this->db->get_where('tbl_like', ['post_id' => $post_id, 'user_id' => $user_id])->row();
		if (!$cek) {
			$this->db->insert('tbl_like', [
				'post_id' => $post_id,
				'user_id' => $user_id,
				'created_at' => date('Y-m-d H:i:s')
			]);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'already']);
		}
	}
	public function commentpost() {
		if(!$this->session->userdata('apps_id')){
			redirect("login");
		}
		$post_id = $this->input->post('post_id');
		$comment = $this->input->post('comment');
		$user_id = $this->session->userdata('apps_id'); // Ganti dengan session user

		$this->db->insert('tbl_comment', [
			'post_id' => $post_id,
			'user_id' => $user_id,
			'comment' => $comment,
			'created_at' => date('Y-m-d H:i:s')
		]);

		echo json_encode(['status' => 'success']);
	}
}
