<?php
$rutasArray = explode("/", $_SERVER['REQUEST_URI']);
$inputs = array();
$inputs['raw_inputs'] = @file_get_contents('php://input');
$_POST = json_decode($inputs['raw_inputs'], true);

if (count(array_filter($rutasArray)) < 2) {
    $json = array(
        "ruta:" => "not found"
    );
    echo json_encode($json, true);
    return;
} else {
    //Endpoint correctos
    $endPoint = array_filter($rutasArray)[2];
    //Si existe la posicion 3
    $complement = (array_key_exists(3, $rutasArray)) ? ($rutasArray)[3] : 0;
    $add = (array_key_exists(4, $rutasArray)) ? ($rutasArray)[4] : "";
    //EL PUNTO SIRVE PARA CONCATENAR
    if ($add != "")
        $complement .= "/" . $add;
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($endPoint) {
        case 'users':
            if (isset($_POST)) {
                $user = new UserController($method, $complement, $_POST);
            } else {
                $user = new UserController($method, $complement, 0);
            }
            $user->index();
            break;
        case 'login':
            if (isset($_POST) && $method == 'POST') {
                $user = new LoginController($method, $_POST);
                $user->index();
            } else {
                $json = array(
                    "ruta:" => "not found"
                );
                echo json_encode($json, true);
                return;
            }
            break;
        case 'products':
            if ($method == 'POST' && isset($_POST)) {
                $productController = new ProductController($method, $complement, $_POST);
                $productController->index();
            } elseif ($method == 'GET' && isset($rutasArray[3]) && is_numeric($rutasArray[3])) {
                // Manejar solicitud GET para un producto con ID específico
                $productId = intval($rutasArray[3]);
                $productController = new ProductController($method, $complement, ['id' => $productId]);
                $productController->show();
            } else {
                $json = ["error" => "Route not found", "method" => $method, "rutasArray" => $rutasArray];
                echo json_encode($json, true);
            }
        break;
        default:
            $json = array(
                "ruta:" => "not fond"
            );
            echo json_encode($json, true);
            return;
    }
}
?>