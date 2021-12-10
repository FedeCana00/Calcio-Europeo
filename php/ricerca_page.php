<?php

include 'connessioneFunzione.php';

//sfondo
echo'<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<div class="bgGiocatori">';

if(isset($_POST['page'])){ //verifica che il valore passato sia diverso da NULL
	$IN_Page = $_POST['page'];
} else { //se non istanziati valore nullo e scritta di errore
	$IN_Page = '';
	echo '<div align="center" id="Errori">Errore! Inserimento effettuato errato!</div>';
}


echo'<title>Ricerca</title>
<body>
<div align="center" id="title">Ricerca</div>'; //inserisco il titolo



/*		------------------------------------------
		---- visualizzare un singolo incontro ----
		------------------------------------------
*/

//Ottengo tutte le squadre selezionalibili
$squadra1 = connessione("SELECT * FROM Squadra");
$numSquadra1 = mysqli_num_rows($squadra1);

echo '<div align="center"><form action="ricerca_singolo_incontro.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona incontro da visualizzare:</font>
<select name="incontro" style="height:20px;">
<option value="" disabled selected>--seleziona incontro--</option>';

for($i = 0; $i < $numSquadra1; $i++){
	$row1 = mysqli_fetch_assoc($squadra1);
	$NomeSquadra1 = $row1["NomeSquadra"];
	$NomeSerie1 = $row1["RF_Serie"];
	

	//Ottengo tutte le squadre selezionalibili
	$squadra2 = connessione("SELECT * FROM Squadra WHERE RF_Serie = '$NomeSerie1'");
	$numSquadra2 = mysqli_num_rows($squadra2);
	
	for($j = 0; $j < $numSquadra2; $j++){
		$row2 = mysqli_fetch_assoc($squadra2);
		$NomeSquadra2 = $row2["NomeSquadra"];
		$value = $NomeSquadra1 . ',' . $NomeSquadra2;
		if($NomeSquadra1 <> $NomeSquadra2){
			echo "<option value='$value'>$NomeSquadra1 - $NomeSquadra2</option>";
		}
	}
}
echo '</select>';
echo '<br><input type="submit" class="button" name="submit" name="someAction" value="Cerca Incontro"/></form></div>';
//disegna linea di separazione
echo '<hr style="height:2px;border-width:0;color:white;background-color:white">';




/*		------------------------------------------------------------------------------
		---- visualizzare i giocatori di una determinata nazionalità di una serie ----
		------------------------------------------------------------------------------
*/
//Query che mi ritorna tutti i nomi di tutte le serie nel DB in ordine alfabetico
$resSerie = connessione("SELECT NomeSerie FROM Serie ORDER BY NomeSerie");
$numSerie = mysqli_num_rows($resSerie);
//Query che mi ritorna tutte le nazionalità presenti nel DB senza dubblicati
$resNazionalita = connessione("SELECT DISTINCT Nazionalita FROM giocatore ORDER BY Nazionalita");
$numNazionalita = mysqli_num_rows($resNazionalita);
echo '<div align="center"><form action="ricerca_nazionalita.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona Nazionalita da visualizzare:</font>
	<select name="Nazionalita" style="height:20px;">
	<option value="" disabled selected>--seleziona nazionalità--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Nazionalità
for($j = 0; $j < $numNazionalita; $j++){
	$row3 = mysqli_fetch_assoc($resNazionalita);
	$NomeNazionalita = $row3["Nazionalita"];
	echo "<option value='$NomeNazionalita'>$NomeNazionalita</option>";
}
echo '</select></div>'; //chiudo inserimento --> Fine dropdown
//stampa secondo dropdown con descrizione annessa
echo '<div align="center"><font size="5" color="white" face="Arial">Seleziona Serie in cui cercare i giocatori:</font>
	<select name="Serie" style="height:20px;">
	<option value="" disabled selected>--seleziona serie--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Serie
for($z = 0; $z < $numSerie; $z++){
	$row4 = mysqli_fetch_assoc($resSerie);
	$NomeSerie = $row4["NomeSerie"];
	echo "<option value='$NomeSerie'>$NomeSerie</option>";
}
echo '</select>'; //chiudo inserimento --> Fine dropdown
echo '<br><input type="hidden" name="page" value="1"><input type="submit" class="button" name="submit" name="someAction" value="Cerca Giocatori"/></form></div>';
//disegna linea di separazione
echo '<br><hr style="height:2px;border-width:0;color:white;background-color:white">';



/*		---------------------------------------------------------------------
		---- visualizzare tutti i risultati di una giornata di una serie ----
		---------------------------------------------------------------------
*/

//Query che mi ritorna tutti i nomi di tutte le serie nel DB in ordine alfabetico
$resSerie = connessione("SELECT NomeSerie FROM Serie ORDER BY NomeSerie");
$numSerie = mysqli_num_rows($resSerie);
///Query che mi ritorna tutte le giornate presenti nel DB senza dupplicati
$resGiornata = connessione("SELECT DISTINCT NumGiornata FROM calendario ORDER BY NumGiornata");
$numGiornata = mysqli_num_rows($resGiornata);
echo '<div align="center"><form action="ricerca_risultati_serie.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona Giornata da visualizzare:</font>
	<select name="NumGiornata" style="height:20px;">
	<option value="" disabled selected>--seleziona giornata--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Giornata
for($j = 0; $j < $numGiornata; $j++){
	$row5 = mysqli_fetch_assoc($resGiornata);
	$nGiornata = $row5["NumGiornata"];
	echo "<option value='$nGiornata'>$nGiornata</option>";
}
echo '</select></div>'; //chiudo inserimento --> Fine dropdown
//stampa secondo dropdown con descrizione annessa
echo '<div align="center"><font size="5" color="white" face="Arial">Seleziona Serie:</font>
	<select name="Serie" style="height:20px;">
	<option value="" disabled selected>--seleziona serie--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Serie
