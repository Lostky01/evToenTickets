<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ticket PDF</title>
    <style>
        body { text-align: center; }
        img { width: 100%; }
    </style>
</head>
<body>
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($imagePath)) }}" alt="Ticket Image">


</body>
</html>
