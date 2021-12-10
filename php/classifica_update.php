<?php
include 'connessioneFunzione.php';

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title> Campionati </title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">';


//Mi collego al DB per reperire dati sulle squadre e sul calendario
$squadra= connessione("SELECT NomeSquadra FROM Squadra");
$numSquadre = mysqli_num_rows($squadra);
$Esecuzioni = 0;
$Errori = 0;
for($contSquadre = 0; $contSquadre < $numSquadre; $contSquadre++){
	$puntiaccumulati = 0;
	$rowSquadra = mysqli_fetch_assoc($squadra);
	$NomeSquadra = $rowSquadra["NomeSquadra"];
	$incontriCasa = connessione("SELECT * FROM Incontro, Calendario WHERE ID = RF_Calendario AND RF_Squadra1 = '$NomeSquadra'");
	$numCasa = mysqli_num_rows($incontriCasa);
	$incontriOspite = connessione("SELECT * FROM Incontro, Calendario WHERE ID = RF_Calendario AND RF_Squadra2 = '$NomeSquadra'");
	$numOspite = mysqli_num_rows($incontriOspite);
	for($contCasa = 0; $contCasa < $numCasa; $contCasa++){
		$rowCasa = mysqli_fetch_assoc($incontriCasa);
		if($rowCasa["Punteggio_1"] != NULL && $rowCasa["Punteggio_2"] != NULL){ //verifico che il valore non sia NULL
			$puntiCasa1 = $rowCasa["Punteggio_1"];
			$puntiOspite1 = $rowCasa["Punteggio_2"];
			if($puntiCasa1 > $puntiOspite1){
				$puntiaccumulati += 3;
			} else if($puntiCasa1 == $puntiOspite1){
				$puntiaccumulati++;
			}
		}
	}
	for($contOspite= 0; $contOspite < $numOspite; $contOspite++){
		$rowOspite = mysqli_fetch_assoc($incontriOspite);
		if($rowOspite["Punteggio_1"] != NULL && $rowOspite["Punteggio_2"] != NULL){ //verifico che il valore non sia NULL
			$puntiCasa2 = $rowOspite["Punteggio_1"];
			$puntiOspite2 = $rowOspite["Punteggio_2"];
			if($puntiCasa2 < $puntiOspite2){
				$puntiaccumulati += 3;
			} else if($puntiCasa2 == $puntiOspite2){
				$puntiaccumulati++;
			}
		}
	}
	if(connessione("UPDATE Squadra SET Punti = $puntiaccumulati WHERE '$NomeSquadra' = NomeSquadra")){
		$Esecuzioni++;
	} else {
		$Errori++;
	}
}

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '<br><br><br><div align="center" id="Esecuzioni">Aggiornamenti punti corretti: '. $Esecuzioni . '</div>';
echo '<br><div align="center" id="Errori">Errori: '. $Errori . '</div>';
echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';
?>