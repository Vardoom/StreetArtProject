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

//var_dump($_POST);
if (isset($_POST["login"]) && $_POST["login"] != "" &&
        isset($_POST["up"]) && $_POST["up"] != "") {
    $dbh = Database::connect();
    $test = htmlspecialchars(Utilisateur::getUtilisateur($dbh, $_POST['login']));
    $test1 = htmlspecialchars(Utilisateur::testerMdp($dbh, $_POST["login"], $_POST["up"]));
    //var_dump($test1);
    if ($test != null && $test1 != 0) {
        $sth = $dbh->prepare("DELETE FROM `utilisateurs` WHERE `login`=?");
        $sth->execute(array($_POST['login']));
        $change_Password = true;
    }
    $dbh = null;
}

if ($change_Password) {
    echo "<div>Votre compte a été supprimé</div>";
    echo "<meta http-equiv='Refresh' content='1; URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=welcome&todo=logout'>";
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
                    <h2>Supprimer votre compte</h2>
                    <form class="form-inline" action="index.php?page=deleteUser" method="post"
                          oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">
                        <p>
                            <i>Complétez le formulaire. Les champs marqués par </i><em>*</em> sont <em>obligatoires</em><br>
                            Cette action est définitive.
                        </p><br>
                        <fieldset>
                            <legend>Supprimez votre compte</legend>
                            <label for="login">Login<em>*</em></label>
                            <input type="text" class="form-control" id="login" placeholder="Login" name="login" required><br>
                            <label for="password0">Mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up" id="password0" placeholder="Ancien" required><br>
                        </fieldset>
                        <p><button type="submit" class="btn btn-default">Au revoir</button></p>
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