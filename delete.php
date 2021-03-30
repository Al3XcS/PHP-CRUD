<?php
//includem conexiunea catre baza de date
include 'config/database.php';

try {

        //cere informatii dintr-un ID
        //verificam cu isset() daca exista ID in baza de date
        $id=isset($_GET['id']) ? $_GET['id'] : die('Eroare: Produsul nu a fost gasit');

        //query pentru stergere
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1,$id);

        if($stmt->execute()){
            //redirectioneaza pe pagina principala si anunta ca produsul s-a sters
            header('Location: index.php?action=deleted');
        }else{
            die('Nu se poate sterge informatia.');
        }


}

//arata erori
catch(PDOException $exception) {
    die('Eroare: ' . $exception->getMessage());
}
?>