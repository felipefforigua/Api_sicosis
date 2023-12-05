<?php

require_once "model/productModel.php";

class ProductController {
    private $_method;
    private $_complement;
    private $_data;

    function __construct($_method, $_complement, $_data){
        $this->_method = $_method;
        $this->_complement = $_complement == null ? 0 : $_complement;
        $this->_data = $_data != 0 ? $_data : "";
    }

    public function index(){
        switch($this->_method){
            case "GET":
                if($this->_complement == 0){
                    $products = ProductModel::getProductById(0);
                    $json = $products;
                    echo json_encode($json, true);
                    return;
                }
                else{
                    $product = ProductModel::getProductById($this->_complement);
                    $json = $product;
                    echo json_encode($json, true);
                    return;
                }
            case "POST":
                $createProduct = ProductModel::createProduct($this->_data);
                $json = array(
                    "response" => $createProduct
                );
                echo json_encode($json, true);
                return;
            case "UPDATE":
                $json = array(
                    "ruta:" => "update de product"
                );
                echo json_encode($json, true);
                return;
            case "DELETE":
                $json = array(
                    "ruta:" => "delete de product"
                );
                echo json_encode($json, true);
                return;
            default:
                $json = array(
                    "ruta:" => "not found"
                );
                echo json_encode($json, true);
                return;
        }
    }

    public function show() {
        $productId = is_array($this->_data) && isset($this->_data['id']) ? $this->_data['id'] : null;
    
        if ($productId) {
            $product = ProductModel::getProductById($productId);
    
            if ($product) {
                echo json_encode($product, true);
            } else {
                echo json_encode(["mensaje" => "Producto no encontrado"], true);
            }
        } else {
            echo json_encode(["mensaje" => "ID de producto no proporcionado"], true);
        }
    }
}
?>
