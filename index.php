<?php
    require_once './commons/env.php';
    require_once './commons/core.php';

    #require Controller
    require_once './clients/controllers/HomeController.php';
    require_once './clients/controllers/AuthController.php';
    require_once './clients/controllers/ProductsContronller.php';
    require_once './clients/controllers/ResultController.php';
    require_once './clients/controllers/PayController.php';
    require_once './clients/controllers/SpCartContronller.php';


    #require Model
    require_once './clients/models/Home.php';
    require_once './clients/models/Products_details.php';
    require_once './clients/models/Result.php';
    require_once './clients/models/Pay.php';
    require_once './clients/models/ShoppingCart.php';
    require_once './clients/models/AuthModel.php';
    require_once './clients/models/Comments.php';

    $home = new HomeController();
    $result = new ResultController();
    $pay = new PayController();
    $shoppingCart = new ShoppingCartController();
    $auth = new AuthController();
    $products = new ProductsContronller();

    $act = $_GET['act'] ?? '/';

    $title = match ($act) {
        'login' => 'Login',
        'register' => 'Register',
        'logout' => 'Logout',
        '/' => 'Home',
        'product_detail' => 'Product Details',
        'shoppingcart' => 'WinTech Cart',
        'phone' => 'Phones',
        'result' => 'Search Results',
        'add_comment' => 'Add Comment',
        'add_review' => 'Add Review',
        default => 'Home',
    };

    if ($act == 'login') {
        $auth->login();
    } else if ($act == 'register') {
        $auth->register();
    } else if ($act == 'logout') {
        $auth->logout();
    } else {
        include './clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_home(),

            'product_detail' => $products->view_products($_GET['id']),
            'add_to_cart' => $products->addToCart(),
            'shoppingcart' => $shoppingCart->view_shoppingCart(),
            'pay' => $pay->view_pay(),
            'add_review' => $products->addReview($_POST),
            'result' => $result->view_result(),

            default => $home->view_home(),
        };
        include './clients/views/layout/footer.php';
    }