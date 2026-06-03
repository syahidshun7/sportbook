<!DOCTYPE html>
<html>
<head>
 <title>Form POST</title>
</head>
<body>
 <form action="process.php" method="POST">
 <label for="name">Nama:</label>
 <input type="text" id="name" name="name" required><br><br>
 <label>Jenis Kelamin:</label>
 <input type="radio" name="gender" value="Laki-laki"> Laki-laki
 <input type="radio" name="gender" value="Perempuan"> Perempuan <br><br>
 <label>Hobi:</label>
 <input type="checkbox" name="hobby[]" value="Membaca"> Membaca
 <input type="checkbox" name="hobby[]" value="Olahraga"> Olahraga
 <input type="checkbox" name="hobby[]" value="Musik"> Musik <br><br>
 <textarea name="deskripsi" id=""></textarea><br><br>
 <label for="dropdown">Pilih:</label>
 <select name="dropdown" id="dropdown">
 <option value="option1">Opsi 1</option>
 <option value="option2">Opsi 2</option>
 <option value="option3">Opsi 3</option>
 </select><br><br>
 <button type="submit">Kirim</button>
 </form>
</body>
</html>
