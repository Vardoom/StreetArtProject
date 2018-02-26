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
$connect = false;
//var_dump($connect);
if (isset($_POST["login"]) && $_POST["login"] != "" &&
        isset($_POST["mdp"]) && $_POST["mdp"] != "") {
    $dbh = Database::connect();
    $test = htmlspecialchars(Utilisateur::getUtilisateur($dbh, $_POST['login']));
    $test1 = htmlspecialchars(Utilisateur::testerMdp($dbh, $_POST["login"], $_POST["mdp"]));
    if ($test != null && $test1) {
        $connect = true;
        echo "<meta http-equiv='Refresh' content='1;URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=welcome'>";
    }
    $dbh = null;
}
if ($connect) {
    echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="centrage">
                    <br>
                    <h2>Félicitations. Vous êtes connecté.</h2>
                    <br>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <br>
</div>
CHAINE_DE_FIN;
}
if (!$connect) {
    echo <<<CHAINE_DE_FIN
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="centrage">
                <br>
CHAINE_DE_FIN;
    if (!isset($test) && isset($test1)) {
        echo "<em>Le login que vous avez rentré n'existe pas</em>";
    } else {
        if (isset($test1) && !$test1) {
            echo '<em>Le mot de passe rentré est faux</em>';
        }
    }
    echo <<<CHAINE_DE_FIN
    
                    <h2>Formulaire d'identification</h2>
                <form class="form-inline" action="index.php?page=signin&todo=login" method="post">
                    <p><i>Complétez le formulaire. Les champs marqués par </i><em>*</em> sont <em>obligatoires</em></p><br>
                    <fieldset>
                        <legend>Identifiez-vous</legend>
                        <label for="login">Login<em>*</em></label>
                        <input type="text" class="form-control" id="login" placeholder="Login" name="login" required><br>
                        <label for="mdp">Password<em>*</em></label>
                        <input type="password" class="form-control" name="mdp" id="mdp" placeholder="Mot de passe" required><br>
                    </fieldset>
                    <p><button type="submit" class="btn btn-default">Sign in</button></p>
                    <br>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
CHAINE_DE_FIN;
}