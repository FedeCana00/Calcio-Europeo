<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bgGiocatori">';

if(isset($_POST['Eta']) && isset($_POST['page'])){ //verifica che il valore passato sia diverso da NULL
	$IN_Eta = $_POST['Eta'];
	$IN_Page = $_POST['page'];
	$stampa = true;
} else { //se non istanziati valore nullo e scritta di errore
	$IN_Eta = '';
	$IN_Page = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


//query che mi ritorna tutti i giocatori con un età inferiore di quella selezionata dall'utente
$giocatori = connessione("SELECT DISTINCT CF,Nome,Cognome,RF_Squadra,Eta FROM giocatore, squadra WHERE Eta <= $IN_Eta ORDER BY Eta desc");
if($giocatori){
	$num = mysqli_num_rows($giocatori);

	//dieci giocatori per pagina
	if($num/10 < 1){ //se minore di uno fai vedere la pagina
		$giocatorixpage = 1;
	} else {
		$giocatorixpage = $num/10 + 1; //in caso di valori decimali aggiungo un pagina
	}
}

echo'<title>Giocatori</title>';

if($stampa){
	echo'<body>

	<div align="center" id="title">Giocatori</div>'; //inserisco il titolo

	//stampo 2 a capo
	echo '<br><br>';

	$contatore = 1;
	
	while($contatore <= $num){
		$row = mysqli_fetch_assoc($giocatori);
		$Nome = $row['Nome'];
		$Cognome = $row['Cognome'];
		$RF_Squadra = $row['RF_Squadra'];
		$Eta = $row['Eta'];
		echo "<div align='center' class='pad'><font size='12' face='Arial' color='yellow'><b>$Eta</b></font> <font size='10' face='Arial' color='white'><b>$Cognome</b> $Nome </font><font size='10' face='Arial' color='yellow'>$RF_Squadra</font></div>";

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