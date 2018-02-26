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
$form_values_valid = false;


if (isset($_POST["login"]) && $_POST["login"] != "" &&
        isset($_POST["email"]) && $_POST["email"] != "" &&
        isset($_POST["naissance"]) && $_POST["naissance"] != "" &&
        isset($_POST["email"]) && $_POST["email"] != "" &&
        isset($_POST["nom"]) && $_POST["nom"] != "" &&
        isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
        isset($_POST["up"]) && $_POST["up"] != "" &&
        isset($_POST["up2"]) && $_POST["up2"] != "") {
    // code de traitement    
    $dbh = Database::connect();
    $test = htmlspecialchars(Utilisateur::getUtilisateur($dbh, $_POST['login']));
    if ($test == null && $_POST["up"] == $_POST["up2"]) {
        $verif = htmlspecialchars(Utilisateur::insererUtilisateur($dbh, $_POST['login'], $_POST['nom'], $_POST['prenom'], $_POST['up'], $_POST['email'], $_POST['naissance']));

        if ($verif) {
            $form_values_valid = true;
            echo "<meta http-equiv='Refresh' content='1;URL=http://localhost/StreetArtProject2/StreetArtProject/index.php?page=signin'>";
        }
    }
    // si le traitement réussit, on passe $form_value_valid à true

    $dbh = null;
}

if ($form_values_valid) {
    echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="centrage">
                    <br>
                    <h2>Inscription réussie</h2>
                        <p><i>Votre compte a bien été créé !!</i></p><br>
                        <p>Vous pouvez vous identifier maintenant.<p>
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

if (!$form_values_valid) {
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
                    <h2>Inscrivez-vous</h2>
                    <form class="form-inline" action="index.php?page=register" method="post"
                          oninput="up2.setCustomValidity(up2.value != up.value ? 'Les mots de passe diffèrent.' : '')">
                        <p><i>Complétez le formulaire. Les champs marqués par </i><em>*</em> sont <em>obligatoires</em></p><br>

                        <fieldset>
                            <legend>Identifiants de connexion</legend>

                            <label for="login">Login<em>*</em></label>
                            <input type="text" class="form-control" id="login" placeholder="Login" name="login" required><br><br>

                            <label for="password1">Mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up" id="password1" placeholder="Nouveau" required><br><br>

                            <label for="password2">Confirmation mot de passe<em>*</em></label>
                            <input type="password" class="form-control" name="up2" id="password2" placeholder="Confirmer" required><br>            
                        </fieldset>

                        <fieldset>
                            <legend>Contact</legend>

                            <label for="nom">Nom<em>*</em></label>
                            <input id="nom" class="form-control" type="text" placeholder="Nom" required name="nom"><br><br>

                            <label for="prenom">Prenom<em>*</em></label>
                            <input id="prenom" class="form-control" type="text" placeholder="Prenom" required name="prenom" ><br><br>

                            <label for="email">Email<em>*</em></label>
                            <input id="email" class="form-control" placeholder="Email" type="email" required name="email"><br><br>

                            <label for="naissance">Date de naissance<em>*</em></label>
                            <input id="naissance" class="form-control" type="date" required name="naissance"><br><br>
                        </fieldset>

                        <p><button type="submit" class="btn btn-default">Bienvenue</button></p>

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
