<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
 
class Product extends CI_Controller {
 
 
    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('ProductModel');
    }
 
 
    public function products(){
        $data['products']=$this->ProductModel->getAllProducts();
        $this->load->view('templates/header');
        $this->load->view('product/products',$data);
        $this->load->view('templates/footer');
    }
 
    
 
    public function addProduct(){
        $error =  '';
        $this->load->helper('Form');
        if($this->input->method(TRUE) == 'POST'){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[200]');
            $this->form_validation->set_rules('description','Description', 'trim|required|max_length[1000]');
            $this->form_validation->set_message('required', 'You missed the input {field}!');
            
            if ($this->form_validation->run()) {
                if(isset($_FILES['image']['name']) && !$_FILES['image']['error']){
                    $config['upload_path'] = './assets/images';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size'] = 2000;
                    $config['max_width'] = 1500;
                    $config['max_height'] = 1500;

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('image')) {
                        $error = $this->upload->display_errors();
                    } else {
                        $image = $this->upload->data();
                        $saveData['image'] = $image['file_name'];
                    }
                }
                if($error == ''){
                    $date = date('Y-m-d H:i:s');
                    $this->load->helper('security');

                    $saveData['name'] = $this->input->post('name',TRUE);
                    $saveData['slug'] = $this->ProductModel->createSlug($saveData['name']);
                    $saveData['description'] = $this->input->post('description',TRUE);
                    $saveData['created'] = $date;
                    $saveData['modified'] = $date;
                    if($this->ProductModel->save($saveData)){
                        redirect('product/products'); 
                    }
                }
            }
        }
       
        $data['error'] = $error;
        $this->load->view('templates/header');
        $this->load->view('product/addProduct',$data);
        $this->load->view('templates/footer');
    }
    

    public function editProduct($slug = ''){
        if($slug){
            $error = '';
            if($this->input->method(TRUE) == 'POST'){
            
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[200]');
                $this->form_validation->set_rules('description','Description', 'trim|required|max_length[1000]');
                $this->form_validation->set_message('required', 'You missed the input {field}!');
                
                if ($this->form_validation->run()) {

                    if(isset($_FILES['image']['name']) && !$_FILES['image']['error']){
                        $config['upload_path'] = './assets/images';
                        $config['allowed_types'] = 'gif|jpg|png';
                        $config['max_size'] = 2000;
                        $config['max_width'] = 1500;
                        $config['max_height'] = 1500;
    
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('image')) {
                            $error = $this->upload->display_errors();
                        } else {
                            $image = $this->upload->data();
                            $saveData['image'] = $image['file_name'];
                        }
                    }
                    if($error == ''){
                        $date = date('Y-m-d H:i:s');
                        $this->load->helper('security');
                        $saveData['name'] = $this->input->post('name',TRUE);
                        $saveData['description'] = $this->input->post('description',TRUE);
                        $saveData['modified'] = $date;
                        if($this->ProductModel->update($saveData,$slug)){
                            redirect('product/products'); 
                        }
                    }
                }
            }
            $data['error'] = $error;
            $data['products']=$this->ProductModel->getProduct($slug);
            $this->load->helper('Form');
            $this->load->view('templates/header');
            $this->load->view('product/addProduct',$data);
            $this->load->view('templates/footer');
        }else{
            redirect('product/products'); 
        }
    }

    public function delete($slug = ''){
        if($slug != ''){
            $product =$this->ProductModel->getProduct($slug);
            if(isset($product->id)){
                $path = FCPATH.'assets/images/'.$product->image;
                $this->ProductModel->delete($product->id);
                unlink($path);
            }
        }
        redirect('product/products'); 
    }
 
 
 
}