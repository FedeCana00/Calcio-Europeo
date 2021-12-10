<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bgGiocatori">';

if(isset($_POST['Ruolo']) && isset($_POST['Serie'])){ //verifica che il valore passato sia diverso da NULL
	$IN_Ruolo = $_POST['Ruolo'];
	$IN_Serie = $_POST['Serie'];
	$IN_Page = $_POST['page'];
	$stampa = true;
} else { //se non istanziati valore nullo e scritta di errore
	$IN_Ruolo = '';
	$IN_Serie = '';
	$IN_Page = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


//query che mi ritorna i giocatori di una serie con un ruolo ricercato dall'utente
$giocatori = connessione("SELECT Nome,Cognome,RF_Squadra FROM giocatore, squadra WHERE RF_Squadra = NomeSquadra AND Ruolo = '$IN_Ruolo' AND RF_Serie = '$IN_Serie' ORDER BY Cognome");
$num = mysqli_num_rows($giocatori);

//dieci giocatori per pagina
if($num/10 < 1){ //se 
	$giocatorixpage = 1;
} else {
	$giocatorixpage = $num/10 + 1;
}

//controllo ruolo
if($IN_Ruolo == 'P'){
	$ruolo = "Portieri";
}
else if($IN_Ruolo == 'D'){
	$ruolo = "Difensori";
}
else if($IN_Ruolo == 'C'){
	$ruolo = "Centrocampisti";
}
else if($IN_Ruolo == 'A'){
	$ruolo = "Attacanti";
}
else{
	$ruolo = '';
}
	
	
echo'<title>'.$ruolo.'</title>';

if($stampa){
	echo'<body>
	<div align="center" id="title">' . $ruolo .'</div>'; //inserisco il titolo

	$contatore = 1;
	
	while($contatore <= $num){
		$row = mysqli_fetch_assoc($giocatori);
		$Nome = $row['Nome'];
		$Cognome = $row['Cognome'];
		$RF_Squadra = $row['RF_Squadra'];
		 //stampo i valori
			echo "<div align='center' class='pad'><font size='10' face='Arial' color='white'><b>$Cognome</b> $Nome </font><font size='10' face='Arial' color='yellow'>$RF_Squadra</font></div>";
		
		$contatore++;
	}

}
//aggiunta del pulsante per tornare nella schermata home
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';
	
//footer
echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>