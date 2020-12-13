<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peta extends MY_Controller
{
    public function __construct()
	{
        parent::__construct();

        // untuk load model
        $this->load->model('m_kecamatan');
	}

    // fungsi default
    public function index()
    {
        $data = [
            'halaman' => 'Peta',
            'css'     => 'admin/peta/css/view',
            'content' => 'admin/peta/view',
            'js'      => 'admin/peta/js/view'
        ];

        $this->load->view('admin/base', $data);
    }

    // untuk ambil data kecamatan
    public function get_peta()
    {
        $result = $this->m_kecamatan->getAll();

        // untuk response
        $this->_response($result);
    }

    // untuk ambil detail kecamatan
    public function get_peta_detail()
    {
        $kd_kecamatan = $this->input->get('kd_kecamatan');

        $data['kecamatan'] = $this->m_kecamatan->getWhere($kd_kecamatan);

        $this->load->view('admin/peta/detail', $data);
    }
}
