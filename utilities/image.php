<?php

class Image {

    public $id;
    public $utilisateur;
    public $nom;
    public $lat;
    public $lng;
    public $description;

    public static function insererImage($dbh, $utilisateur, $nom, $lat, $lng, $description) {
        $sth = $dbh->prepare("INSERT INTO `images` (`utilisateur`, `nom`, `lat`, `lng`,`description`) VALUES(?,?,?,?,?)");
        $sth->execute(array($utilisateur, htmlspecialchars($nom), $lat, $lng, $description));
        $id_nouveau = $dbh->lastInsertId();
        if ($sth->rowCount() > 0) {
            return $id_nouveau;
        } else {
            return null;
        }
    }

    public static function getImageId($dbh, $id) {
        $query = "SELECT * FROM `images` WHERE `id`=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Image');
        $sth->execute(array($id));
        $picture = $sth->fetch();

        if ($sth->rowCount() > 0) {
            return $picture;
        } else {
            return null;
        }
    }

    public static function supprimer($dbh, $id) {
        $query = "DELETE FROM `images` WHERE `id`=?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id));
        if ($sth->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function estAUtilisateur($dbh, $utilisateur, $id) {
        $query = "SELECT * FROM `images` WHERE `id`=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Image');
        $sth->execute(array($id));
        $picture = $sth->fetch();

        if ($sth->rowCount() > 0) {
            $verif = $picture->utilisateur;
            if ($verif == $utilisateur) {
                return true;
            } else {
                return false;
            }
        } else {
            return null;
        }
    }

    public static function getLastID($dbh) {
        $query = "SELECT * FROM `images` WHERE `nom`=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Image');
        $sth->execute(array($nom));
        $picture = $sth->fetch();

        if ($sth->rowCount() > 0) {
            return $picture;
        } else {
            return null;
        }
    }

    public static function getId($dbh, $nom) {
        $query = "SELECT * FROM `images` WHERE `nom`=?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Image');
        $sth->execute(array($nom));
        $picture = $sth->fetch();

        if ($sth->rowCount() > 0) {
            return $picture;
        } else {
            return null;
        }
    }

    public static function getAllImages($dbh) {
        $reponse = "SELECT * FROM `images`";
        $sth = $dbh->prepare($reponse);
        $sth->execute();
        while ($donnees = $sth->fetch()) {
            $nomPhoto = $donnees['nom'] . $donnees['id'];
            $array[] = $nomPhoto;
        }
        if (isset($array)) {
            return $array;
        }
    }

    public static function getAllImages2($dbh) {
        $reponse = "SELECT * FROM `images`";
        $sth = $dbh->prepare($reponse);
        $sth->execute();
        while ($donnees = $sth->fetch()) {
            $nomPhoto = $donnees['utilisateur'] . $donnees['id'];
            $idPhoto = $donnees['id'];
            $res_aux = array(
                "nom" => $nomPhoto,
                "id" => $idPhoto
            );
            $res[] = $res_aux;
        }
        if (isset($res)) {
            return $res;
        } else {
            return null;
        }
    }

    public static function getImageUtilisateur($dbh, $utilisateur) {
        // On récupère tout le contenu de la table
        $reponse = "SELECT * FROM `images` WHERE `utilisateur`=?";
        $sth = $dbh->prepare($reponse);
        $sth->execute(array($utilisateur));
        $res = array();
        // On affiche chaque entrée une à une
        while ($donnees = $sth->fetch()) {
            $nomPhoto = $donnees['utilisateur'] . $donnees['id'];
            $array[] = $nomPhoto;
        }
        $sth->closeCursor(); // Termine le traitement de la requête
        if (isset($array)) {
            return $array;
        }
    }

    public static function getImageUtilisateur2($dbh, $utilisateur) {
        // On récupère tout le contenu de la table
        $reponse = "SELECT * FROM `images` WHERE `utilisateur`=?";
        $sth = $dbh->prepare($reponse);
        $sth->execute(array($utilisateur));
        $res = array();
        // On affiche chaque entrée une à une
        while ($donnees = $sth->fetch()) {
            $nomPhoto = $donnees['utilisateur'] . $donnees['id'];
            $idPhoto = $donnees['id'];
            $res_aux = array(
                "nom" => $nomPhoto,
                "id" => $idPhoto
            );
            $res[] = $res_aux;
        }
        $sth->closeCursor(); // Termine le traitement de la requête
        if (isset($res)) {
            //var_dump($res);
            return $res;
        }
    }

    public static function hauteurProportionnelle($image, $newLargeur) {
        $id = $image->id;
        $utilisateur = $image->utilisateur;
        $adresse = "images/$utilisateur$id.jpg";
        $source = imagecreatefromjpeg($adresse);
        $largeur = imagesx($source);
        $hauteur = imagesy($source);
        $newhauteur = abs(($newLargeur / $largeur) * $hauteur);
        return $newhauteur;
    }

    public static function createMiniature($name) {
        $source = imagecreatefromjpeg("images/$name.jpg"); // La photo est la source
        // Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = 200;
        $hauteur_destination = abs((200 / $largeur_source) * $hauteur_source);
        $destination = imagecreatetruecolor($largeur_destination, $hauteur_destination); // On crée la miniature vide
        // On crée la miniature
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);

        // On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
        imagejpeg($destination, "miniatures/mini_$name.jpg");

        /* // Le fichier
          $filename = "../image/$name.jpg";

          // Définition de la largeur et de la hauteur maximale
          $width = 200;
          $height = 200;

          // Content type
          //header('Content-Type: image/jpeg');

          // Cacul des nouvelles dimensions
          list($width_orig, $height_orig) = getimagesize($filename);

          $ratio_orig = $width_orig / $height_orig;

          if ($width / $height > $ratio_orig) {
          $width = $height * $ratio_orig;
          } else {
          $height = $width / $ratio_orig;
          }

          // Redimensionnement
          $image_p = imagecreatetruecolor($width, $height);
          $image = imagecreatefromjpeg($filename);
          imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

          // Affichage
          imagejpeg($image_p, "miniatures/mini_$name.jpg", 100); */
    }

}
