<?php
session_start();
include('connect_db.php');
$product_code =  $_SESSION['product_code'];
$target_dir = $_SERVER["DOCUMENT_ROOT"]. "/loket_e-commerce/assets/images/collection/BigDeal_images/602-402/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
echo basename($_FILES["fileToUpload"]["name"]) . "<br>";
echo $_FILES["fileToUpload"]["tmp_name"] . "<br>";
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
$product_image = "..assets/images/collection/BigDeal_images/768-988/".basename($_FILES["fileToUpload"]["name"]);
$sql = "UPDATE admin_product SET product_image = '$product_image' WHERE product_code = '$product_code';";
$result = $conn->query($sql);
if($result->num_rows>0){
  echo'<script>
  alert("Product addedd successfully");
  window.location = "add-product.php;
  </script>';
}
echo $sql;
echo $result;
?>