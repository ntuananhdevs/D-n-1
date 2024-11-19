<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/LoginController.php';
    require_once './clients/controllers/ProductsContronller.php';
 

    #require Model

    require_once './clients/models/Home.php';
    require_once './clients/models/Products.php';
    require_once './clients/models/LoginModel.php';


    $home = new HomeController();
    $login = new LoginController();
    $products = new ProductsContronller();
    

  

    $act = $_GET['act'] ?? '/';
    if($act != 'login'){
        include './clients/views/layout/header.php';
    }
        match ($act) {
            '/' => $home->view_home(),
            'login' => $login->login(),

            'products' => $products->view_products(),

            default => $home->view_home(),
        };
