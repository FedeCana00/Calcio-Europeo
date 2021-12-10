<?php

function connessione($query){
	
	// nome di host
	$host = "localhost";
	// username dell'utente in connessione
	$user = "root";
	// password dell'utente
	$password = "";
	// nome del database
	$db = "calcio_europeo";
	
	//apertura connessione con dati inerenti al DB
	$connessione = @mysqli_connect($host, $user, $password, $db) or die("Impossibile selezionare il database");
	//esecuzione della query
	$risultato = mysqli_query($connessione,$query);
	//chiusura connessione al DB
	mysqli_close($connessione);
	//ritorno il risultato della query
	return $risultato;
}
?>