<?php
include 'connessioneFunzione.php';

if(isset($_POST['giocatore'])){ //verifica che il valore passato sia diverso da NULL
	$giocatore = $_POST['giocatore']; //in tal caso istanzia la variabile che userò per la query
}
if(isset($_POST['squadra'])){ //verifica che il valore passato sia diverso da NULL
	$squadra = $_POST['squadra']; //in tal caso istanzia la variabile che userò per la query
}

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title>Tasferimenti</title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">
<div align="center" id="title">Trasferimenti</div>'; //inserisco il titolo

//in questa connessione ottengo le info sul giocatore e sulla squadra alla quale appartiene prima del traserimento
$infogiocatore = connessione("SELECT * FROM Squadra,Giocatore WHERE NomeSquadra = RF_Squadra AND CF = $giocatore");
$rowinfogiocatore = mysqli_fetch_assoc($infogiocatore);
$oldsquadra = $rowinfogiocatore["RF_Squadra"];
$valoregiocatore = $rowinfogiocatore["Valore"];
$oldsoldisquadra = $rowinfogiocatore["Saldo"];
$nomeoldsquadra = $rowinfogiocatore["NomeSquadra"];
//in questa connessione ottengo le informazioni relative alla nuova squadra se il trasferimento ha successo
$infosquadranew = connessione("SELECT * FROM Squadra WHERE NomeSquadra = '$squadra'");
$rowinfosquadranew = mysqli_fetch_assoc($infosquadranew);
$oldsoldisquadranew = $rowinfosquadranew["Saldo"];
if($oldsoldisquadranew >= $valoregiocatore){ //verifico che la squadra possa permettersi di comprare il giocatore
	$newsaldo1 = $oldsoldisquadra + $valoregiocatore;
	$newsaldo2 = $oldsoldisquadranew - $valoregiocatore;
	//in questa connessione cambio il riferimento della squadra del giocatore
	if($squadra <> $nomeoldsquadra){ //verifico che non stia trasferendo il giocatore nella squadra di appartenenza
		if(connessione("UPDATE Giocatore SET RF_Squadra = '$squadra' WHERE CF = $giocatore")){
			//in questa connessione aggiorno il saldo della squadra vecchia
			if(!connessione("UPDATE Squadra SET Saldo = $newsaldo1 WHERE NomeSquadra = '$nomeoldsquadra'")){ 
				print('Errore aggiornamento del saldo della squadra vecchia!');
			}
			
			//in questa connessione aggiorno il saldo della nuova squadra
			if(!connessione("UPDATE Squadra SET Saldo = $newsaldo2 WHERE NomeSquadra = '$squadra'")){
				print('Errore aggiornamento del saldo della squadra nuova!');
			}
			
			//in questa connessione mostro l'aggiunta dela giocatore alla rosa della squadra scelta per il trasferimento
			$trasfer = connessione("SELECT * FROM Giocatore WHERE RF_Squadra = '$squadra' ORDER BY Ruolo desc");
			$numerogiocatori = mysqli_num_rows($trasfer); //numero di giocatori e quindi di righe della query precedente
			
			//stampo a video i saldi precedenti e attuali delle squadre coinvolte nel trasferimento
			echo "<br><br><div align='center'><font size='4' face='Arial' color='white'>Trasferimento da $nomeoldsquadra (Saldo precedente $oldsoldisquadra; Saldo attuale </font><font color='#00FF00' size='4'>$newsaldo1</font>
			<font size='4' face='Arial' color='white'>) a $squadra (Saldo precedente $oldsoldisquadranew; Saldo attuale </font><font color='red' size='4'>$newsaldo2</font><font size='4' face='Arial' color='white'>)</font></div>";
			echo "<br><br><div align='center'><font size='8' face='Arial' color='#00FFFF'><b>Lista giocatori $squadra:</b></font><br></div><div align='center'>";
			//ciclo necessario nella visualizzazione dei giocatori della squadra in cui è stato trasferito il giocatore
			for($i = 0;$i < $numerogiocatori; $i++){
				$rigagiocatore = mysqli_fetch_assoc($trasfer);
				$Nomegiocatore = $rigagiocatore["Nome"];
				$Cognomegiocatore = $rigagiocatore["Cognome"];
				$CodiceFiscale = $rigagiocatore["CF"];
				if($CodiceFiscale <> $giocatore){ //coloro di giallo il giocatore aggiunto da trasferimento
					$color = 'white';
				} else {
					$color = 'yellow';
				}
				echo "<font size='5' face='Arial' color=$color>$Cognomegiocatore $Nomegiocatore</font><br>";
			}
			echo '</div>';
		} else {
			echo "<br><br><div align='center'><font size='4' face='Arial' color='white'><b>Impossibile effettuare il trasferimento</b></font></div>";
		}
	} else {
		echo "<br><br><div align='center'><font size='4' face='Arial' color='white'><b>Impossibile effettuare il trasferimento, trasferimento nella stessa squadra!</b></font></div>";
	}
} else{
	echo "<br><br><div align='center'><font size='4' face='Arial' color='white'><b>Impossibile effettuare il trasferimento, saldo della squadra non sufficiente!</b></font></div>";
}

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';
?>