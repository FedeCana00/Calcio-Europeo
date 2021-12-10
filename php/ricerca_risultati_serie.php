<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bg">';

if(isset($_POST['NumGiornata']) && isset($_POST['Serie']) ){ //verifica che il valore passato sia diverso da NULL
	$giornata = $_POST['NumGiornata']; //in tal caso istanzia le variabili che userò per la query
	$serie = $_POST['Serie'];
	$stampa = true;
} 
else {
	$giornata = '';
	$serie = '';
	$stampa = false;
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


//Query che mi ritorna tutti i parametri degli incontri di una determinata serie e giornata
$resIncontri = connessione("SELECT * FROM Incontro,Calendario WHERE ID = RF_Calendario AND NumGiornata = $giornata AND RF_Serie = '$serie'");
if($resIncontri){
	$numIncontri = mysqli_num_rows($resIncontri);
}


echo'<title>Giornata '.$giornata.'</title>';

if($stampa){
	echo'<body>
	<div align="center" id="title">Giornata '.$giornata.'</div>'; //inserisco il titolo 


	for($i = 0; $i < $numIncontri; $i++){
			$row = mysqli_fetch_assoc($resIncontri);
			if($i == 0){
				$date = $row["DataIncontro"];
				echo "<div style='position:absolute;top:10px;left:20px;'><font size='8' face='Arial' color='white'>Data Incontri $date</font></div>";
			}
			$Punteggio_1 = $row["Punteggio_1"];
			$Punteggio_2 = $row["Punteggio_2"];
			$squadra1 = $row["RF_Squadra1"];
			$squadra2 = $row["RF_Squadra2"];
			
			echo "<br><div align='center' class='pad'><font size='5' face='Arial' color='white'>$squadra1 $Punteggio_1 - $Punteggio_2 $squadra2</font></div>";
			if($Punteggio_1 == NULL OR $Punteggio_2 == NULL){ //controllo se non è ancora stato disputato l'incontro
				echo "<br><div align='center' class='pad'><font size='5' face='Arial' color='yellow'>Partita non ancora disputata</font></div>";
			}
	}
}

//aggiunta del pulsante per tornare nella schermata home
echo '<a href="index.html" class="home""><image src="home.png" width="100px" height="100px"></a>';
	
//footer
echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>