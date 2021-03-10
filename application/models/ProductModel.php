<?php
defined('BASEPATH') OR exit('No direct script access allowed');
  
class ProductModel extends CI_Model{
  
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
  
  
    public function getAllProducts(){
        $this->db->from('products');
        $this->db->order_by("created", "desc");
        $query=$this->db->get();
        return $query->result();
    }
      
  
    public function getProduct($slug){
        $this->db->from('products');
        $this->db->where('slug',$slug);
        $query = $this->db->get();
        return $query->row();
    }
  
    public function save($data){
        $this->db->insert('products', $data);
       	return $this->db->insert_id();
    }
    
    public function createSlug($string =''){
		$slug = '';
		if($string != ''){
			$slug = $this->getCleanString(trim($string)); 
            $count = 0;
            while(true) {
                if (!$this->db->where('slug',$slug)->count_all_results('products')){
                     break;
                }
                $slug = $slug . '-' . (++$count);
            }
		}
		return $slug;
	}

    protected function getCleanString($string){
	    $string = str_replace(' ', '-', $string);
	    $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); 
	    return strtolower(preg_replace('/-+/', '-', $string));
    } 

    public function update($data,$slug){
        $where = array('slug' => $slug);
        $this->db->update('products', $data, $where);
        return $this->db->affected_rows();
    }
  
    public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('products');
    }
  
  
}