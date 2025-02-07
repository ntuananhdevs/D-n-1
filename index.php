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
    require_once './clients/controllers/ProfileController.php';
    require_once './clients/controllers/OrderController.php';


    #require Model
    require_once './clients/models/Home.php';
    require_once './clients/models/Products_details.php';
    require_once './clients/models/Result.php';
    require_once './clients/models/Pay.php';
    require_once './clients/models/ShoppingCart.php';
    require_once './clients/models/AuthModel.php';
    require_once './clients/models/Comments.php';
    require_once './clients/models/ProfileModel.php';
    require_once './clients/models/MailService.php';


    $home = new HomeController();
    $result = new ResultController();
    $pay = new PayController();
    $shoppingCart = new ShoppingCartController();
    $auth = new AuthController();
    $products = new ProductsContronller();
    $profile = new ProfileController();
    $order = new OrderController();


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
        'profile' => 'Profile',
        'update-avatar' => 'Update Avatar',  
        'loadbuy' => 'Chờ một chút',
        'update_profile' => 'Update Profile',
        'get_districts' => $pay->getDistrictsJson(),
        'get_wards' => $pay->getWardsJson(),
        'orders' => 'Theo dõi đơn hàng',
        'order_detail' => 'Chi tiết đơn hàng',
        default => 'Home',
    };
    
    if ($act == 'login') {
        $auth->login();
    } else if ($act == 'register') {
        $auth->register();
    } else if ($act == 'logout') {
        $auth->logout();
    } else if($act == 'changer_password') {
        $auth->changePassword();
    } else if($act == 'changepassword') {
        $auth->changePassword_action();
    }
    else if ($act == 'update-avatar') {  
        $profile->updateAvatar(); 
    } else {
        include './clients/views/layout/header.php';
        match ($act) {
            '/' => $home->view_landing_page(),
            'home' => $home->view_home(),
            'product_detail' => $products->view_products($_GET['id']),
            'add_to_cart' => $products->addToCart(),
            'add_to_cart_now' => $products->addToCartNow(),
            'shoppingcart' => $shoppingCart->view_shoppingCart(),
            'update_cart' => $shoppingCart->updateQuantity(),
            'delete_items' => $shoppingCart->deleteItem($_GET['product_id']),
            'update_like_dislike' => $products->updateLikeDislike(),
            'profile' => $profile->showProfile($_GET['user_id'] ?? null),
            'pay' => $pay->view_pay(),
            'order' => $pay->add_order(),
            'loadbuy' => $pay->loadbuy(),
            'add_review' => $products->addComment($_POST),
            'result' => $result->view_result(),
            'apple_products' => $home->view_apple_products($_GET['id']),
            'update_profile' => $profile->updateProfile(),
            'get_districts' => $pay->getDistrictsJson(),
            'get_wards' => $pay->getWardsJson(),
            'orders' => $order->viewOrders(),
            'cancel_order' => $order->cancelOrder(),
            'return_order' => $order->returnOrder(),
            'order_detail' => $order->viewOrderDetail($_GET['id']),
            default => $home->view_home(),
        };
        include './clients/views/layout/footer.php';
    }