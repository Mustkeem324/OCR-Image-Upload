<!DOCTYPE html>
<html>
<head>
    <title>OCR Image Upload by NC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-image: url('your-background-image-url.jpg'); /* Replace 'your-background-image-url.jpg' with your image URL */
            background-size: cover;
            background-position: center;
        }
        h1 {
            text-align: center;
            color: #fff;
        }
        form {
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.8); /* Background color with opacity */
            padding: 20px;
            border-radius: 10px;
        }
        label {
            margin-bottom: 20px;
            font-size: 24px; /* Increase font size */
        }
        input[type="file"] {
            padding: 15px;
            border: 2px solid #ccc; /* Increase border size */
            border-radius: 8px;
            font-size: 18px; /* Increase font size */
        }
        input[type="submit"] {
            padding: 12px 20px; /* Increase padding */
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 20px; /* Increase font size */
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .result {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .box {
  border: 2px solid #008080;
  padding: 15px;
  width: 700px;
  height: 500px;
  overflow: auto;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #f4f4f4;
  color: #333;
  font-family: Arial, sans-serif;
}

/* Style for scrollbar */
.box::-webkit-scrollbar {
  width: 8px;
}

.box::-webkit-scrollbar-thumb {
  background-color: #888;
  border-radius: 4px;
}

.box::-webkit-scrollbar-track {
  background-color: #f4f4f4;
}

    </style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>OCR Image Upload by NC</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="image">Select image to upload:</label>
        <input type="file" name="image" id="image">
        <input type="submit" value="Upload Image" name="submit">
    </form>
    <?php
    function OCRtranslate($id_url){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.ocr.space/parse/image',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'language' => 'eng',
                'isOverlayRequired' => 'false',
                'url' => $id_url,
                'iscreatesearchablepdf' => 'false',
                'issearchablepdfhidetextlayer' => 'false'
            ),
            CURLOPT_HTTPHEADER => array(
                'apikey: K84634556088957'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
        if ($data['ParsedResults'][0]['FileParseExitCode'] === 1) {
            $ocrtext = $data['ParsedResults'][0]['ParsedText'];
            return $ocrtext;
        } else {
            return null;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedExtensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                //echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
                echo "OCR successfully Done!";
                $id_url='https://nx.aba.vg/OCR/uploads/'.basename($_FILES["image"]["name"]);
                echo "<div class='result'><br>OCR Result:<br>";
                $ocr_result = OCRtranslate($id_url);
                if ($ocr_result !== null) {
                    $ocrhtml = nl2br($ocr_result);
                    echo '<div class="box"><pre><code>'.$ocrhtml.'</code></pre</div>';//Displaying OCR text with line breaks
                    unlink($target_file);
                } else {
                    echo "OCR failed or no text found.";
                }
                echo "</div>";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    ?>
</body>
</html>
