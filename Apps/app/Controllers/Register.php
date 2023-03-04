<?php

namespace App\Controllers;

// Memanggil Folder Models -> UserModel.php
use App\Models\UserModel;

class Register extends BaseController
{
    public function __construct(){
        helper(['form']);
    }
    public function index()
    {
        return view('register');
    }

    public function proccess()
    {
        if(!$this->validate([
            'username'   => [
                'label'  => 'Username',
                'rules'  => 'required|min_length[4]|is_unique[users.username]',
                'errors' => ['required'   => '{field} harus di isi.',
                             'min_length' => '{field} terlalu pendek',
                             'is_unique'  => '{field} sudah digunakan']
            ],
            'email'      => [
                'label'  => 'Email',
                'rules'  => 'required|min_length[4]|is_unique[users.email]|valid_email',
                'errors' => ['required'    => '{field} harus di isi.',
                             'min_length'  => '{field} terlalu pendek',
                             'is_unique'   => '{field} sudah digunakan',
                             'valid_email' => '{field} harus valid']
            ],
            'password1'  => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[4]',
                'errors' => ['required'   => '{field} harus di isi.',
                             'min_length' => '{field} terlalu pendek']
            ],
            'password2'  => [
                'label'  => 'Password',
                'rules'  => 'required|min_length[4]|matches[password1]',
                'errors' => ['required'   => '{field} harus di isi.',
                             'matches'    => '{field} tidak sama']
            ],
        ])) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }
        $users = new UserModel();
        $users->insert([
            'images'   => 'images.jpg',
            'username' => $this->request->getVar('username'),
            'email' => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password1'), PASSWORD_BCRYPT)
        ]);
        return redirect()->to('admin/');
    }
}

?>