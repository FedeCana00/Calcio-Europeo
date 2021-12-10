<?php
include 'connessioneFunzione.php';

//ottenfo tutti i giocatori ordinati per cognome
$giocatore = connessione("SELECT * FROM Giocatore ORDER BY Cognome");
//Ottengo tutte le squadre selezionalibili
$squadra = connessione("SELECT * FROM Squadra");

$numGiocatore = mysqli_num_rows($giocatore);
$numSquadra = mysqli_num_rows($squadra);

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title>Traferimenti</title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">
<div align="center" id="title">Trasferimenti
<form action="trasferimenti.php" method="post" style="text-align:center"><font size="14" color="white" face="Arial">Seleziona il giocatore da trasferire:</font>
<select name="giocatore" style="height:35px">
<option value="" disabled selected>--seleziona giocatore--</option>';

for($i = 0; $i < $numGiocatore; $i++){
	$row1 = mysqli_fetch_assoc($giocatore);
	$Nome = $row1["Nome"];
	$Cognome = $row1["Cognome"];
	$CF = $row1["CF"]; //passo il codice fiscale univoco in modo da eliminare il giocatore correttamente selezionato
	echo "<option value='$CF'>$Cognome $Nome</option>";
}
echo '</select>';
echo '<br><font size="14" color="white" face="Arial">Seleziona la squadra in cui trasferire il giocatore:</font>
<select name="squadra" style="height:35px">
<option value="" disabled selected>--seleziona squadra--</option>';

for($z = 0; $z < $numSquadra; $z++){
	$row2 = mysqli_fetch_assoc($squadra);
	$NomeSquadra = $row2["NomeSquadra"];
	echo "<option value='$NomeSquadra'>$NomeSquadra</option>";
}
echo '</select><br><input type="submit" class="button button3" name="submit" name="someAction" value="Traferisci"/></form></div>';

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';

?>