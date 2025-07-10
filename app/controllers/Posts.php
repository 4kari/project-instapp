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
		$data = array(
			'title' => 'posting - Instagram'
		);
		$this->load->view('part/header',$data);
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
			echo json_encode([
				'status' => 'redirect',
				'redirect_url' => base_url('login')
			]);
			return;
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
		if (!$this->session->userdata('apps_id')) {
			echo json_encode([
				'status' => 'redirect',
				'redirect_url' => base_url('login')
			]);
			return;
		}
		$post_id = $this->input->post('post_id');
		$comment = $this->input->post('comment');
		$user_id = $this->session->userdata('apps_id');

		if ($post_id && $comment && $user_id) {
			$this->db->insert('tbl_comment', [
				'post_id' => $post_id,
				'user_id' => $user_id,
				'comment' => $comment,
				'created_at' => date('Y-m-d H:i:s')
			]);
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	public function store() {
		$user_id = $this->session->userdata('apps_id');
		$content = $this->input->post('content', TRUE);
		if (!$user_id) {
			redirect('login');
		}

		if (empty(trim($content))) {
			$data['error'] = 'Isi postingan tidak boleh kosong.';
			$this->load->view('posts/create', $data);
			return;
		}

		$image_name = null;

		// 🔗 Proses Upload Gambar
		if (!empty($_FILES['image']['name'])) {
			$config['upload_path']   = './uploads/postingan/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg|webp';
			$config['max_size']      = 2048; // 2MB
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('image')) {
				$uploaded = $this->upload->data();
				$image_name = 'uploads/postingan/' . $uploaded['file_name'];
			} else {
				$data['error'] = $this->upload->display_errors();
				var_dump($config, $data);die();
				$this->load->view('part/header', $data);
				$this->load->view('layout/web/posts/posts');
				$this->load->view('part/footer');
				return;
			}
		}

		$postData = [
			'user_id'    => $user_id,
			'content'    => $content,
			'image'      => $image_name,
			'created_at' => date('Y-m-d H:i:s')
		];

		$this->load->model('M_postingan');
		$this->M_postingan->insert_post($postData);

		redirect('home');
	}
}
