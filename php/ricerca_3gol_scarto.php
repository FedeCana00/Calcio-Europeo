<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bgGiocatori">';

if(isset($_POST['NomeSerie'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['NomeSerie']; //in tal caso istanzia la variabile che userò per la query
	$stampa = true;
}
else { //se non istanziati valore nullo e scritta di errore
	$data = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


//Query che mi ritorna tutti i parametri degli incontri di una determinata serie
$res = connessione("SELECT * FROM incontro,calendario WHERE RF_Calendario = ID AND RF_Serie = '$data' ORDER BY NumGiornata");																			
$num = mysqli_num_rows($res);


echo'<title>Gol di scarto</title>';

if($stampa){
	echo'<body>

	<div align="center" id="title">'.$data.'</div>'; //inserisco il titolo


	echo '<br><br><div align="center"><table border="0" align="middle">'; //crea la tabella

	for($i = 0; $i < $num; $i++){
		$row = mysqli_fetch_assoc($res);
		$Punteggio_1 = $row["Punteggio_1"];
		$Punteggio_2 = $row["Punteggio_2"];
		
		if ($Punteggio_1 - $Punteggio_2 >= 3 ||  $Punteggio_1 - $Punteggio_2 <= -3){
			$Squadra_1 = $row["RF_Squadra1"];
			$Squadra_2 = $row["RF_Squadra2"];
			$Giornata = $row["NumGiornata"];
			
			echo "<br><div align='center' class='pad'><font size='6' face='Arial' color='white'>$Squadra_1 $Punteggio_1 - $Punteggio_2 $Squadra_2 <font size='6' face='Arial' color='yellow'> Giornata $Giornata</font></div>";
		}
		
		
	}
	echo '</table></div>'; //chiude la tabella
}
//aggiunta del pulsante per tornare nella schermata home
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';
	
//footer
echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>