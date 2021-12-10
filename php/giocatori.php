<?php

include 'connessioneFunzione.php';

if(isset($_POST['NomeSquadra'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['NomeSquadra']; //in tal caso istanzia la variabile che userò per la query
}


//Query che mi ritorna tutti i parametri dei giocatori in ordine decrescente di ruolo e a parità in ordine alfabetico del Cognome
$res = connessione("SELECT * FROM Giocatore WHERE RF_Squadra = '$data' ORDER BY Ruolo DESC, Eta ASC");
$num = mysqli_num_rows($res);


echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title>' ."$data". '</title>
</head>

<body>
<div class="bgGiocatori">
<div align="center" id="title">' .$data. '</div>';

$i = 0;
$contatore_portiere = 0; //se 1 già scritto se 0 ancora da scrivere
$contatore_difensore = 0; //se 1 già scritto se 0 ancora da scrivere
$contatore_centrocampista = 0; //se 1 già scritto se 0 ancora da scrivere
$contatore_attaccante = 0; //se 1 già scritto se 0 ancora da scrivere
$filephp = 'schedagiocatore.php';
echo "<div align='center'><table border='0' align='middle'>"; //inizializzo la tabella
while($i < $num){
	$row = mysqli_fetch_assoc($res);
	$CognomeNome = $row["Cognome"] . ' ' . $row["Nome"];
	$ruolo = $row["Ruolo"];
	$ID = $row["CF"]; //serve per identificare in modo univoco il calciatore
	switch ($ruolo){
		case 'P':
			if($contatore_portiere == 0){ //stampo la scritta PORTIERI
				echo '<tr><td><div align="center" > <font style="font-size: 18px" face="Arial" color="white"><b>Portieri</b></font></div></td></tr>';
				$contatore_portiere++;//incremento per non far piu' stampare
			}
			break;
		case 'D':
			if($contatore_difensore == 0){ //stampo la scritta DIFENSORI
				echo '<tr><td><div align="center" > <font style="font-size: 18px" face="Arial" color="white"><b>Difensori</b></font></div></td></tr>';
				$contatore_difensore++; //incremento per non far piu' stampare
			}
			break;
		case 'C':
			if($contatore_centrocampista == 0){ //stampo la scritta CENTROCAMPISTI
				echo '<tr><td><div align="center" > <font style="font-size: 18px" face="Arial" color="white"><b>Centrocampisti</b></font></div></td></tr>';
				$contatore_centrocampista++; //incremento per non far piu' stampare
			}
			break;
		case 'A':
			if($contatore_attaccante == 0){ //stampo la scritta ATTACCANTI
				echo '<tr><td><div align="center"> <font style="font-size: 18px" face="Arial" color="white"><b>Attaccanti</b></font></div></td></tr>';
				$contatore_attaccante++; //incremento per non far piu' stampare
			}
			break;
	}
	echo "<tr><td style='background-color:#ffcd12'><font style='font-size: 13px' face='Arial' color='blue'><b>$CognomeNome</b></font></td>
		<td><form action=$filephp method=" . "post style='text-align:center'><input type='hidden' name='GiocatoreID' value=$ID><input type='submit' class='button buttonGiocatori' name='submit'" . 'name="someAction"' . "value='Scopri'/></form></td></tr></div>";
	$i++;
}
echo '</table>'; //chiudo la tabella subito dopo aver concluso il ciclo

//Ottengo il numero di nazionalità che compaiono in una squadra ordinate in ordine decrescente
$nazionalita = connessione("SELECT Nazionalita, COUNT(Nazionalita) as Num FROM giocatore WHERE RF_Squadra = '$data' GROUP BY Nazionalita ORDER BY Num DESC");

$row_Nazionalita = mysqli_fetch_assoc($nazionalita);
if($row_Nazionalita > 0){ //stampo la nazionalita più ricorrente solo se la query restituisce qualcosa
	$naz = $row_Nazionalita["Nazionalita"];
	$naz_num = $row_Nazionalita["Num"];
	//visualizzo la nazionalità più ricorrente nella squadra
	echo "<div style='position:absolute;top:20px;left:20px;'><font size='3' color='white' face='Arial'>Nazionalità
		più ricorrente <b>$naz</b> numero di volte <b>$naz_num</b></font></div>";
	echo'<br><br>';
}

echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';

?>