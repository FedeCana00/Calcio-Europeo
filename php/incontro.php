<?php
include 'connessioneFunzione.php';

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title> Campionati </title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">';


//distruggo il contenuto all'interno della tabella INCONTRO
$dist = connessione("TRUNCATE incontro");

//query per ottenere il nome della squadra e la serie in cui opera
$squadraCasa = connessione("SELECT NomeSquadra,RF_Serie FROM Squadra");
$numSquadreCasa = mysqli_num_rows($squadraCasa);

$OK = 0; //esecuzioni senza errori
$Errore = 0; // esecuzioni con erorri
for($cont1 = 0; $cont1 < $numSquadreCasa; $cont1++){
	$rowCasa = mysqli_fetch_assoc($squadraCasa);
	$NomeSquadraCasa = $rowCasa['NomeSquadra'];
	$RFSerieCasa = $rowCasa['RF_Serie'];
	
	//ottengo le squadre ospiti contro cui quella squadra giocherà appartenenti alla stessa serie
	$squadraOspite = connessione("SELECT NomeSquadra FROM Squadra WHERE NomeSquadra <> '$NomeSquadraCasa' AND RF_Serie = '$RFSerieCasa'");
	$numSquadreOspite = mysqli_num_rows($squadraOspite);

	for($cont2 = 0; $cont2 < $numSquadreOspite; $cont2++){
		$rowOspite = mysqli_fetch_assoc($squadraOspite);
		$NomeSquadraOspite = $rowOspite['NomeSquadra'];

		//QUERY PER OTTENERE LE GIORNATE IN CUI LA SQUADRA NON COMPARE
		$NumGiornata = connessione("SELECT DISTINCT NumGiornata FROM calendario WHERE NumGiornata NOT IN (SELECT c.NumGiornata FROM incontro, calendario as c WHERE RF_Calendario = c.ID AND (RF_Squadra1 = '$NomeSquadraCasa' OR RF_Squadra2 = '$NomeSquadraOspite' OR RF_Squadra1 = '$NomeSquadraOspite' OR RF_Squadra2 = '$NomeSquadraCasa')) ORDER BY NumGiornata");
		$numrowgiornata = mysqli_num_rows($NumGiornata);
		$rowGiornata = mysqli_fetch_assoc($NumGiornata);
		$NumeroGiornata = $rowGiornata['NumGiornata'];
		
		//query per ottenere un ID associato ad un certo numero di giornata e non già associato ad un incontro
		$infoInserimento = connessione("SELECT ID FROM calendario WHERE NumGiornata = '$NumeroGiornata' AND ID NOT IN (SELECT RF_Calendario FROM incontro)");
		
		if(mysqli_num_rows($infoInserimento) > 0){
			$rowID = mysqli_fetch_assoc($infoInserimento);
			$resID = $rowID['ID'];
			
			if(connessione("INSERT INTO `incontro` (`RF_Serie`, `RF_Calendario`, `RF_Squadra1`, `RF_Squadra2`) VALUES ('$RFSerieCasa','$resID','$NomeSquadraCasa','$NomeSquadraOspite')")){
				$OK++;
			} else {
				$Errore++;
			}
		}
	}
}

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo "<br><br><br><br><br><br><div id='Esecuzioni' align='center'>Esecuzioni avvenute correttamente: $OK</div>";
echo "<br><div id='Errori' align='center'>Esecuzioni in cui si sono riscontrati errrori: $Errore</div>";
echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';
?>