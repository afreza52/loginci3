<?php


class Auth extends CI_Controller
{


    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login page';
            $this->load->view('template/header', $data);
            $this->load->view('auth/login');
            $this->load->view('template/footer');
        } else {
            $this->login();
        }


    }

    public function login()
    {

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {
                //cek passord
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],

                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');

                    } else {
                        redirect('user');

                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not aktived!</div>');
                    redirect('auth');
                }
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');
            redirect('auth');
        }
    }



    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_legth' => 'Password to short'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ci3 User Registration';
            $this->load->view('template/header', $data);
            $this->load->view('auth/registration');
            $this->load->view('template/footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'img' => 'default.png',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => null,
                'date_created' => time()
            ];

            // siapkan token
            // $token = base64_encode(random_bytes(32));
            // $user_token = [
            //     'email' => $email,
            //     'token' => $token,
            //     'date_created' => time()

            // ];

            $this->db->insert('user', $data);
            // $this->db->insert('user_token', $user_token);

            // $this->sendEmail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Congratulation! your account has been created. Please activate your account. Go through admin</div>');

            redirect('auth');
        }

    }

    // public function sendEmail($token, $type)
    // {
    //     $config = [
    //         'protocol' => 'smtp',
    //         'smtp_host' => 'smtp.mailtrap.io',
    //         'smtp_user' => 'sukunn2000@gmail.com',
    //         'smtp_pass' => 'sukunn2000',
    //         'smtp_port' => 2525,
    //         'mailtype' => 'html',
    //         'charset' => 'utf-8',
    //         'newline' => "\r\n"

    //     ];
    //     , $config
    //     $this->load->library('email');

    //     $this->email->from('sukunn200@gmail.com', 'Sukun 2000');
    //     $this->email->to($this->input->post('email'));

    //     if ($type == 'verify') {
    //         $this->email->subject('Account Verification');
    //         $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');

    //     } else if ($type == 'forgot') {
    //         $this->email->subject('Reset Password');
    //         $this->email->message('Click this link to reset your password: <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');

    //     }

    //     ini_set('SMTP', 'sandbox.smtp.mailtrap.io');
    //     ini_set('smtp_port', 2525);
    //     if ($this->email->send(false)) {
    //         return true;
    //     } else {
    //         echo $this->email->print_debugger();
    //         die;
    //     }
    // }

    // public function verify()
    // {
    //     $email = $this->input->get('email');
    //     $token = $this->input->get('token');

    //     $user = $this->db->get_where('user', ['email' => $email])->row_array();
    //     if ($user) {
    //         $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

    //         if ($user_token) {
    //             if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
    //                 $this->db->set('is_active');
    //                 $this->db->where('email', $email);
    //                 $this->db->update('user');

    //                 $this->db->delete('user_token', ['email' => $email]);
    //                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="akert">' . $email . 'hasbeen activated! Plase login.</div>');
    //             } else {

    //                 $this->db->delete('user', ['email' => $email]);
    //                 $this->db->delete('user_token', ['email' => $email]);
    //                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Token expired.</div>');
    //                 redirect('auth');

    //             }
    //         } else {
    //             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Account activation failed! Wrong token</div>');
    //             redirect('auth');
    //         }
    //     } else {
    //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email</div>');
    //         redirect('auth');
    //     }
    // }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"> you have been logged out!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }


    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password ';
            $this->load->view('template/header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('template/footer');

        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                // $token = base64_encode(random_bytes(32));
                // $user_token = [
                //     'email' => $email,
                //     'token' => $token,
                // ];

                // $this->db->insert('user_token', $user_token);
                // ini_set('SMTP', 'sandbox.smtp.mailtrap.io');
                // ini_set('smtp_port', 2525);
                // $this->sendEmail($token, 'forgot');

                // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Click this link to reset your password: <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '">Reset Password</a>!</div>');

                redirect('auth/forgotpassword');

            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');
                redirect('auth/forgotpassword');
            }
        }

    }

    public function resetPassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {

            $this->session->set_userdata('reset_email', $email);
            $this->changePassword();
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset passwordd failed! Wrong email</div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        // if (!$this->session->userdata('reset_email')) {
        //     redirect('auth');
        // }
        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password ';
            $this->load->view('template/header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('template/footer');

        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login</div>');
            redirect('auth');
        }

    }
}
//     public function __construct()    
//     {
//         parent::__construct();    
//         $this->load->library('form_validation');
//         $this->load->library('session');
//     }

