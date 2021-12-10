<?php

include 'connessioneFunzione.php';

if(isset($_POST['GiocatoreID'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['GiocatoreID']; //in tal caso istanzia la variabile che userò per la query
}

//Query che mi ritorna tutti i parametri del giocatore selezionato attraverso il codice univoco
$res = connessione("SELECT * FROM Giocatore WHERE CF = '$data'");

$num = mysqli_num_rows($res);

echo '<html><head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title>' . "$data" . '</title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">
<div align="center" id="title"> Descrizione Calciatore</div>';

$row = mysqli_fetch_assoc($res);
$CognomeNome = $row["Cognome"] . ' ' . $row["Nome"]; //definisco prima per poterlo inserire in title
$R = $row["Ruolo"];
switch($R){ //definisco per esteso il nome del ruolo del giocatore
		case 'P':
			$Ruolo = 'Portiere';
			break;
		case 'D':
			$Ruolo = 'Difensore';
			break;
		case 'C':
			$Ruolo = 'Centrocampista';
			break;
		case 'A':
			$Ruolo = 'Attaccante';
			break;
}

$CF = $row["CF"]; //serve per identificare in modo univoco il calciatore
$DataNasc = $row["DataNasc"];
$S = $row["Sponsor"];
$avatar = str_replace(' ', '', $CognomeNome) . '.png';
if($S ==''){ //verifico se lo spoonsor esiste
	$Sponsor = 'Nessuno Sponsor';
} else {
	$Sponsor = $S;
}
$Eta = $row["Eta"];
$Valore = $row["Valore"];
$Nazionalita = $row["Nazionalita"];

//costruzione della carta giocatore
echo '<div align="center"><div class="card"><img src=' . $avatar . ' alt="Avatar" style="width:100%;max-height: 40%;">
	<div class="container"><h4><b>' . $CognomeNome . "</b></h4>$Ruolo<p></p></div></div></div>";
echo '<br>';
//costruzione dei dati restanti del giocatore
echo "<div align='center'><table border='3' align='middle' style='background-color:white'>
	  <tr><td><font class='textTabellaSchedaG1'><b>Codice Fiscale:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$CF</font></td></tr>
	  <tr><td><font class='textTabellaSchedaG1'><b>Data di Nascita:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$DataNasc</font></td></tr>
	  <tr><td><font class='textTabellaSchedaG1'><b>Età:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$Eta</font></td></tr>
	  <tr><td><font class='textTabellaSchedaG1'><b>Nazionalità:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$Nazionalita</font></td></tr>
	  <tr><td><font class='textTabellaSchedaG1'><b>Sponsor:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$Sponsor</font></td></tr>
	  <tr><td><font class='textTabellaSchedaG1'><b>Valore:</b></font></td>
	  <td><font class='textTabellaSchedaG2'>$Valore €</font></td></tr></table></div>";

echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';

?>