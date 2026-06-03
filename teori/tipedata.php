
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
 <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
        }
        th {
            background-color: #444;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
<body>

<h2>Tabel Data $_SERVER</h2>
    <table>
    <tbody>
        <tr>
            <td>no</td>
            <td>nama</td>
            <td>nim</td>
        </tr>
     <?php
    $mahasiswa = [
        [
            "nama" => "Rizky",
            "nim" => "123456789",
        ],
        [
            "nama" => "Dewi",
            "nim" => "987654321",
        ],
        [
            "nama" => "Andi",
            "nim" => "456789123",
        ],
        [
            "nama" => "Siti",
            "nim" => "321654987",  
        ],
        [
            "nama" => "Budi",
            "nim" => "654321987",  
        ]   
    ];
        foreach ($mahasiswa as $key => $value) {
        echo "<tr>
                <td>" . ($key + 1) . "</td>
                <td>" . $value['nama'] . "</td>
                <td>" . $value['nim'] . "</td>
              </tr>";
    }
        ?> 
    </table>
</body>
</html>