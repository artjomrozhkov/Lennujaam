<?php
require_once("konf.php");
global $yhendus;
if(!empty($_REQUEST["vormistamine_id"])){
    $kask=$yhendus->prepare(
        "UPDATE lend SET lopetatud=1 WHERE id=?");
    $kask->bind_param("i", $_REQUEST["vormistamine_id"]);
    $kask->execute();
}

if(isset($_REQUEST['kustutusid'])) {
    $paring = $yhendus->prepare('DELETE FROM lend WHERE id=?');
    $paring->bind_param('i', $_REQUEST['kustutusid']);
    $paring->execute();
}

$kask=$yhendus->prepare("SELECT id,lennu_nr,reisjate_arv,kestvus,lopetatud FROM lend;");
$kask->bind_result($id,$lennunr,$reisjatearv,$kestvus,$lopetatud);
$kask->execute();
function asenda($nr){
    if($nr==-1){return ".";} //tegemata
    if($nr== 1){return "Ja";}
    if($nr== 2){return "Ei";}
    return "Tundmatu number";
}
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
    1 -> Lõpetatud
    <br>
    -1 -> Ei lõpetatud
    <tr>
        <th>Reisi ID</th>
        <th>Lennu number</th>
        <th>Reisijate arv</th>
        <th>Kestvus</th>
        <th>Lõpetatud</th>
        <th>Kustuta</th>
    </tr>
    <?php
    while($kask->fetch()){
        echo "
		     <tr>
               <td>$id</td>
               <td>$lennunr</td>
               <td>$reisjatearv</td>
               <td>$kestvus</td>
               <td>$lopetatud</td>
               <td><a href='$_SERVER[PHP_SELF]?kustutusid=$id'>kustuta</a></td>
			 </tr>
		   ";
        }
    ?>
</table>
</body>
</html>

