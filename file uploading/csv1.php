<!DOCTYPE html>
<html>
<head>
    <title>File Upload and Display</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="uploaded_files[]" multiple>
        <input type="submit" name="submit" value="Upload Files">
    </form>

    <div class="view" id="tableContainer">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>File Name</th>
                    <th>Download</th>
                </tr>
            </thead>
            <tbody id="tableBody"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function()
         {
            $('#uploadForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $.ajax({
                    url: 'csvupload.php', // PHP script to handle uploads
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response)
                     {
                        console.log('Files uploaded successfully.');
                        displayUploadedFiles(JSON.parse(response));
                    },
                    error: function() {
                        console.log('Error uploading files.');
                    }
                });
            });

            function displayUploadedFiles(files) {
                var tableBody = $('#tableBody');
                tableBody.empty();

                $.each(files, function(index, file) {
                    var newRow = $('<tr>');
                    newRow.append('<td>' + file.name + '</td>');
                    newRow.append('<td><a href="' + file.path + '" download>Download</a></td>');
                    tableBody.append(newRow);
                });
            }

          
            $.ajax({
                url: 'downloadcsv.php',
                type: 'GET',
                success: function(response) {
                    displayUploadedFiles(JSON.parse(response));
                },
                error: function() {
                    console.log('Error fetching files.');
                }
            });
        });
    </script>
</body>
</html>

