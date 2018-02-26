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
        border: 3px black double;
        border-radius: 10px;
    }
    body{
        background-image: url('images/murdebriques.jpg');
        background-size: cover;
    }

    img{
        border-radius : 10px;
    }

    button.btn:hover {
        color: white;
        background-color: black;
        border-color: grey;
    }
</style>

<?php
$image = htmlspecialchars($_GET["todo"]);
$id = htmlspecialchars($_GET["iD"]);
$resultat = Image::getImageId($dbh, $_GET["iD"]);
$utilisateur = htmlspecialchars($resultat->utilisateur);
$link = "images/" . $utilisateur . $id . ".jpg";
if (isset($_GET['delete'])) {
    $delete = htmlspecialchars($_GET['delete']);
} else {
    $delete = false;
}
$test = Image::estAUtilisateur($dbh, $_SESSION['login'], $_GET["iD"]);
//$nomAvecEspace = $resultat -> nom;
//$nomSansEspace = str_replace(' ','_',$nomAvecEspace);
//var_dump($nomSansEspace);
if (!$delete) { //La photo ne peut pas être supprimée
    $largeur = 600;
    $hauteur = htmlspecialchars(Image::hauteurProportionnelle($resultat, $largeur));
    echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <br>
                <img style="border-radius: 8 px; max-width: 100%; height: auto;" src=$link width=$largeur px height=$hauteur px/>
            </div>
            <div class="col-md-5">
                <br>
                <div class="col-md-10 col-md-offset-2 centrage" style="text-align:left">
                    <h1 style="font-family:Impact;text-transform:uppercase;">$resultat->nom</h1>
                    <h3><i>Utilisateur: $resultat->utilisateur</i><h3>
                    <h4 style="text-align : justify; font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif">
                        $resultat->description
                    </h4>
                </div>
            </div>
CHAINE_DE_FIN;
}
//Si c'est l'image de l'utilisateur, on affiche un bouton pour supprimer la photo
if ($test or $_SESSION['admin'] == true) {
    if (!$delete) {
        echo <<<CHAINE_DE_FIN
            <div class="col-md-2" style="text-align: center">
                <form class="form-inline" action="index.php?page=description&todo=$image&iD=$id&delete=true" method="post">
                    <br><br><p><button type="submit" class="btn btn-outline-secondary btn-lg">Supprimer la photo</button></p></form>
            </div>
CHAINE_DE_FIN;
    }
}
echo <<<CHAINE_DE_FIN
        </div>
    </div>
</div>
CHAINE_DE_FIN;
//Si c'est l'image de l'utilisateur, et qu'il a demandé à la supprimer, on lance le php
if ($test or $_SESSION['admin'] == true) {
    if ($delete) {
        $verif = Image::supprimer($dbh, $_GET["iD"]);
        if ($verif) {
            echo "<meta http-equiv='Refresh' content='1; URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=welcome'>";
            unlink($link);
            unlink('miniatures/mini_' . $utilisateur.$id . '.jpg');
        }
    }
}

