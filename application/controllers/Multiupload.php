<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Multiupload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Multiple_model');
    }
    public function index()
    {
        $data['title'] = 'title';
        $data['group_image'] = $this->Multiple_model->getDataGroup();
        $this->load->view('multiupload/index', $data);
    }
    public function file()
    {
        $upload = $_FILES['image']['name'];
        if ($upload) {
            $numberOfFile = sizeof($upload);
            $files = $_FILES['image'];
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/images/';
            $this->load->library('upload', $config);
            for ($i = 0; $i < $numberOfFile; $i++) {
                $_FILES['image']['name'] = $files['name'][$i];
                $_FILES['image']['type'] = $files['type'][$i];
                $_FILES['image']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['image']['error'] = $files['error'][$i];
                $_FILES['image']['size'] = $files['size'][$i];

                $this->upload->initialize($config);
                if ($this->upload->do_upload('image')) {
                    $data = $this->upload->data();
                    $imageName = $data['file_name'];
                    $cek = $this->Multiple_model->cekData();
                    if (!$cek) {
                        $group_image = 1;
                    } else {
                        $group_image = $cek['group_image'] + 1;
                    }
                    $insert[$i]['image'] = $imageName;
                    $insert[$i]['group_image'] = $group_image;
                    $insert[$i]['date_created'] = time();
                }
            }
            if (!$insert && !$data) {
                $this->session->set_flashdata('status', 'tidak ada data yang di simpan  ');
                redirect('multiupload');
            } else {
                if ($this->Multiple_model->upload($insert, $data['file_name']) > 0) {
                    $this->session->set_flashdata('status', 'Data berhasil di simpan');
                    redirect('multiupload');
                } else {

                    $this->session->set_flashdata('status', 'error silahkan ulangi lagi');
                    redirect('multiupload');
                }
            }
        }
    }

    public function detail($group)
    {
        $data['title'] = 'title';
        $data['detail_image'] = $this->Multiple_model->detailImage($group);
        $this->load->view('multiupload/detail', $data);
    }
}
