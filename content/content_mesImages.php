<style>
    p {
        margin-top: 0px;
    }

    .centrage{
        text-align: center;
        background-color: white;
    }

    body{
        background-image: url('images/fondecranmotif.jpeg')
    }
</style>

<?php
$utilisateur = htmlspecialchars($_SESSION['login']);
global $pageTitle;
if ($pageTitle == "Mes images") {
    if ($_SESSION['admin'] == false) {
        $resultat = Image::getImageUtilisateur2($dbh, $utilisateur);
        //var_dump($resultat);
        if ($resultat!=null) {
            //var_dump($resultat);
            echo '<div id="gallery1" style="margin:0px auto; display:none;">';
            foreach ($resultat as $res_aux) {
                //var_dump($res_aux);
                $name = $res_aux["nom"];
                $id = $res_aux["id"];
                //print_r($id);
                echo <<<CHAINE_DE_FIN
                    <a href="http://localhost/StreetArtProject2/StreetArtProject/index.php?page=description&todo=$name&iD=$id">
                        <img alt="$name"
                            src="images/$name.jpg"
                            data-image="images/$name.jpg"
                            data-description="This is $name"
                        >
                    </a>
CHAINE_DE_FIN;
            }
            echo <<<CHAINE_DE_FIN
                </div>
                <br><br><br>
                
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery("#gallery1").unitegallery({
                            tile_show_link_icon: true,
                            tile_link_newpage: false,
                            tiles_min_columns: 1,
                            tiles_max_columns: 3
                        });
                    });
                </script>
CHAINE_DE_FIN;
        } else {
            echo <<<CHAINE_DE_FIN
<div class="fondecran">
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="centrage">
                    <br>
                    <h2>Aucune image à afficher</h2>
                        <h3>Désolé, vous n'avez aucune image</h3>
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
    }
    if ($_SESSION['admin'] == true) {
        $resultat = htmlspecialchars(Image::getAllImages2($dbh));
        //var_dump($resultat);
        echo '<div id="gallery1" style="margin:0px auto; display:none;">';
        foreach ($resultat as $res_aux) {
            //var_dump($res_aux);
            $name = $res_aux["nom"];
            $id = $res_aux["id"];
            //print_r($id);
            echo <<<CHAINE_DE_FIN
                    <a href="http://localhost/StreetArtProject2/StreetArtProject/index.php?page=description&todo=$name&iD=$id">
                        <img alt="$name"
                            src="images/$name.jpg"
                            data-image="images/$name.jpg"
                            data-description="This is $name"
                        >
                    </a>
CHAINE_DE_FIN;
        }
        echo <<<CHAINE_DE_FIN
                </div>
                <br><br><br>
            
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                        jQuery("#gallery1").unitegallery({
                            tile_show_link_icon: true,
                            tile_link_newpage: false,
                            tiles_min_columns: 1,
                            tiles_max_columns: 3
                        });
                    });
                </script>
CHAINE_DE_FIN;
    }
}


