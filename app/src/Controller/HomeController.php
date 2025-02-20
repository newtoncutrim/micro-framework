<?php

namespace App\Controller;

use App\Helper\View;
use App\ORM\ORM;

class HomeController
{
    public function __construct(public ORM $orm)
    { }
    public function index()
    {
        $users = $this->orm->all();
        $data = ['users' => $users];

        View::render('home', $data);
    }


    public function about()
    {
        echo "Esta é a página Sobre do HomeController!";
    }

    public function user($id)
    {
        echo "Bem-vindo, usuário com ID: $id";
    }

    public function post($id, $slug)
    {
        echo "Post ID: $id, Slug: $slug";
    }
}
