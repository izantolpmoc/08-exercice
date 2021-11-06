<?php
/* EXERCICE :
=> Création d'un repertoire :

	-- 1 - Création bdd 'repertoire'



	-- 2 - Création table 'annuaire'(id_annuaire, nom, prenom, telephone, ville, cp, adresse)
*/

// 3 - Connexion BDD

$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
// 4 - formulaire d'enregistrement
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Annuaire</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Open+Sans+Condensed:ital,wght@0,300;0,700;1,300&family=Roboto+Mono&family=Roboto:wght@400;700;900&family=Zen+Antique+Soft&family=Zen+Kaku+Gothic+Antique:wght@400;700&family=Zen+Kurenaido&display=swap');
		*{
			font-family: 'Open Sans Condensed', sans-serif;
			color: white;
		}

		body{
			background-color: steelblue;
			background-image: url('https://cdn.pixabay.com/photo/2019/02/04/07/36/new-year-3974099_960_720.jpg');
			background-repeat: no-repeat;
			background-size: cover;
			background-position: center;
			background-attachment: fixed;
		}
		.container{
			height: 100vh;
			display: flex;
			flex-direction: column;
			align-items: center;
			backdrop-filter: blur(3px);
		}
		.container h1{
			color: red;
			font-size: 35px;
		}
		.divinput{
			display: flex;
			flex-direction: column;
			margin: 15px;
			font-size: 20px;
			color: white;
		}
		.divinput input{
			width: 15em;
			height: 3em;
			color: black;
		}
		.button{
			color: black;
			display: block;
			margin: 0 auto;
			width: 7em;
			background-color: red;
			border: solid black 5px;
			border-radius: 5px;
			padding: 5px;
		}

		.button :hover{
			cursor: pointer;
		}

		table{
			margin: 0 auto;
			background-color: rgba(0,0,0,0.7);
			text-align: center;
			border-radius: 10px;
			padding: 5px;
		}

		table td{
			padding: 5px;
		}

		table th{
			padding: 7px;
		}

		.title{
			text-align: center;
			background-color: black;
			padding: 5px;
			color: whitesmoke;
			width: 100%;
		}
	</style>
</head>
<body>
	<section class="container">
		<h1 class="title">Annuaire du Père Noël</h1>
		<form action="" method="POST">

		<div class="divinput">
			<label for="nom">Nom</label>
			<input type="text" name="nom" id="nom">
		</div>
		<div class="divinput">
			<label for="prenom">Prénom</label>
			<input type="text" name="prenom" id="prenom">
		</div>
		<div class="divinput">
			<label for="telephone">Téléphone</label>
			<input type="text" name="telephone" id="telephone">
		</div>
		<div class="divinput">
			<label for="ville">Ville</label>
			<input type="text" name="ville" id="ville">
		</div>
		<div class="divinput">
			<label for="cp">Code Postal</label>
			<input type="text" name="cp" id="cp">
		</div>
		<div class="divinput">
			<label for="adresse">Adresse</label>
			<input type="text" name="adresse" id="adresse">
		</div>

		<input class="button" type="submit" value="Envoyer">

		</form>
	</section>

	<section class="container">
	<h1 class="title">Personnes déjà inscrites: 🎅🔻</h1>
	<p>Si vous les supprimez, ou si vous les harcelez, ce n'est pas gentil. Vous n'aurez pas de cadeau.</p><br>



<?php
// 5 - Insertion en base

// print '<pre>';
// 		print_r($_POST);
// print '</pre>';

if($_POST){

	$pdostatement = $pdo -> prepare("INSERT INTO annuaire (nom, prenom, telephone, ville, cp, adresse) VALUES(:nom, :prenom, :telephone, :ville, :cp, :adresse)");

    foreach($_POST as $indice => $valeur){

        $_POST[$indice] = addslashes($_POST[$indice]);
        $_POST[$indice] = stripslashes($_POST[$indice]);
        $_POST[$indice] = htmlentities($_POST[$indice]);
		$_POST[$indice] = strip_tags($_POST[$indice]);
    }

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$telephone =$_POST['telephone'] ;
$ville = $_POST['ville'];
$cp = $_POST['cp'];
$adresse = $_POST['adresse'];

$pdostatement -> bindValue(":nom", $nom, PDO::PARAM_STR );
$pdostatement -> bindValue(":prenom", $prenom, PDO::PARAM_STR );
$pdostatement -> bindValue(":telephone", $telephone, PDO::PARAM_STR );
$pdostatement -> bindValue(":ville", $ville, PDO::PARAM_STR );
$pdostatement -> bindValue(":cp", $cp, PDO::PARAM_STR );
$pdostatement -> bindValue(":adresse", $adresse, PDO::PARAM_STR );

$pdostatement -> execute();
}
// 6 - Affichage du repertoire sous forme de tableau !!

$pdostatement = $pdo -> query("SELECT * FROM annuaire");

echo "<table border= '2'>";

	echo '<tr>';

		$nombre_colonne = $pdostatement->columnCount();

		for($i = 0; $i < $nombre_colonne; $i++){
			$champ = $pdostatement->getColumnMeta($i);

			// print '<pre>';
            //     print_r($champ);
            // print '</pre>';

			echo "<th>$champ[name]</th>";
		}

	echo "<th>Suppression</th>";

	echo '</tr>';

	while($ligne = $pdostatement->fetch(PDO::FETCH_ASSOC)){

		// print '<pre>';
        //     print_r($ligne['id_annuaire']);
        // print '</pre>';

		echo '<tr>';

		foreach($ligne as $value){
			echo "<td> $value </td>";
		}
		echo "<td><a class='delete' href='?idnumber=" . $ligne['id_annuaire']. "'>❌</a></td>";

		echo '</tr>';
	}

echo "</table>";


// 7 - bonus : ajout d'une colonne "suppression" 
if(isset($_GET['idnumber'])){
	// $_GET['postnumber'] = $number_id;
	
	function delete($identity){
	
		global $pdo;
	
		$pdo -> exec("DELETE FROM annuaire WHERE id_annuaire = '{$identity}'");
	
	}
	
	delete($_GET['idnumber']);
	};

?>
	</section>
</body>
</html>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>