<?php
require_once("konf.php");
global $yhendus;

if(!empty($_REQUEST["korras_id"])){
    $kask=$yhendus->prepare("UPDATE lend SET lopetatud=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["korras_id"]);
    $kask->execute();
}


if(!empty($_REQUEST["vigane_id"])){
    $kask=$yhendus->prepare(
        "UPDATE lend SET lopetatud=2 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vigane_id"]);
    $kask->execute();
}


if(!empty($_REQUEST["sisestusnupp"])){
    $kask=$yhendus->prepare("INSERT INTO lend(lennu_nr,kohtade_arv,ots,siht,valjumisaeg,kestvus,lopetatud) VALUES (?,?,?,?,?,?,?)");
    $kask->bind_param("iisssss", $_REQUEST["lennunumber"], $_REQUEST["kohtadearv"], $_REQUEST["ots"], $_REQUEST["siht"],$_REQUEST["valjumiseaeg"],$_REQUEST["kestvus"],$_REQUEST["lopetatud"]);
    $kask->execute();
    $yhendus->close();
    header("Location: $_SERVER[PHP_SELF]");
}
$kask=$yhendus->prepare(
    "SELECT id,lennu_nr,kohtade_arv,ots,siht,valjumisaeg,kestvus,lopetatud FROM lend WHERE lopetatud=-1;");
$kask->bind_result($id, $lennu_nr, $kohtade_arv, $ots,
    $siht, $valjumisaeg,$kestvus,$lopetatud);
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
        input[type=datetime-local]{
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
            input[type=time]{
            width: 50%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
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
        <th>Lennu number</th>
        <th>Kohtade arv</th>
        <th>Ots</th>
        <th>Siht</th>
        <th>Välumisaeg</th>
        <th>Kestvus</th>
        <th>Lõpetatud</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "<tr>
               <td>$id</td>
			   <td>$lennu_nr</td>
			   <td>$kohtade_arv</td>
			   <td>$ots</td>
			   <td>$siht</td>
			   <td>$valjumisaeg</td>
			   <td>$kestvus</td>
               <td>
			    <a href='?korras_id=$id'>Ja</a>
			    <a href='?vigane_id=$id'>Ei</a>
			  </td>
			 </tr>
		   ";
    }
    ?>
<table>
</table>
    <form action="?">
        <dl>
            <center>
                <input type="text" name="lennunumber" placeholder="Lennu number"/>
                <br>
                <br>
                <input type="text" name="kohtadearv" placeholder="Kohtade arv"/>
                <br>
                <br>
                <input type="text" name="ots" placeholder="Ots" />
                <br>
                <br>
                <input type="text" name="siht" placeholder="Siht" />
                <br>
                <br>
                <dl>Väljumisaeg:</dl>
                <input type="datetime-local" name="valjumiseaeg" placeholder="Väljumisaeg" />
                <br>
                <br>
                <dl>Kestvus:</dl>
                <input type="time" name="kestvus" placeholder="Kestvus" />
                <br>
                <br>
                <input type="submit" name="sisestusnupp" value="Sisesta" />
            </center>
        </dl>
    </form>
</body>
</html>
