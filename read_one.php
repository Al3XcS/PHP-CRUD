<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatii Produs</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>
<body>
    <!-- facem un container -->
    <div class="container">
        <div class="page-header">
            <h1>Informatii Produs</h1>
        </div>
    
        <!-- Cod PHP pentru informatii produs -->
        <?php
        // trece mai departe de parametru, adica in cazul de fata ID, cand e selectat sa vezi informatiile unui specific produs
        // isset() verifica daca o valoare e acolo sau nu
        $id=isset($_GET['id']) ? $_GET['id'] : die('Eroare: ID nu a fost gasit.');

        //includem conexiunea la baza de date
        include 'config/database.php';

        //citeste informatiile produsului/id-ului selectat
        try {
            //pregatim selectarea query-ului
            $query = "SELECT id, name, description, price, image FROM products WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare( $query );

            // primul semn de intrebare
            $stmt->bindParam(1, $id);

            // executie $query
            $stmt->execute();

            // salveaza tot randul de informatii intr-o variabila
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //valori incarcare form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $image = htmlspecialchars($row['image'], ENT_QUOTES);


        }

        //arata erori
        catch(PDOException $exception) {
            die('Eroare: ' . $exception->getMessage());
        }

        ?>

        <!-- Cod HTML pentru a afisa informatiile produsului -->
        <!-- tabelul html unde ne arata produsul, informatiile din baza de date -->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Nume</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Descriere</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Pret</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Imagine</td>
                <td>
                <?php echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "Nici o imagine gasita."; ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='index.php' class='btn btn-danger'>Inapoi la produse</a>
                </td>
            </tr>
        
        </table>

    </div> <!-- aici se incheie containerul -->


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>