<?php

include 'connessioneFunzione.php';

if(isset($_POST['NomeSerie'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['NomeSerie']; //in tal caso istanzia la variabile che userò per la query
}

//Query che mi ritorna tutti i parametri delle squadre della seire selezionata
$res = connessione("SELECT * FROM Squadra WHERE RF_Serie = '$data' ");

$num = mysqli_num_rows($res);

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title>'. $data .'</title>
</head>

<body>
<div class="bg">
<div align="center" id="title"> '. $data .'</div>'; //inserisco il titolo

$i = 0;
$filephp = 'giocatori.php';
echo '<br><br><div align="center"><table border="0" align="middle">'; //crea la tabella
while($i < $num){
	$row = mysqli_fetch_assoc($res);
	$Squadra = $row["NomeSquadra"];
	$NomeSerie = $row["RF_Serie"];
	if($i == 0){ //eseguo solo una volta
		//pulsante classifica
		echo "<tr><th><form action='classifica.php' method= post>
			<input type='hidden' name='NomeSerie' value='$NomeSerie'><input type='submit' class='button button4' name='submit'" . 'name="someAction"' . "value='Classifica' size='100px'/>
			</form></th>";
		//pulsante calendario
		echo "<th><form action='calendario.php' method= post><input type='hidden' name='page' value=1>
			<input type='hidden' name='NomeSerie' value='$NomeSerie'><input type='submit' class='button button4' name='submit'" . 'name="someAction"' . "value='Calendario' size='100px'/>
			</form></th></tr>";
	}
	if($i % 2 == 0){//inizio di riga prima colonna
		echo "<tr> <th><div align='center' class='pad'><font size='14' face='Arial' color='white'>$Squadra</font>  <form action=$filephp method=" . "post>
		<input type='hidden' name='NomeSquadra' value='$Squadra'><input type='submit' class='button button3' name='submit'" . 'name="someAction"' . "value='Vedi $Squadra' size='100px'/>
		</form></div></th>";
	} else{ //seconda colonna chiusa di riga
		echo "<th><div align='center' class='pad'><font size='14' face='Arial' color='white'>$Squadra</font>  <form action=$filephp method=" . "post>
		<input type='hidden' name='NomeSquadra' value='$Squadra'><input type='submit' class='button button3 name='submit'" . 'name="someAction"' . "value='Vedi $Squadra' size='100px'/>
		</form></div></th></tr>";
	}
	$i++;
}
echo '</table></div>'; //chiude la tabella
echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';
?>