<style>
    p {
        margin-top: 0px;
    }

    fieldset {
        margin-bottom: 15px;
        padding: 10px;
    }

    legend {
        padding: 0px 3px;
        font-weight: bold;
        font-variant: small-caps;
    }

    label {
        width: 110px;
        display: inline-block;
        vertical-align: top;
        margin: 6px;
    }

    em {
        font-weight: bold;
        font-style: normal;
        color: #f00;
    }

    input:focus {
        background: #eaeaea;
    }

    input, textarea {
        width: 249px;
    }

    textarea {
        height: 100px;
    }

    select {
        width: 254px;
    }

    input[type=checkbox] {
        width: 10px;
    }

    input[type=submit] {
        width: 150px;
        padding: 10px;
    }

    .centrage{
        text-align: center;
        background-color: white;
        background-image: url("images/fondecranmotif.jpeg");
        border: 3px black groove;
        border-radius: 10px;
    }

    body{
        background-image: url("images/CollageStreetArt.jpeg");
    }

</style>

<?php
$_POST['utilisateur'] = htmlspecialchars($_SESSION['login']);
$form_values_valid = false;
if (isset($_POST["nom"]) && $_POST["nom"] != "" &&
        isset($_POST["utilisateur"]) && $_POST["utilisateur"] != "" &&
        isset($_POST["lat"]) && $_POST["lat"] != "" &&
        isset($_POST["lng"]) && $_POST["lng"] != "") {
    // code de traitement    
    $dbh = Database::connect();
    $verif = htmlspecialchars(Image::insererImage($dbh, $_POST['utilisateur'], $_POST['nom'], $_POST['lat'], $_POST['lng'], $_POST['description']));
    $id = $verif;
    if ($verif != 0 && isset($id)) {
        $_POST['id'] = htmlspecialchars($id);
        $form_values_valid = true; // si le traitement réussit, on passe $form_value_valid à true
        echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="centrage">
                    <br>
                    <h2>Image uploadée</h2>
                        <p><i>Votre image a bien été uploadée !!</i></p><br>
                        <p>Vous allez être redirigé vers votre gallerie d'images.<p>
                    <br>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <br>
</div>
CHAINE_DE_FIN;
        echo "<meta http-equiv='Refresh' content='1;URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=mesImages'>";
    }
    $dbh = null;
}

if (!empty($_FILES['fichier']['tmp_name']) && is_uploaded_file($_FILES['fichier']['tmp_name'])) {
// Le fichier a bien été téléchargé
// Par sécurité on utilise getimagesize plutot que les variables $_FILES
    list($larg, $haut, $type, $attr) = getimagesize($_FILES['fichier']['tmp_name']);
//    echo $larg . " " . $haut . " " . $type . " " . $attr;
// JPEG => type=2
    if ($type == 2) {
        if (move_uploaded_file($_FILES['fichier']['tmp_name'], '/Applications/XAMPP/xamppfiles/htdocs/StreetArtProject2/StreetArtProject/images/' . $_POST['utilisateur'] . $_POST['id'] . '.jpg')) {
            $name = htmlspecialchars($_POST['utilisateur'] . $_POST['id']);
            Image::createMiniature($name);
        } else {
            echo "Echec de la copie";
        }
    } else {
        echo "Mauvais type de fichier ";
    }
}

if (!$form_values_valid) {
    echo <<<CHAINE_DE_FIN

<div class="fondecran">
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="centrage col-md-10 col-md-offset-1">
                    <br>
                    <h2>Uploadez vos photos</h2>
                    <form class="form-inline" action="index.php?page=submit" method="post" enctype="multipart/form-data">
                        <!--p><i>Complétez le formulaire. Les champs marqués par </i><em>*</em> sont <em>obligatoires</em></p><br-->

                        <fieldset>
                            <legend>Votre photo</legend>

                            <label for="nom">Nom de la photo</label>
                            <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom" required><br><br>

                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Décrivez votre photo" rows=10 COLS=50></textarea><br><br>

                            <label for="fichier">Votre photo</label>
                            <input type="hidden" class="form-control" name="MAX_FILE_SIZE" value="104857600" />
                            <input type="file" class="form-control" name="fichier"/><br>
                            <strong>Taille du fichier limitée à 10 Mo</strong><br><br>

                        </fieldset>

                        <fieldset>
                            <legend>Emplacement de la photo</legend>

                            <p><i>Utilisez le module de droite pour trouver vos coordonnées.</i></p>

                            <label for="lat">Latitude</label>
                            <input type="number" step="any" class="form-control" name="lat" id="lat" placeholder="Latitude" required><br><br>

                            <label for="lng">Longitude</label>
                            <input type="number" step="any" class="form-control" name="lng" id="lng" placeholder="Longitude" required><br><br>

                        </fieldset>

                        <p><button type="submit" class="btn btn-default">Ajouter à ma galerie</button></p>

                    </form>
                    <br>
                </div>
            </div>

            <div class="col-md-6">
                <div class="centrage col-md-10 col-md-offset-1" >
                    <br>
                    <h2>Trouvez-moi !!</h2>

                    <form class="form-inline">

                        <fieldset>
                            <legend>Module de géolocalisation</legend>

                            <label for="adresse">Adresse</label>
                            <input type="text" class="form-control" id="adresse" name="Adresse" placeholder="Adresse">
                        </fieldset>

                        <button class="btn btn-danger" id="btn-geocode">Récupérer les coordonnées</button><br>

                    </form>

                    <form class="form-inline">
                        <br>
                        <button class="btn btn-success" id="btn-geoloc">Me géolocaliser</button>
                        <br>
                    </form>

                    <form class="form-inline">

                        <fieldset>
                            <br>
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" placeholder="latitude"><br><br>

                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" placeholder="longitude">

                        </fieldset>

                        <button class="btn btn-info" id="btn-carte">Afficher sur la carte</button>

                    </form>
                    <br>
                </div>
                <div class="col-md-12" id="map-canvas" style="height:400px"></div>
            </div>
        </div>
    </div>
    <br>
</div>
    
CHAINE_DE_FIN;
}
