<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อัปโหลดและเข้ารหัสไฟล์ TXT</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <style>
        #fileContent {
            white-space: pre-wrap;
            border: 1px solid #3498db;
            padding: 10px;
            background-color: #f1f1f1;
            border-radius: 5px;
            max-width: 600px;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>

    <h2>📂 อัปโหลดไฟล์ .txt และกด Submit</h2>
    <input type="file" id="fileInput" accept=".txt">
    <button id="submitBtn" disabled>Submit</button>

    <h3>🔒 ข้อความที่เข้ารหัส:</h3>
    <textarea id="encryptedText" rows="4" cols="50" readonly></textarea>

    <h3>🔓 ข้อความที่ถอดรหัส:</h3>
    <div id="fileContent">📄 เนื้อหาของไฟล์จะแสดงที่นี่...</div>

    <script>
        let encryptedData = ""; // ตัวแปรเก็บข้อความที่เข้ารหัส
        const secretKey = "mySecretKey123"; // กำหนด Key ใช้เข้ารหัส/ถอดรหัส

        document.getElementById("fileInput").addEventListener("change", function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const textData = e.target.result; // ข้อมูลที่อ่านจากไฟล์

                    // 🔒 เข้ารหัสข้อความด้วย AES
                    encryptedData = CryptoJS.AES.encrypt(textData, secretKey).toString();

                    document.getElementById("encryptedText").value = encryptedData; // แสดงข้อความที่เข้ารหัส
                    document.getElementById("submitBtn").disabled = false; // เปิดปุ่ม Submit
                };
                reader.readAsText(file);
            }
        });

        document.getElementById("submitBtn").addEventListener("click", function() {
            if (encryptedData) {
                // 🔓 ถอดรหัสข้อความ AES
                const decryptedData = CryptoJS.AES.decrypt(encryptedData, secretKey).toString(CryptoJS.enc.Utf8);

                document.getElementById("fileContent").textContent = decryptedData; // แสดงผลข้อความที่ถอดรหัส
                document.getElementById("fileContent").style.display = "block"; // แสดงเนื้อหา
            }
        });
    </script>
</body>
</html>
