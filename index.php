<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C.R.U.D</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- css intern -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>


</head>

<body>

    <!-- facem un container -->
    <div class="container">
        <div class="page-header">
            <h1>Vezi produs</h1>
        </div>

        <!-- Codul php pentru a citi produsele -->
        <?php
        //includem conexiunea la baza de date
        include 'config/database.php';
        //Variabile "Pagination" avem pagina curenta, in cazul nici unei actiuni, pagina default este 1
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        
        //setam cate randuri de produse vrem sa avem pe o pagina
        $records_per_page = 4;

        //calcul pentru limita query
        $from_record_num = ($records_per_page * $page) - $records_per_page;

        //mesajul de stergere
        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // daca e redirectionat de pe pagina delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Produsul a fost sters.</div>";
        }

        //selectam toate informatiile
        $query = "SELECT id, name, description, price FROM products ORDER BY id DESC
                LIMIT :from_record_num, :records_per_page";
        $stmt = $con->prepare($query);
        $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
        $stmt->execute();

        //cum sa extragem numarul de randuri
        $num = $stmt->rowCount();

        //link pentru creare
        echo "<a href='create.php' class='btn btn-primary m-b-lem'>Creaza un nou produs</a>";

        //verificam daca sunt mai mult de 0 produse
        if ($num > 0) {

            //informatii din baza de date
            echo "<table class='table table-hover table-responsive table-bordered'>"; //incepem tabelul

            //heading pentru tabel
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nume</th>";
            echo "<th>Descriere</th>";
            echo "<th>Pret</th>";
            echo "<th>Actiune</th>";
            echo "</tr>";

            //corpul tabelului
            //incercam sa cerem informatii din baza de date
            //fetch() este mai rapid ca fetchAll()
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                //extragem rand si din $row['firstname] putem sa accesam doar cu $firstname
                extract($row);

                //cream cate un rand pentru fiecare produs
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$description}</td>";
                echo "<td>{$price}</td>";
                echo "<td>";
                // pentru a vedea un singur produs
                echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Vezi produs</a>";

                //pentru a modifica/edita
                echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Modifica</a>";

                //pentru a sterge
                echo "<a href='#' onclick='delete_user({$id});' class='btn btn-danger'>Sterge</a>";
                echo "</td>";
                echo "</tr>";
            }

            //finalul tabelului
            echo "</table>";
            //"Pagination" - numaram cate pagini de produse am avea daca limita de produse pe pagina este setata la 4
            $query = "SELECT COUNT(*) as total_rows FROM products";
            $stmt = $con->prepare($query);

            // executa query
            $stmt->execute();

            //aflam numarul total de randuri din baza de date
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $total_rows = $row['total_rows'];
            $page_url="index.php?";
            include_once "paging.php";
        }

        // daca nu se gasesc informatii in baza de date
        else {
            echo "<div class='alert alert-danger'>Nici un produs gasit.</div>";
        }


        ?>


    </div> <!-- aici se incheie containerul -->



    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- Cod pentru stergere -->
        <script type='text/javascript'>
        //confirma ca s-a sters produsul
        function delete_user( id ) {

            var answer = confirm('Esti sigur ca vrei sa faci asta?');
            if (answer) {
                //daca a dat click pe OK transmite ID catre delete.php unde se va efectua procesul de stergere a produsului
                window.location = 'delete.php?id=' +id;
            }
        }
        </script>
</body>

</html>