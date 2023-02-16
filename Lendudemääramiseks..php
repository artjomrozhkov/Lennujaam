<?php
require_once("konf.php");
global $yhendus;

if(!empty($_REQUEST["korras_id"])){
    $kask=$yhendus->prepare(
        "UPDATE reisijate SET lend=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["korras_id"]);
    $kask->execute();
}
if(!empty($_REQUEST["vigane_id"])){
    $kask=$yhendus->prepare(
        "UPDATE reisijate SET lend=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vigane_id"]);
    $kask->execute();
}


$kask=$yhendus->prepare("SELECT id, eesnimi, perenimi, reisinumber FROM reisijate WHERE lend=-1");
$kask->bind_result($id, $eesnimi, $perenimi,$reisinumber);
$kask->execute();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Lennujaam</title>
    <style>
        html {
            font-family: "helvetica neue", helvetica, arial, sans-serif;
        }

        thead th,
        tfoot th {
            font-family: "Rock Salt", cursive;
        }

        th {
            letter-spacing: 2px;
        }

        td {
            letter-spacing: 1px;
        }

        tbody td {
            text-align: center;
        }

        tfoot th {
            text-align: right;
        }
        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 3px solid black;
        }

        thead th:nth-child(1) {
            width: 30%;
        }

        thead th:nth-child(2) {
            width: 20%;
        }

        thead th:nth-child(3) {
            width: 15%;
        }

        thead th:nth-child(4) {
            width: 35%;
        }

        th,
        td {
            padding: 20px;
        }
        body {
            height: 125vh;
            background-size: cover;
            font-family: sans-serif;
            margin-top: 80px;
            padding: 30px;
        }

        main {
            color: white;
        }

        header {
            background-color: white;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 80px;
            display: flex;
            align-items: center;
            box-shadow: 0 0 25px 0 black;
        }

        header * {
            display: inline;
        }

        header li {
            margin: 20px;
        }

        header li a {
            color: black;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header>
    <h1>Lennujaam</h1>
    <nav>
        <ul>
            <li>
                <a href="Lendudelisamiseks.php">Lendude lisamiseks</a>
            </li>
            <li>
                <a href="Reisijatelisamiseks.php">Reisijate lisamiseks</a>
            </li>
            <li>
                <a href="Lend.php">Lend</a>
            </li>
        </ul>
    </nav>
</header>

<table>
    <tr>
        <th>Eesnimi</th>
        <th>Perenimi</th>
        <th>Reisi number</th>
        <th>Kinnitamine</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$eesnimi</td>
			  <td>$perenimi</td>
			  <td>$reisinumber</td>
			  <td>
			    <a href='?korras_id=$id'>Korras</a>
			    <a href='?vigane_id=$id'>Ebaõnnestunud</a>
			  </td>
			</tr>
		  ";
    }
    ?>
</table>
</body>
</html>
