<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_modal extends CI_Model
{
    public function editmenu()
    {
        $data = [
            "menu" => $this->input->post('menu', true)
        ];
        $this->db->where('id',$this->input->post('id'));
        $this->db->update('user_sub_menu',$data);
    }

    public function deletemenu($id)
    {
      $this->db->where('id',$id);
      $this->db->delete('user_menu');
    }

    public function getSubMenu()
    {
        $query = "SELECT user_sub_menu.*, user_menu.menu 
          FROM user_sub_menu 
          JOIN user_menu ON user_sub_menu.menu_id = user_menu.id";
        return $this->db->query($query)->result_array();
    }


}