for($z = 0; $z < $numSerie; $z++){
	$row6 = mysqli_fetch_assoc($resSerie);
	$NomeSerie = $row6["NomeSerie"];
	echo "<option value='$NomeSerie'>$NomeSerie</option>";
}
echo '</select>'; //chiudo inserimento --> Fine dropdown
echo '<br><input type="submit" class="button" name="submit" name="someAction" value="Cerca Risultati"/></form></div>';
//disegna linea di separazione
echo '<br><hr style="height:2px;border-width:0;color:white;background-color:white">';




/*		-----------------------------------------------------------------------------
		---- visualizzare tutti i risultati con 3 o + gol di scarto in una serie ----
		-----------------------------------------------------------------------------
*/

//Query che mi ritorna tutti i nomi di tutte le serie nel DB in ordine alfabetico
$resSerie = connessione("SELECT NomeSerie FROM Serie ORDER BY NomeSerie");
$numSerie = mysqli_num_rows($resSerie);

echo '<div align="center" class="pad"> <font size="5" face="Arial" color="white">Visualizzare le partite con 3 o più gol di scarto</font>';

//stampa dropdown con descrizione annessa
echo '<div align="center"><form action="ricerca_3gol_scarto.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona Serie:</font>
	<select name="NomeSerie" style="height:20px;">
	<option value="" disabled selected>--seleziona serie--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Serie
for($z = 0; $z < $numSerie; $z++){
	$row6 = mysqli_fetch_assoc($resSerie);
	$NomeSerie = $row6["NomeSerie"];
	echo "<option value='$NomeSerie'>$NomeSerie</option>";
}
echo '</select>'; //chiudo inserimento --> Fine dropdown
echo '<br><input type="submit" class="button" name="submit" name="someAction" value="Cerca Partite"/></form></div>';
//disegna linea di separazione
echo '<hr style="height:2px;border-width:0;color:white;background-color:white">';



/*		------------------------------------------------------------------------------
		---- visualizzare i giocatori di un determinato ruolo di una serie ----
		------------------------------------------------------------------------------
*/
//Query che mi ritorna tutti i nomi di tutte le serie nel DB in ordine alfabetico
$resSerie = connessione("SELECT NomeSerie FROM Serie ORDER BY NomeSerie");
$numSerie = mysqli_num_rows($resSerie);
//Query che mi ritorna tutte le nazoionalità presenti nel DB senza dubblicati
$resRuoli = connessione("SELECT DISTINCT Ruolo FROM giocatore ORDER BY Ruolo DESC");
$numRuoli = mysqli_num_rows($resRuoli);

echo '<div align="center"><form action="ricerca_ruoli.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona Ruolo da visualizzare:</font>
	<select name="Ruolo" style="height:20px;">
	<option value="" disabled selected>--seleziona ruolo--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Nazionalità
for($j = 0; $j < $numRuoli; $j++){
	$row7 = mysqli_fetch_assoc($resRuoli);
	$ruolo = $row7["Ruolo"];
	echo "<option value='$ruolo'>$ruolo</option>";
}
echo '</select></div>'; //chiudo inserimento --> Fine dropdown
//stampa secondo dropdown con descrizione annessa
echo '<div align="center"><font size="5" color="white" face="Arial">Seleziona Serie in cui cercare i giocatori:</font>
	<select name="Serie" style="height:20px;">
	<option value="" disabled selected>--seleziona serie--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Serie
for($z = 0; $z < $numSerie; $z++){
	$row8 = mysqli_fetch_assoc($resSerie);
	$NomeSerie = $row8["NomeSerie"];
	echo "<option value='$NomeSerie'>$NomeSerie</option>";
}
echo '</select>'; //chiudo inserimento --> Fine dropdown
echo '<br><input type="hidden" name="page" value="1"><input type="submit" class="button" name="submit" name="someAction" value="Cerca Giocatori"/></form></div>';
//disegna linea di separazione
echo '<br><hr style="height:2px;border-width:0;color:white;background-color:white">';




/*		--------------------------------------------------------------------------------
		---- visualizzare i giocatori sotto una determinata età in ordine crescente ----
		--------------------------------------------------------------------------------
*/

$resGiocatoriEta = connessione("SELECT DISTINCT Eta FROM Giocatore ORDER BY Eta desc");
$numGiocatoriEta = mysqli_num_rows($resGiocatoriEta);

echo '<div align="center"><form action="ricerca_giocatorexeta.php" method="post" style="text-align:center"><font size="5" color="white" face="Arial">Seleziona età sotto la quale visualizzare i giocatori:</font>
	<select name="Eta" style="height:20px;">
	<option value="" disabled selected>--seleziona età--</option>';
//inizio ciclo per l'inserimento nel dropdown dei vari elementi --> Eta dei giocatori
for($y = 0; $y < $numGiocatoriEta; $y++){
	$row4 = mysqli_fetch_assoc($resGiocatoriEta);
	$Eta = $row4["Eta"];
	echo "<option value='$Eta'>$Eta</option>";
}
echo '</select></div>'; //chiudo inserimento --> Fine dropdown
echo '<div align="center"><input type="hidden" name="page" value="1"><input type="submit" class="button" name="submit" name="someAction" value="Cerca Giocatori"/></form></div>';

//disegna linea di separazione
echo '<br><br>';
	


//footer
echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';

?>