<?php
require_once "ConDB.php";

class ProductModel {
    static public function createProduct($data){
        $query = "INSERT INTO products(products_usuario_id, products_ruta_imagen, products_descripcion, products_tallas_disponibles, products_precio) 
            VALUES (:products_usuario_id, :products_ruta_imagen, :products_descripcion, :products_tallas_disponibles, :products_precio)";
        
        $stament = Conection::connection()->prepare($query);
        $stament->bindParam(":products_usuario_id", $data["products_usuario_id"], PDO::PARAM_INT);
        $stament->bindParam(":products_ruta_imagen", $data["products_ruta_imagen"], PDO::PARAM_STR);
        $stament->bindParam(":products_descripcion", $data["products_descripcion"], PDO::PARAM_STR);
        $stament->bindParam(":products_tallas_disponibles", $data["products_tallas_disponibles"], PDO::PARAM_STR);
        $stament->bindParam(":products_precio", $data["products_precio"], PDO::PARAM_STR);
        $message = $stament->execute() ? "ok" : Conection::connection()->errorInfo();

        $stament->closeCursor();
        $stament = null;

        return $message;
    }

    static public function getProductById($id){
        $query = "SELECT * FROM products WHERE products_id = :id";

        $stament = Conection::connection()->prepare($query);
        $stament->bindParam(":id", $id, PDO::PARAM_INT);
        $stament->execute();

        $result = $stament->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

}
?>
