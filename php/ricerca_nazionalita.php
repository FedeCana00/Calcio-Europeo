<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bg">';

if(isset($_POST['Nazionalita']) && isset($_POST['Serie']) && isset($_POST['page'])){ //verifica che il valore passato sia diverso da NULL
	$IN_Nazionalita = $_POST['Nazionalita'];
	$IN_Serie = $_POST['Serie'];
	$IN_Page = $_POST['page'];
	$stampa = true;
} else { //se non istanziati valore nullo e scritta di errore
	$IN_Nazionalita = '';
	$IN_Serie = '';
	$IN_Page = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


//query che mi ritorna i giocatori di una serie con una nazionalità selezionata dall'utente
$giocatori = connessione("SELECT Nome,Cognome,RF_Squadra FROM giocatore, squadra WHERE RF_Squadra = NomeSquadra AND Nazionalita = '$IN_Nazionalita' AND RF_Serie = '$IN_Serie' ORDER BY Cognome");
$num = mysqli_num_rows($giocatori);

//dieci giocatori per pagina
if($num/10 < 1){ //se minore di uno fai vedere la pagina
	$giocatorixpage = 1;
} else {
	$giocatorixpage = $num/10 + 1; //in caso di valori decimali aggiungo un pagina
}


echo'<title>'.$IN_Nazionalita.'</title>';

if($stampa){
	
	echo'<body>
	<div align="center" id="title">Giocatori</div>'; //inserisco il titolo

	$contatore = 1;
	$i = ($IN_Page-1)*10 +1;
	$conclusione = $i + 9;
	while($contatore <= $num){
		$row = mysqli_fetch_assoc($giocatori);
		$Nome = $row['Nome'];
		$Cognome = $row['Cognome'];
		$RF_Squadra = $row['RF_Squadra'];
		if($contatore >= $i && $contatore <= $conclusione){ //stampo i valori
			echo "<div align='center' class='pad'><font size='10' face='Arial' color='white'><b>$Cognome</b> $Nome </font><font size='10' face='Arial' color='yellow'>$RF_Squadra</font></div>";
		}
		$contatore++;
	}

	$precedente = $IN_Page - 1;
	$successiva = $IN_Page + 1;

	//pulsante precedente solo se maggiore di pagina 0
	if($precedente >= 1){
		echo "<div style='position:absolute;bottom:20px;left:30px;'><form action='ricerca_nazionalita.php' method= post><input type='hidden' name='page' value=$precedente>
				<input type='hidden' name='Serie' value='$IN_Serie'><input type='hidden' name='Nazionalita' value='$IN_Nazionalita'><input type='submit' class='button' name='submit'" . 'name="someAction"' . "value='Precedente' size='100px'/>
				</form></div>";
	}
	//pulsante successiva solo se minore di pagina massima
	if($successiva <= $giocatorixpage){
		echo "<div style='position:absolute;bottom:20px;right:30px;'><form action='ricerca_nazionalita.php' method= post><input type='hidden' name='page' value=$successiva>
				<input type='hidden' name='Serie' value='$IN_Serie'><input type='hidden' name='Nazionalita' value='$IN_Nazionalita'><input type='submit' class='button' name='submit'" . 'name="someAction"' . "value='Successiva' size='100px'/>
				</form></div>";
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