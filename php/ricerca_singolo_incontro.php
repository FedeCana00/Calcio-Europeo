<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bg">';

if(isset($_POST['incontro'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['incontro']; //in tal caso istanzia la variabile che userò per la query
	list($squadra1, $squadra2) = explode(',', $data); //divido il value passato in due parti
	$stampa = true;
} else {
	$squadra1 = '';
	$squadra2 = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}



//Query che mi ritorna tutti i parametri dell'incontro con le due squadre selezionate
$res = connessione("SELECT * FROM Incontro,Calendario WHERE RF_Calendario = ID AND RF_Squadra1 = '$squadra1' AND RF_Squadra2 = '$squadra2'");

$num = mysqli_num_rows($res);

echo'<title>Incontro</title>';
if($stampa){
	
	echo'<body>
	<div align="center" id="title">Incontro</div>'; //inserisco il titolo

	$i = 1;
	while($i <= $num){
		$row = mysqli_fetch_assoc($res);
		$date = $row["DataIncontro"];
		$NumGiornata = $row["NumGiornata"];
		$Punteggio_1 = $row["Punteggio_1"];
		$Punteggio_2 = $row["Punteggio_2"];
		echo "<br><br><div align='center' class='pad'><font size='10' face='Arial' color='white'>Data Incontro : <b>$date</b></font></div>";
		echo "<br><div align='center' class='pad'><font size='16' face='Arial' color='black'>Giornata $NumGiornata</font></div>";
		echo "<br><div align='center' class='pad'><font size='14' face='Arial' color='white'>$squadra1 $Punteggio_1 - $Punteggio_2 $squadra2</font></div>";
		if($Punteggio_1 == NULL OR $Punteggio_2 == NULL){ //controllo se non è ancora stato disputato l'incontro
			echo "<br><div align='center' class='pad'><font size='10' face='Arial' color='yellow'>Partita non ancora disputata</font></div>";
		}
		$i++;
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