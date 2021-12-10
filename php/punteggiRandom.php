<?php
include 'connessioneFunzione.php';

//ottengo tutti gli ID degli incontri
$incontri = connessione("SELECT ID FROM Calendario ORDER BY ID");
$numIncontri = mysqli_num_rows($incontri);

$Esecuzioni = 0;
$Errori = 0;
for($i = 0; $i < $numIncontri; $i++){
	$row = mysqli_fetch_assoc($incontri);
	$ID = $row['ID'];
	$numRandCasa = rand(-1,6);
	if($numRandCasa == -1){ //in tal caso dirò che questo incontro non è ancora stato disputato
		//inserisco i valori NULL come punteggi 
		if(connessione("UPDATE calendario SET Punteggio_1 = NULL, Punteggio_2 = NULL WHERE ID = $ID")){
			$Esecuzioni++;
		} else {
			$Errori++;
		}
	} else { //se è stato disputato genero anche il secondo incontro
		$numRandOspite = rand(0,6);
		//inserisco i valori RANDOM generati come punteggi
		if(connessione("UPDATE calendario SET Punteggio_1 = $numRandCasa, Punteggio_2 = $numRandOspite WHERE ID = $ID")){
			$Esecuzioni++;
		} else {
			$Errori++;
		}
	}
}
echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title>Generazione Punteggi</title>
</head>

<body>
<div class="bg">
<div align="center" id="title2">Generazione casuale Punteggi</div>'; //inserisco il titolo

echo "<br><br><div align='center' id='Esecuzioni'>Esecuzioni corrette: <b>$Esecuzioni</b></div>";
echo "<br><div align='center' id='Errori'>Esecuzioni non eseguite per ERRORI: <b>$Errori</b></div>";

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '</div><div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>