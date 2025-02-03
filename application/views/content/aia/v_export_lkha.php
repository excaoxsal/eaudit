<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print PDF Example</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body>
    <!-- Konten halaman yang ingin dicetak -->
    <div id="content">
        <h1>Judul Halaman</h1>
        <p>Ini adalah contoh konten halaman yang akan dicetak menjadi PDF.</p>
    </div>

    <!-- Tombol untuk memulai pencetakan PDF -->
    <button id="printButton">Print to PDF</button>

    <script>
        // Fungsi untuk mencetak halaman menjadi PDF
        document.getElementById('printButton').addEventListener('click', function() {
            var element = document.getElementById('content');
            html2pdf().from(element).save();
        });
    </script>
</body>
</html>
