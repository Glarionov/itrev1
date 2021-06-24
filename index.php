<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="content">
    <form action="index.php" class="main-form" method="post" enctype="multipart/form-data">
        Upload textfile:<hr>
        <input type="file" name="fileToUpload" id="fileToUpload"><br>
        <input type="submit" value="Upload Image" name="submit">
    </form>


<?php
    if (isset($_POST["submit"]) && isset($_FILES["fileToUpload"])) {
        $error = false;
        if (empty($_FILES["fileToUpload"]['size'])) {
            $error = true;
        } else {
            $target_dir = "./files/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            $fileName = $target_dir . time(). '.txt';

            $content = file_get_contents($_FILES['fileToUpload']['tmp_name']);

            if (file_put_contents($fileName, $content) === false) {
                $error = true;
            } else {
                $separator = "\n";

                if (!empty($_POST['separator'])) {
                    $separator = $_POST['separator'];
                }

                $exploded = explode($separator, $content);

                $numAmounts = [];

                echo '<div class="green circle"></div>';
                echo "Amount of digits by separator:<hr>";
                foreach ($exploded as $lineNum => $line) {
                    $matched = preg_match_all( "/[0-9]/", $line );
                    $lineNumPlusOne = $lineNum + 1;
                    $numAmounts[$lineNumPlusOne] = $matched;

                    echo "$lineNumPlusOne: $matched<br>";
                }
            }
        }

        if ($error) {
            echo '<div class="red circle"></div>';
        }

    }
?>
</div>


</body>
</html>