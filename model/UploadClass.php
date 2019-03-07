<?php

    class Upload
    {
        public function ProtectionUpload($libelle) 
        {
        $libelle = $_POST['Libelle_piece'];
        $target_dir = "../public/images/";
        $name = $_FILES["fileToUpload"]["name"];
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); 
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check == false) {
                echo "Le fichier n'est pas une image.";
                $uploadOk = 0;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Le fichier est déja en base de données.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "La taille du fichier est trop grande.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
        {
            echo "Seulement les images aux formats jpg, png et jpeg sont autorisés.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Désolé, votre fichier n'a pas pu être importé.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                rename("../public/images/".$name, "../public/images/".$libelle.".".$imageFileType);
            } else {
                echo "Désolé, votre fichier n'a pas pu être importé.";
            }
        }

    }

}
?>