<?php

    // upload image files to uploads folder
    $target_dir = "uploads/"; // file storage - folder location
    $target_file = $target_dir . basename($_FILES["image"]["name"]); // file path to upload
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file extension type

    // get image ID
    $imgid = $_POST['id'] . "." . $imageFileType;
    $idname = $target_dir . $imgid;

    // valid file extensions
//    $extensions_arr = array("jpg","jpeg","png","gif");

    // check file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $uploadOk = 1;
    }else{
        echo "File is not an image. Please select a different file.";
        $uploadOk = 0;
    }

    // if image with the same file name already exists in database and field is not empty**
//    if(file_exists($target_file)) {
//        echo "A file with this name already exists. Please specify another file name.";
//        $uploadOk = 0;
//    }

    // if the file size is over 500KB
    if($_FILES["image"]["size"] > 500000){
        echo "Your file is too large. Please choose a smaller file.";
        $uploadOk = 0;
    }

    // if image does not match the following formats and is not empty**
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"){
        echo "Only JPG, JPEG, PNG and GIF files are accepted. Please choose another file type.";
        $uploadOk = 0;
    }

    // check if $uploadOk is set to 0 by an error and field is not empty**
    if($uploadOk == 0){
        echo "Something went wrong. Your file was not uploaded.";
        
    // if everything is ok, try to upload file
    }else{
        if(file_exists($idname)){
            
				// "unlink" (delete) existing image file
                if(!unlink($idname)){
					echo "File could not be deleted.";
                }
            }
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $idname)){
    //    echo basename( $_FILES["image"]["name"]). " was successfully uploaded.";
        }else{
        echo "Something went wrong. There was an error uploading your file.";
        }
    }
    
    // update confirmation
    echo "<p class='alert'>Changes saved successfully.</p>";

?>