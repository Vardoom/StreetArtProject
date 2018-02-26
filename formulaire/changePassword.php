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
$change_Password = false;
if (isset($_POST["login"]) && $_POST["login"] != "" &&
        isset($_POST["up0"]) && $_POST["up0"] != "" &&
        isset($_POST["up1"]) && $_POST["up1"] != "" &&
        isset($_POST["up2"]) && $_POST["up2"] != "") {
    $dbh = Database::connect();
    $test = htmlspecialchars(Utilisateur::getUtilisateur($dbh, $_POST['login']));
    $test1 = htmlspecialchars(Utilisateur::testerMdp($dbh, $_POST["login"], $_POST["up0"]));
    if ($test != null && $test1) {
        $sth = $dbh->prepare("UPDATE `utilisateurs` SET mdp=? WHERE login =? ");
        $sth->execute(array(SHA1($_POST['up1']), $_POST['login']));
        $change_Password = true;
        echo "<meta http-equiv='Refresh' content='1;URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=welcome'>";
    }
    $dbh = null;
}
if ($change_Password == true) {
    echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="centrage">
                    <br>
                    <h2>Votre mot de passe a été changé</h2>
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
if (!$change_Password) {
    echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class=""></div>
            </div>
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
    
                    <h2>Changer le mot de passe</h2>
                    <form class="form-inline" action="index.php?page=changePassword" method="post"
                          oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">
                        <p><i>Complétez le formulaire. Les champs marqués par </i><em>*</em> sont <em>obligatoires</em></p><br>
                        <fieldset>
                            <legend>Modifiez votre mot de passe</legend>
                            <label for="login">Login<em>*</em></label>
                            <input type="text" class="form-control" id="login" placeholder="Login" name="login" required><br><br>
                            <label for="password0">Ancien mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up0" id="password0" placeholder="Ancien" required><br><br>
                            <label for="password1">Nouveau mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up1" id="password1" placeholder="Nouveau" required><br><br>
                            <label for="password2">Confirmer votre nouveau mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up2" id="password2" placeholder="Confirmer" required><br>
                        </fieldset>
                        <p><button type="submit" class="btn btn-default">Valider</button></p>
                    </form>
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