//     public function index()
//     {
//         if ($this->session->userdata('email')) {
//             redirect('user');    
//         }

//         $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
//         $this->form_validation->set_rules('password', 'Password', 'trim|required');

//         if ($this->form_validation->run() == false) {
//             $data['title'] = 'Login page';    
//             $this->load->view('template/header', $data);
//             $this->load->view('auth/login');
//             $this->load->view('template/footer');
//         } else {
//             $this->login();    
//         }
//     }

//     public function login()
//     {
//         $email = $this->input->post('email');    
//         $password = $this->input->post('password');

//         $user = $this->db->get_where('user', ['email' => $email])->row_array();

//         if ($user) {
//             if ($user['is_active'] == 1) {
//                 if (password_verify($password, $user['password'])) {
//                     $data = [
//                         'email' => $user['email'],    
//                         'role_id' => $user['role_id'],
//                     ];
//                     $this->session->set_userdata($data);
//                     if ($user['role_id'] == 1) {
//                         redirect('admin');    
//                     } else {
//                         redirect('user');    
//                     }
//                 } else {
//                     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password!</div>');    
//                     redirect('auth');
//                 }
//             } else {
//                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not activated!</div>');    
//                 redirect('auth');
//             }
//         } else {
//             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');    
//             redirect('auth');
//         }
//     }

//     public function registration()
//     {
//         if ($this->session->userdata('email')) {
//             redirect('user');    
//         }

//         $this->form_validation->set_rules('name', 'Name', 'required|trim');
//         $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
//             'is_unique' => 'This email has already been registered!'    
//         ]);
//         $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
//             'matches' => 'Passwords do not match!',    
//             'min_length' => 'Password is too short'
//         ]);
//         $this->form_validation->set_rules('password2', 'Password Confirmation', 'required|trim|min_length[3]|matches[password1]');

//         if ($this->form_validation->run() == false) {
//             $data['title'] = 'Ci3 User Registration';    
//             $this->load->view('template/header', $data);
//             $this->load->view('auth/registration');
//             $this->load->view('template/footer');
//         } else {
//             $email = $this->input->post('email', true);    
//             $data = [
//                 'name' => htmlspecialchars($this->input->post('name', true)),    
//                 'email' => htmlspecialchars($email),
//                 'img' => 'default.png',
//                 'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
//                 'role_id' => 2,
//                 'is_active' => 0,
//                 'date_created' => time()
//             ];

//             // Insert user data
//             $this->db->insert('user', $data);
//             $user_id = $this->db->insert_id();

//             // Prepare activation token
//             $token = base64_encode(random_bytes(32));
//             $user_token = [
//                 'user_id' => $user_id,    
//                 'token' => $token,
//                 'date_created' => time()
//             ];

//             // Insert user token
//             $this->db->insert('user_token', $user_token);

//             // Send verification email
//             $this->sendEmail($email, $token, 'verify');

//             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
//                 Congratulation! Your account has been created. Please activate your account</div>');

//             redirect('auth');
//         }
//     }

//     public function sendEmail($email, $token, $type)
//     {
//         $config = [
//             'protocol' => 'smtp',    
//             'smtp_host' => 'ssl://smtp.googlemail.com',
//             'smtp_user' => 'sukunn2000@gmail.com',
//             'smtp_pass' => 'Sukun2023',
//             'smtp_port' => 465,
//             'mailtype' => 'html',
//             'charset' => 'utf-8',
//             'newline' => "\r\n"
//         ];

