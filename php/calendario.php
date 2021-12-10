<?php

include 'connessioneFunzione.php';

if(isset($_POST['NomeSerie'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['NomeSerie']; //in tal caso istanzia la variabile che userò per la query
}
if(isset($_POST['page'])){
	$page = $_POST['page']; //passo il valore 1 per indicare che devo visualizzare la prima giornata
}


//Query che mi ritorna tutti i parametri degli incontri di una giornata di una serie selezionate
$incontri = connessione("SELECT * FROM Incontro,Calendario WHERE RF_Calendario = ID AND RF_Serie = '$data' AND NumGiornata = $page");

$num = mysqli_num_rows($incontri);

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title>Calendario</title>
</head>
<body>
<div class="bg">
<div align="center" id="title">Calendario '. $data .'</div>'; //inserisco il titolo

for($i = 0;$i < $num;$i++){
	$row = mysqli_fetch_assoc($incontri);
	$NumGiornata = $row["NumGiornata"];
	if($i == 0){
		echo "<br><br><div align='center' style='	color: yellow;border: 2px;text-shadow: 4px 0px #858585;font-family: Comic Sans MS;font-size: 65px;'
>Giornata <b>$NumGiornata</b></div><br>";
	}
	$PunteggioCasa = $row["Punteggio_1"];
	$PunteggioOspite = $row["Punteggio_2"];
	$dataincontro = $row["DataIncontro"];
	$SquadraCasa = $row["RF_Squadra1"];
	$SquadraOspite = $row["RF_Squadra2"];
	echo "<div align='center'><font size='10' face='Arial' color='white'>$SquadraCasa  $PunteggioCasa - $PunteggioOspite  $SquadraOspite</font><br></div>";
}

$precedente = $page - 1;
$successiva = $page + 1;

//pulsante precedente solo se maggiore della prima giornata
if($precedente >= 1){
	echo "<div style='position:absolute;top:600px;left:30px;'><form action='calendario.php' method= post><input type='hidden' name='page' value=$precedente>
			<input type='hidden' name='NomeSerie' value='$data'><input type='submit' class='button button3' name='submit'" . 'name="someAction"' . "value='Precedente' size='100px'/>
			</form></div>";
}
//pulsante successiva solo se minore della sedicesima giornata
if($successiva <= 14){
	echo "<div style='position:absolute;top:600px;right:30px;'><form action='calendario.php' method= post><input type='hidden' name='page' value=$successiva>
			<input type='hidden' name='NomeSerie' value='$data'><input type='submit' class='button button3' name='submit'" . 'name="someAction"' . "value='Successiva' size='100px'/>
			</form></div>";
}

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '</div><div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>