<?php
include 'connessioneFunzione.php';

echo '<head>
	<link rel="icon" type="image/png" href="favicon.jpg"/>
	<title>Incontro</title>
	<link rel="stylesheet" href="stileGenerale.css">
	</head>
	<body>
	<div class="bg">
	<div align="center" > <font size="18" face="Arial" color="Red">Incontro </font></div>'; //inserisco il titolo

if(isset($_POST['incontro']) && isset($_POST['punteggioCasa']) && isset($_POST['punteggioOspite'])){ //verifica che il valore passato sia diverso da NULL
	$ID = $_POST['incontro'];
	$Punteggio1 = $_POST['punteggioCasa'];
	$Punteggio2 = $_POST['punteggioOspite'];
	
	if($Punteggio1 >= 0 && $Punteggio2 >= 0){ //verifico che entrambi i punteggi siano maggiori o uguali a zero
		$stampa = true;
	} else {
		$stampa = false;
	}
	
} else{
	$ID = '';
	$Punteggio1 = '';
	$Punteggio2 = '';
	$stampa = false;
}

if($stampa){

	//aggiorno la riga della tabella per aggiunre i nuovi punteggi
	if(! connessione("UPDATE calendario SET Punteggio_1 = $Punteggio1, Punteggio_2 = $Punteggio2 WHERE ID = $ID")){
		echo '<div align="center"><font size="4" face="Arial" color="Red">ERRORE! Aggiornamento non effettuato!</font></div>';
	}

	//ottengo le le informazioni sulla giornata aggiornata
	$incontro = connessione("SELECT * FROM calendario,incontro WHERE RF_Calendario = ID AND ID = $ID");

	$row = mysqli_fetch_assoc($incontro);
	$date = $row["DataIncontro"];
	$squadra1 = $row['RF_Squadra1'];
	$squadra2 = $row['RF_Squadra2'];
	$NumGiornata = $row["NumGiornata"];
	$Punteggio_1 = $row["Punteggio_1"];
	$Punteggio_2 = $row["Punteggio_2"];
	echo "<br><br><div align='center'><font size='10' face='Arial' color='white'>Data Incontro : <b>$date</b></font></div>";
	echo "<br><div align='center'><font size='16' face='Arial' color='black'>Giornata $NumGiornata</font></div>";
	echo "<br><div align='center'><font size='14' face='Arial' color='white'>$squadra1 $Punteggio_1 - $Punteggio_2 $squadra2</font></div>";
} else { //stampo la scritta di errore
	echo '<div align="center" id="Errori">ERRORE! Inserimento effettuato errato!</div>';
}

echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '</div><div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>