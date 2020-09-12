<?php
class users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('users_model', 'users');
        // users is users_model alias name        
    }

    public function index()
    {
        $user_id = 1234;
        $this->data['all_image'] = $this->users->get_image($user_id);
        $this->load->view('multiple', $this->data);
    }

    public function upload_multiple()
    {
        $user_id = 1234; // session or user_id       
        if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] != '4') :
            $files = $_FILES;
            $count = count($_FILES['userfile']['name']);
            for ($i = 0; $i < $count; $i++) :
                $_FILES['userfile']['name'] = $files['userfile']['name'][$i];
                $_FILES['userfile']['type'] = $files['userfile']['type'][$i];
                $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$i];
                $_FILES['userfile']['error'] = $files['userfile']['error'][$i];
                $_FILES['userfile']['size'] = $files['userfile']['size'][$i];
                $config['upload_path'] = './uploads/gallery/';
                $target_path = './uploads/gallery/thumbs/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size'] = '10000';
                $config['remove_spaces'] = true;
                $config['overwrite'] = false;
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $this->upload->do_upload('userfile');
                $fileName = $_FILES['userfile']['name'];
                $data = array('upload_data' => $this->upload->data());
                if (!$this->upload->do_upload('userfile')) {
                    $error = array('upload_error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error',  $error['upload_error']);
                    echo $files['userfile']['name'][$i] . ' ' . $error['upload_error'];
                    exit;
                }
                $path = $data['upload_data']['full_path'];
                $q['name'] = $data['upload_data']['file_name'];
                $configi['image_library'] = 'gd2';
                $configi['source_image']   = $path;
                $configi['new_image']   = $target_path;
                $configi['maintain_ratio'] = TRUE;
                $configi['width']  = 250;
                $configi['height'] = 250;
                $this->load->library('image_lib');
                $this->image_lib->initialize($configi);
                $this->image_lib->resize();
                $images[] = $fileName;
                $image_upload = array('user_id' => $user_id, 'image' => $fileName);
                $this->db->insert('gallery', $image_upload);

            endfor;
        endif;
        redirect(site_url('users'));
    }
}
