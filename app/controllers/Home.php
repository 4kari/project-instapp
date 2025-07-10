<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('m_postingan');
    }
	public function index()
	{
		//buat variabel data array
		$data = array(
			'title' => 'Home - Instagram',
			'datapost' => $this->getdatapost()
		);
		//load view dengan data
		$this->load->view('part/header', $data);
		$this->load->view('layout/web/home/data');
		$this->load->view('part/footer');
	}
	public function getdatapost(){
		$data = $this->m_postingan->get_data();
		return $data;
	}
}
