<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica/Editeaza</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>

   <!-- facem un container -->
   <div class="container">
    <div class="page-header">
        <h1>Modifica Produs</h1>
    </div>
    <!-- Cod php pentru citit ID/informatii produs din baza de date -->
    <?php
    //transmite informatiile produsului in cazul nostru in functie de ID
    // cu isset() verificam daca informatia exista in baza de date
    $id=isset($_GET['id']) ? $_GET['id'] : die('Eroare: Produsul nu a fost gasit.');

    //adaugam conexiunea / fisierul cu legatura principala la baza de date
    include 'config/database.php';

    //citeste informatiile unui produs
    try {
        //pregatim query cu selectia
        $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
        $stmt = $con->prepare( $query );

        // primul semn de intrebare
        $stmt->bindParam(1, $id);

        //executa query
        $stmt->execute();

        //salveaza tot randul de informatii intr-o variabila
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // valorile care se incarca in formular
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    }
    //arata erori
    catch(PDOException $exception) {
        die('Eroare: ' . $exception->getMessage());
    }
    ?>


    <!-- COD PHP pentru a modifica informatiile transmise printr-un formular unui produs din baza de date  -->
    <?php

    //verifica daca formularul a fost completat
    if($_POST) {

        try{

                //scrie update la query
                //in cazul de fata avem prea multe campuri de transmis si e mai bine sa le etichetam si sa nu folosim semne de intrebare
                $query = "UPDATE products
                                SET name=:name, description=:description, price=:price
                                WHERE id = :id";

                // pregatim query pentru executie
                $stmt = $con->prepare($query);
                
                // valorile/informatiile introduse
                $name=htmlspecialchars(strip_tags($_POST['name']));
                $description=htmlspecialchars(strip_tags($_POST['description']));
                $price=htmlspecialchars(strip_tags($_POST['price']));

                //facem bind la parametrii
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':id', $id);

                //executam query
                if($stmt->execute()) {
                    echo "<div class='alert alert-success'>Informatiile au fost modificate.</div>";
                }else{
                    echo "<div class='alert alert-danger'>Informatiile nu au fost modificate, mai baga o fisa.</div>";
                }
        }

        //arata erori
        catch(PDOException $exception) {
            die('Eroare: ' . $exception->getMessage());
        }

    }
    ?>

    <!-- cod/form html pentru a modifica informatii -->

    <!-- adaugam codul formularului folosit pentru a modifica datele unui produs din baza de date -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Nume</td>
                <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES); ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td>Descriere</td>
                <td> <textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea> </td>
            </tr>
            <tr>
                <td>Pret</td>
                <td> <input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES); ?>" class='form-control' /></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type='submit' value='Salveaza Modificarile' class='btn btn-primary' />
                    <a href='index.php' class='btn btn-danger'>Inapoi la produse</a>
                </td>
            </tr>
        </table>
    </form>

   </div> <!-- pana aici se intinde containerul -->
    <!-- includem plugin Javascript si bootrstrap javascript -->
   <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>