<?php
require_once("konf.php");
global $yhendus;

if(isset($_REQUEST['punkt'])){
    global $yhendus;
    $kask=$yhendus->prepare('UPDATE lend SET reisjate_arv=reisjate_arv+1 WHERE id=?');
    $kask->bind_param("s", $_REQUEST['punkt']);
    $kask->execute();
}

$kask=$yhendus->prepare("SELECT id,reisjate_arv FROM lend");
$kask->bind_result($id,$reisijatearv);
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
        input[type=text], select {
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 50%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
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
        <th>Reisi ID</th>
        <th>Reisijate arv</th>
        <th>Reisijate lisamine</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		    <tr>
			  <td>$id</td>
              <td>$reisijatearv</td>
              <td>
              <a href='Reisijatelisamiseks.php?punkt=$id'>Lisa 1punkt</a>
              </td>
			</tr>
		  ";
    }
    ?>
</table>
</body>
</html>