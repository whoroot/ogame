<?php
//phpinfo();
// code by mousshk@gmail.com
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Europe/Paris");
#inclusion des fonctions
include('fonctions.php');
#inclusion des calculs sources
include('source.php');

?>
<head>
<style>
    <?php include('style.css'); ?>
</style>
<!-- cette balise permet de s'adapter au format mobile et d'avoir le bon zoom
à l'ouverture de la page -->
<meta name="viewport" content="width=device-width, maximum-scale=1"/>
<!-- Inclusion de l'icone d'onglet -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $icon; ?>" />

<title>Ogame Alliance</title>
</head>

<?php
$timeStamp ="1478702500";
$duree = 7;
$dateNexUpdate = date('d/m/Y', strtotime('+'.$duree.'day', $timeStamp ));
if($timeStamp !=""){
	echo '<div class="center">';
	echo 'Dernière MAJ, le '.date('d/m/Y', $timeStamp).' &agrave; '.date('H:i:s', $timeStamp);
	echo '</div>';
	echo '<div class="infoStandard center">(Prochaine MAJ le '.$dateNexUpdate.')</div>';

}

 
						

#Info sur un joueur ciblé
//ID du joueur
?>
<div class="menuHead">
<?php
# Génération du Menu
echo '<a href="https://s144-fr.ogame.gameforge.com/api/players.xml" class="menuPadding" target="_blank">XML players Global</a>';
echo '<a href="https://s144-fr.ogame.gameforge.com/api/playerData.xml?id=100178" class="menuPadding" target="_blank">XML player</a>';
?>
</div>
<div style="overflow-x:auto;" id="player" name="player" class="panelDark">
	<div id="Title" class="headPanelTitle">
		<h2>Info joueur</h2>
	</div>
	<div class="center intro">
	En entrant le nom d'un joueur, vous pourrez obtenir toutes ses colonnies.</br>
	Notez que les informations sont automatiquement mises à jour 1 fois par SEMAINE.
	</div>
	<div id="infoPlayer" class="center">
		<?php
		if(isset($_POST['namePlayer'])){
			$player = array();
			$xmlAll = simplexml_load_file('https://s144-fr.ogame.gameforge.com/api/players.xml');
			foreach ($xmlAll->player as $value) {
				if(strtolower($value['name'])==strtolower($_POST['namePlayer'])){
					$player[] = array($value['id'],$value['name']);
				}
				
			}
			if($player[0][0]!=""){
				$xmlPlayer = simplexml_load_file('https://s144-fr.ogame.gameforge.com/api/playerData.xml?id='.$player[0][0]);
				echo '<table>';
				echo '<tr><td>Joueur</td><th>'.$player[0][1].' </th></tr> ';
				echo '<tr><td>Planètes</td><td>';
					foreach ($xmlPlayer->planets->planet as $key => $value) {
							echo '<font class="cyanResult">'.$value['name'].' ['.$value['coords'].'] </font>';
					}
				echo'</td></tr><tr><td>Alliance</td><td>';
					foreach ($xmlPlayer->alliance as $value) {
							echo '<font class="greenResult">'.$value->name.' ['.$value->tag.'] </font>';
					}
					echo'</td></tr></table>';
			}
			else{
				echo '<font class="redResult">Aucun joueur trouvé à ce nom</font>';
			}
		}
		?>
	</div>
	<div id="form" class="center">
		<form action="" method="post">
		<input type="text" name="namePlayer">
		<input type="submit" name="ok" value="CHERCHER">
		</form>
	</div>
	
</div>






<div style="overflow-x:auto;" id="alliance" name="player" class="panelDark">
	<div id="Title" class="headPanelTitle">
		<h2>Alliance</h2>
		<?php
		$xmlPlayer = simplexml_load_file('https://s144-fr.ogame.gameforge.com/api/playerData.xml?id=100178');
		foreach ($xmlPlayer->alliance as $value) {
			echo '<font class="infoStandard">'.$value->name.' ['.$value->tag.'] ';
		}
		?>
	</div>
<?php
## INFOS ALLIANCE ##
//$xmlstr='https://s144-fr.ogame.gameforge.com/api/playerData.xml?id=100178';


$idPlayer = array();
$xmlAll = simplexml_load_file('https://s144-fr.ogame.gameforge.com/api/players.xml');
foreach ($xmlAll->player as $value) {
	if($value['alliance']=="27"){
		//echo $value['name'].' ('.$value['id'].')<br>';
		$idPlayer[] = array($value['id'],$value['name']);
	}
	
}

echo '<table><tr><td>Joueurs</td>';

for($i=1;$i<8;$i++){
	echo '<th>G '.$i.'</th>';
}
echo '</tr>';
	foreach ($idPlayer as $keyPlayer => $valuePlayer) {
		echo '<tr>';
		echo '<th>'.$idPlayer[$keyPlayer][1].' </th> ';
		$xmlPlayer = simplexml_load_file('https://s144-fr.ogame.gameforge.com/api/playerData.xml?id='.$idPlayer[$keyPlayer][0]);
		for($i=1;$i<8;$i++){
			echo '<td><table>';
			foreach ($xmlPlayer->planets->planet as $key => $value) {
				$pattern = "/^(".$i.")/";
                if(preg_match($pattern,$value['coords'])){
					echo '<tr><td>'.$value['name'].' ['.$value['coords'].'] </tr></td>';
				}
			}
			echo '</table></td>';
		}
		echo '<tr>';
	}

echo '</table>';
?>

</div>
<div class="footer">
	@Mousshk - 2016
</div>