<?php

namespace App\Controllers;

// Memanggil Folder Models -> UserModel.php
use App\Models\UserModel;

class Admin extends BaseController
{
    public function __construct(){
        helper(['form']);
    }
    public function index()
    {
        return view('admin/login');
    }

    public function proccess()
    {
        $users = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $dataUser = $users->where([ 'email' => $email])->first();
        if ($dataUser) {
            if (password_verify($password, $dataUser['password'])) {
                session()->set([
                    'id'    => $dataUser['id'],
                    'email' => $dataUser['email'],
                    'username' => $dataUser['username'],
                    'logged_in' => TRUE
                ]);
                return redirect()->to(base_url('/'));
            } else {
                session()->setFlashdata('error', 'Email tidak ditemukan');
                return redirect()->back();
            }
        } else {
            session()->setFlashdata('error', 'Email atau Password Salah');
            return redirect()->back();
        }
    }

    function logout()
    {
        session()->destroy();
        return redirect()->to('admin/');
    }
}