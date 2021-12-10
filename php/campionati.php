<?php

include 'connessioneFunzione.php';

$res = connessione("SELECT * FROM Campionato");

$num = mysqli_num_rows($res);

echo '<head>
<link rel="icon" type="image/png" href="favicon.jpg"/>
<link rel="stylesheet" href="stileGenerale.css">
<title> Campionati </title>
</head>
<body>
<div class="bg">
<div align="center" id="title">Campionati</div>';

$i = 0;
$filephp = 'serie.php';
while($i < $num){
	$row = mysqli_fetch_assoc($res);
	$Nazionalita = $row["Nazionalita"];

	echo "<div align='center'><div id='subTitle'>$Nazionalita</div>  <form action=$filephp method=" . "post>
	<input type='hidden' name='Nazionalita' value=$Nazionalita><input class='button button3' type='submit' name='submit'" . 'name="someAction"' . "value='Vedi Serie $Nazionalita' size='100px'/>
	</form></div>";
	$i++;
}
echo'<div class="footer"><marquee direction="right"><font color="white" face="Arial">Federico Canali e Francesco Marchi</font><img src="run.gif" height="50px"></marquee>
</div></div>
</body>

</html>';

?>