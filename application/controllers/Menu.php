<?php

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in(); 
    }
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();


        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run()== false) {
            $this->load->view('template/user_header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('menu/index',$data);
            $this->load->view('template/user_footer');
            
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }
    public function editmenu($id)
    {   
    
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();
           // Mendapatkan data menu berdasarkan ID
        $data['menu'] = $this->db->get_where('user_menu', array('id' => $id))->row_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan halaman edit dengan data menu
            $this->load->view('template/user_header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('menu/edit', $data);
            $this->load->view('template/user_footer');
        } else {
            // Jika validasi berhasil, lakukan proses pembaruan menu
            $menu = $this->input->post('menu');

          // Melakukan pembaruan menu pada database
            $this->db->where('id', $id);
            $this->db->update('user_menu', array('menu' => $menu));

            $this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">Edit Menu Success!</div>');
            redirect('menu');
        }

    }
    
    public function deletemenu($id)
    {
        $menu = $this->db->get_where('user_menu', array('id' => $id))->row_array();
        // Melakukan proses penghapusan menu
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
        $this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">Delete menu Success!</div>');
        redirect('menu');
    }
    
    
    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_modal', 'menu');
        
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
        
        if ($this->form_validation->run()== false){
            $this->load->view('template/user_header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('menu/submenu',$data);
            $this->load->view('template/user_footer');
            
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message3', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('menu/submenu');
        }
        
    }
    public function editsubmenu($id)
    {   
    
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_modal', 'menu');
        
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['user'] = $this->db->get_where('user', ['email'=> $this->session->userdata('email')])->row_array();
           // Mendapatkan data submenu berdasarkan ID
        $data['subMenu'] = $this->db->get_where('user_sub_menu', array('id' => $id))->row_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan halaman edit dengan data submenu
            $this->load->view('template/user_header',$data);
            $this->load->view('template/sidebar',$data);
            $this->load->view('template/topbar',$data);
            $this->load->view('menu/submenuedit', $data);
            $this->load->view('template/user_footer');
        } else {
            // Jika validasi berhasil, lakukan proses pembaruan submenu
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];

          // Melakukan pembaruan submenu pada database
            $this->db->where('id', $id);
            $this->db->update('user_sub_menu',  $data);

            $this->session->set_flashdata('message2', '<div class="alert alert-success" role="alert">Edit SubMenu Success!</div>');
            redirect('menu/submenu');
        }

    }
    public function deletesubmenu($id)
    {
        $subMenu = $this->db->get_where('user_sub_menu', array('id' => $id))->row_array();
        // Melakukan proses penghapusan submenu
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message3', '<div class="alert alert-success" role="alert">Delete submenu Success!</div>');
        redirect('menu/submenu');
    }
}