//         $this->load->library('email', $config);

//         $this->email->from('sukunn2000@gmail.com', 'Sukun 2000');
//         $this->email->to($email);

//         if ($type == 'verify') {
//             $this->email->subject('Account Verification');    
//             $this->email->message('Click this link to verify your account: <a href="' . base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token) . '">Activate</a>');
//         } else if ($type == 'forgot') {
//             $this->email->subject('Reset Password');    
//             $this->email->message('Click this link to reset your password: <a href="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) . '">Reset Password</a>');
//         }

//         if ($this->email->send()) {
//             return true;    
//         } else {
//             echo $this->email->print_debugger();    
//             die;
//         }
//     }

//     public function verify()
//     {
//         $email = $this->input->get('email');    
//         $token = $this->input->get('token');

//         $user = $this->db->get_where('user', ['email' => $email])->row_array();

//         if ($user) {
//             $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();    

//             if ($user_token) {
//                 if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
//                     $this->db->set('is_active', 1);    
//                     $this->db->where('email', $email);
//                     $this->db->update('user');

//                     $this->db->delete('user_token', ['email' => $email]);
//                     $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please login.</div>');
//                 } else {
//                     $this->db->delete('user', ['email' => $email]);    
//                     $this->db->delete('user_token', ['email' => $email]);
//                     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired.</div>');
//                     redirect('auth');
//                 }
//             } else {
//                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong token.</div>');    
//                 redirect('auth');
//             }
//         } else {
//             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email.</div>');    
//             redirect('auth');
//         }
//     }

//     public function logout()
//     {
//         $this->session->unset_userdata('email');    
//         $this->session->unset_userdata('role_id');

//         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
//         redirect('auth');
//     }

//     public function blocked()
//     {
//         $this->load->view('auth/blocked');    
//     }

//     public function forgotPassword()
//     {
//         $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');    

//         if ($this->form_validation->run() == false) {
//             $data['title'] = 'Forgot Password';    
//             $this->load->view('template/header', $data);
//             $this->load->view('auth/forgot-password');
//             $this->load->view('template/footer');
//         } else {
//             $email = $this->input->post('email');    
//             $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

//             if ($user) {
//                 $token = base64_encode(random_bytes(32));    
//                 $user_token = [
//                     'email' => $email,    
//                     'token' => $token,
//                     'date_created' => time()
//                 ];

//                 $this->db->insert('user_token', $user_token);
//                 $this->sendEmail($email, $token, 'forgot');

//                 $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password!</div>');
//                 redirect('auth/forgotpassword');
//             } else {
//                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered or activated!</div>');    
//                 redirect('auth/forgotpassword');
//             }
//         }
//     }

//     public function resetPassword()
//     {
//         $email = $this->input->get('email');    
//         $token = $this->input->get('token');

//         $user = $this->db->get_where('user', ['email' => $email])->row_array();

//         if ($user) {
//             $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();    

//             if ($user_token) {
//                 $this->session->set_userdata('reset_email', $email);    
//                 $this->changePassword();
//             } else {
//                 $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');    
//                 redirect('auth');
//             }
//         } else {
//             $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');    
//             redirect('auth');
//         }
//     }

//     public function changePassword()
//     {
//         if (!$this->session->userdata('reset_email')) {
//             redirect('auth');    
//         }

//         $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
//         $this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|min_length[3]|matches[password1]');

//         if ($this->form_validation->run() == false) {
//             $data['title'] = 'Change Password';    
//             $this->load->view('template/header', $data);
//             $this->load->view('auth/change-password');
//             $this->load->view('template/footer');
//         } else {
//             $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);    
//             $email = $this->session->userdata('reset_email');

//             $this->db->set('password', $password);
//             $this->db->where('email', $email);
//             $this->db->update('user');

//             $this->session->unset_userdata('reset_email');

//             $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please login.</div>');
//             redirect('auth');
//         }
//     }
// }
