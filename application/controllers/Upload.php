<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Upload_model');
    }

    public function index()
    {
        $data['images'] = $this->Upload_model->getData();
        $this->load->view('index', $data);
    }

    public function file($type)
    {
        $upload = $_FILES['image']['name'];
        if ($upload) {
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/image/';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $imageName = $this->upload->data('file_name');
                $config['image_library'] = 'gd2';
                $config['source_image'] = './assets/image/' . $imageName;
                $config['crate_thumb'] = false;
                $config['maintain_ratio'] = false;
                $config['quality'] = '100%';
                $config['width'] = 600;
                $config['height'] = 350;
                $config['new_image'] = './assets/image/' . $imageName;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                $data = [
                    'id'  => $this->input->post('id'),
                    'image' => $imageName,
                    'date_created' => time()
                ];
                if ($type == 'edit') {
                    $oldimage = $this->Upload_model->getImageById($data['id']);
                    unlink('./assets/image/' . $oldimage['image']);
                }
                if ($this->Upload_model->upload_image($data, $type) > 0) {
                    $this->session->set_flashdata('status', 'success');
                    redirect('upload');
                } else {
                    $this->session->set_flashdata('status', 'tidak bisa menghubungkan ke database');
                    redirect('upload');
                };
            } else {
                $this->session->set_flashdata('status', $this->upload->display_errors());
                redirect('upload');
            }
        } else {
            $this->session->set_flashdata('status', 'tidak ada gambar yang diupload');
            redirect('upload');
        }
    }

    public function edit($id)
    {
        $data['byId'] = $this->Upload_model->getImageById($id);
        $this->load->view('edit', $data);
    }

    public function delete($id)
    {
        $oldimage = $this->Upload_model->getImageById($id);
        unlink('./assets/image/' . $oldimage['image']);
        if ($this->Upload_model->delete($id) > 0) {
            $this->session->set_flashdata('status', 'Sukses hapus');
            redirect('upload');
        } else {
            $this->session->set_flashdata('status', 'delete gagal silahkan ulangi kembali');
            redirect('upload');
        }
    }
}
