<?php

// if file upload field is EMPTY, make $uploadOk = 1 to show success message of record addition
if(empty($_FILES["image"]["name"])){
    $uploadOk = 1;
}

// if user has uploaded file, proceed with file upload check
if(!empty($_FILES["image"]["name"])){

    // upload image files to uploads folder
    $target_dir = "uploads/"; // file storage - folder location
    $target_file = $target_dir . basename($_FILES["image"]["name"]); // file path to upload
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); // file extension type

    // get image ID
    // rename file as imgid.filetype
    $imgid = $_POST['id'] . "." . $imageFileType;
    $idname = $target_dir . $imgid;

    // check file is an image
    $check = getimagesize($_FILES["image"]["tmp_name"]);

    if($check !== false){
        $uploadOk = 1;
    }else{
        $upload_err = 
        "<p class='error'>
            <b>File is not an image.</b> 
            Please select a different file.
        </p>";
        $uploadOk = 0;
    }

    // if the file size is over 500KB
    if($_FILES["image"]["size"] > 500000){
        $upload_err = 
        "<p class='error'>
            <b>Your file is too large.</b> 
            Please choose a a file smaller than 500KB.
        </p>";
        $uploadOk = 0;
    }

    // if image does not match the following formats
    if($imageFileType != "jpg" && 
       $imageFileType != "png" && 
       $imageFileType != "jpeg" && 
       $imageFileType != "gif"){
        $upload_err = 
        "<p class='error'>
            <b>Only JPG, JPEG, PNG and GIF files are accepted.</b> 
            Please choose another file type.
        </p>";
        $uploadOk = 0;
    }

    // check if $uploadOk is set to 0 by an error
    if($uploadOk == 0){
        echo 
        "<p class='error'>
            <b>Something went wrong.</b> 
            Your file was not uploaded.
        </p>" . $upload_err;

    // if everything is ok, try to upload file
    }else{
        if(file_exists($idname)){

            // "unlink" (delete) existing file image
            if(!unlink($idname)){ ?>
                <p class='error'><b>File could not be deleted.</b></p>
            <?php
            }
        }
        if(move_uploaded_file($_FILES["image"]["tmp_name"], $idname)){
            // file has uploaded
        }else{
            echo 
            "<p class='error'>
                <b>Something went wrong.</b> 
                There was an error uploading your file.
            </p>";
        }
    }
}

?>