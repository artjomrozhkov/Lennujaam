<?php
$baasiaadress="d113371.mysql.zonevs.eu";
$baasikasutaja="d113371_artjom";
$baasiparool="syRWwjXQJR2lglYGDMk6";
$baasinimi="d113371_baas";
$yhendus=new mysqli($baasiaadress, $baasikasutaja, $baasiparool, $baasinimi);
$yhendus->set_charset('UTF8');