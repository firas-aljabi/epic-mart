<?php
include 'db.php';

$request = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

switch ($request) {
    case '/users':
        if ($method == 'GET') {
            include 'get_users.php';
        } elseif ($method == 'POST') {
            include 'create_user.php';
        }
        break;
    case (preg_match('/\/users\/(\d+)/', $request, $matches) ? true : false):
        $id = $matches[1];
        if ($method == 'GET') {
            include 'get_user.php';
        } elseif ($method == 'PUT') {
            include 'update_user.php';
        } elseif ($method == 'DELETE') {
            include 'delete_user.php';
        }
        break;
    case '/categories':
        if ($method == 'GET') {
            include './category/get_categories.php';
        } elseif ($method == 'POST') {
            include './category/create_category.php';
        }
        break;
    case (preg_match('/\/categories\/(\d+)/', $request, $matches) ? true : false):
        $id = $matches[1];
        if ($method == 'GET') {
            include './category/get_category.php';
        } elseif ($method == 'PUT') {
            include './category/update_category.php';
        } elseif ($method == 'DELETE') {
            include './category/delete_category.php';
        }
        break;
    case '/products':
        if ($method == 'GET') {
            include 'product/get_products.php';
        } elseif ($method == 'POST') {
            include 'product/create_product.php';
        }
        break;
        case '/products-by-category':
            if ($method == 'GET') {
                include 'product/get_products_by_category.php';
            }
            break;
        
    case (preg_match('/\/products\/(\d+)/', $request, $matches) ? true : false):
        $id = $matches[1];
        if ($method == 'GET') {
            include 'product/get_product.php';
        } elseif ($method == 'PUT') {
            include 'product/update_product.php';
        } elseif ($method == 'DELETE') {
            include 'product/delete_product.php';
        }
        break;
    case '/login':
        if ($method == 'POST') {
            include 'login.php';
        }
        break;
    case '/create-admin':
        if ($method == 'POST') {
            include 'create_admin.php';
        }
        break;
    case '/register':
        if ($method == 'POST') {
            include 'register.php';
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Endpoint not found']);
        break;
}
?>
