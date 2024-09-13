<?php
// include("newconnection.php");
// if (isset($_POST['submit']))
//  {
//     $targetDirectory = "uploads/";
//     $targetFile = $targetDirectory . basename($_FILES["uploaded_file"]["name"]);
//     $allowedImage = array("csv");

//     $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

//     if (!in_array($fileExtension, $allowedImage))
//      {
//         echo "Sorry, only CSV file formats are allowed.";
//     } 
//     if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFile)) 
//     {
//         echo "File has been uploaded successfully.";
//         if (($handle = fopen("Book1.csv", "r")) == TRUE)
//         {
//             while (($getData = fgetcsv($handle, 100000, ",")) !== FALSE)
//             {
//                 $name = $getData[0];
//                 $path= $getData[1];
               
//                 $sql="INSERT INTO csvfile (name,path) VALUES('$name', '$path')";
//                 $result=mysqli_query($con, $sql);
//                 if($result)
//                 {
//                     echo "inserted <br>";
//                 }
//             }
//         }
        
//     }

// }
// else
// {
//    echo "Invalid file.";
// }

// if(isset($_POST["Export"])) -->
// {
//     $query = "SELECT * from csvfile";
//     $result = mysqli_query($con, $query);
    
//     $exportFilePath = "exported_data.csv";
//     $exportFile = fopen($exportFilePath, "a+");
//     $header = array("name", "lasttname", "Phoneno");
//     fputcsv($exportFile, $header);
    
//     while ($row = mysqli_fetch_assoc($result)) 
//     {
      
//         $rowData = implode(",", $row);
//         $explodedData = explode(",", $rowData);
//         fputcsv($exportFile, $explodedData);
//     }
//     echo "Data has been exported";
//      // Display link to download the exported file
//      echo "<a href='$exportFilePath' download>Click here to download file</a>";
    
// }  

// if(isset($_POST["download"]))
// {
//     header('Content-Type: text/csv; charset=utf-8');  
//     header('Content-Disposition:  inline; filename=data.csv');  
//     $output = fopen("php://output", "w");  // Open for writing

//     fputcsv($output, array('name', 'last name', 'phoneno'));  

//     $query = "SELECT * from csvfile";  
//     $result = mysqli_query($con, $query);  

//     while($row = mysqli_fetch_assoc($result)) 
//     {  
//         $csvData = implode(",",$row);
//         $data = explode(',',$csvData);
//         $name = $data[0];
//         $lastname = $data[1];
//         $phoneno = $data[2];
//         fputcsv($output,$data);  
//     }  

//     fclose($output);  
// }  
?>


<?php
include("newconnection.php");

$targetDirectory = "uploads/";
$allowedExtensions = array("csv");

$response = array();

foreach ($_FILES["uploaded_files"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $fileName = basename($_FILES["uploaded_files"]["name"][$key]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $targetFile = $targetDirectory . $fileName;
            if (move_uploaded_file($_FILES["uploaded_files"]["tmp_name"][$key], $targetFile)) {
                $response[] = array("name" => $fileName, "path" => $targetFile);

              
                $insertQuery = "INSERT INTO csv (name, path) VALUES ('$fileName', '$targetFile')";
                mysqli_query($con, $insertQuery);
            }
        }
    }
}

echo json_encode($response);
?>
