<?php

/* Credenziali che mi aspetto durante la compilazione*/
$username = 'Administrator';
$password = 'Progetto2021';

$IN_username = $_POST['username'];
$IN_password = $_POST['password'];

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title>Settings</title>
</head>
<body>
<div class="bg">
<div align="center" id="title">Settings</div><br>';

if($IN_username <> $username OR $IN_password <> $password){
	echo '<div align="center"><font size="12" face="Arial" color="red">Credenziali ERRATE!</font></div>';
	echo '<div align="center"><font size="6" face="Arial" color="white">Cliccare su la HOME e riprovare..</font></div>';
} else {

echo '<div align="center"><form action="incontro.php" method="post" style="width:auto;"><input type="submit" class="button button3" value="Aggiornamento Incontri"/></form>
<br><br><form action="classifica_update.php" method="post" style="widht:auto;"><input type="submit" class="button button3" value="Aggiornamento Punti"/></form>
<br><br><form action="punteggiRandom.php" method="post" style="widht:auto;"><input type="submit" class="button button3" value="Generazione Casuale Punteggi"/></form></div>';
}
echo '</div>';

//aggiunta del pulsante per tornare nella schermata home
echo '<a href="index.html" class="home"><image src="home.png" width="100px" height="100px"></a>';

echo '<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee></div>
</div>
</body>
</html>';
?>