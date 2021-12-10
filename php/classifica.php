<?php
include 'connessioneFunzione.php';

if(isset($_POST['NomeSerie'])){ //verifica che il valore passato sia diverso da NULL
	$data = $_POST['NomeSerie']; //in tal caso istanzia la variabile che userò per la query
}

//query che mi restituisce tutte le squadre di una certa seria in ordine descrescente di punti
$res = connessione("SELECT * FROM Squadra WHERE RF_Serie = '$data' ORDER BY Punti desc");
$num = mysqli_num_rows($res);

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title>'. $data .'</title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">
<div align="center" id="title">'. $data .'</div>'; //inserisco il titolo

$i = 1;
while($i <= $num){
	$row = mysqli_fetch_assoc($res);
	$Squadra = $row["NomeSquadra"];
	$Punteggio = $row["Punti"];
	echo "<div align='center'><font style='color:white; border:2px; text-shadow:4px 0px #000000; font-family:Arial; font-size:65px;'><b>$i</b></font><font style='color: yellow;font-family:Arial;font-size: 50px'>	$Squadra</font><font style='color: blue;font-family:Arial;font-size: 50px;'>	 $Punteggio</font></div>";
	$i++;
}

//Pulsante HOME PAGE
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';
?>