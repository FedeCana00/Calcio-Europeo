<?php
include 'connessioneFunzione.php';

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<title>Aggiunta Punteggi</title>
<link rel="stylesheet" href="stileGenerale.css">
</head>
<body>
<div class="bg">
<div align="center" id="title">Aggiunta Punteggi</div>
<br><br<br>
<form action="aggiuntaPt.php" method="post" style="text-align:center"><font size="6" color="white" face="Arial">Seleziona incontro a cui aggiungere un punteggio:</font>
<select name="incontro" style="height:20px;">
<option value="" disabled selected>--seleziona incontro--</option>';

//ottengo le parite non ancora disputate --> Valore NULL nei punteggi
$incontriNonDisputati = connessione("SELECT ID,RF_Squadra1,RF_Squadra2 FROM Incontro,Calendario WHERE RF_Calendario = ID AND Punteggio_1 IS NULL AND Punteggio_2 IS NULL");
$num = mysqli_num_rows($incontriNonDisputati);

for($i = 0; $i < $num; $i++){
	$row = mysqli_fetch_assoc($incontriNonDisputati);
	$squadraCasa = $row["RF_Squadra1"];
	$squadraOspite= $row["RF_Squadra2"];
	$ID = $row['ID'];
	echo "<option value='$ID'>$squadraCasa - $squadraOspite</option>";
}

echo '</select>';
echo '<div align="center"><font size="12" face="Arial" color="white">Squadra in CASA</font><input type="text" name="punteggioCasa" size="1"/>
	<font size="12" face="Arial" color="white"> Squadra OSPITE</font><input type="text" name="punteggioOspite" size="1"/></div>';
echo '<br><input type="submit" class="button button3" name="submit" name="someAction" value="Aggingi"/></form></div>';

//aggiunta del pulsante per tornare nella schermata home
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '</div><div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>

</html>';
?>