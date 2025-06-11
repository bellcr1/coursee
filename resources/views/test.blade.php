<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test PDF</title>
</head>
<body>

    <div id="certificate">
        <h1>شهادة نجاح</h1>
        <p>الاسم: Jihed</p>
    </div>

    <button id="pdf-button">Télécharger PDF</button>

    <!-- سكربت html2pdf -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>

    <!-- سكربت الزر -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("pdf-button").addEventListener("click", function () {
                const element = document.getElementById("certificate");
                html2pdf().from(element).save();
            });
        });
    </script>

</body>
</html>
