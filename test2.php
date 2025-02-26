<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงใบอนุญาตจาก JSON</title>
    <style>
        #licenseDetails {
            padding: 15px;
            border: 2px solid #3498db;
            background-color: #f1f1f1;
            border-radius: 8px;
            width: 300px;
            display: none;
        }
    </style>
</head>
<body>

    <button onclick="renderMore('license1')">แสดงข้อมูลใบอนุญาต 1</button>
    <button onclick="renderMore('license2')">แสดงข้อมูลใบอนุญาต 2</button>

    <div id="licenseDetails"></div>

    <script>
        const licenseData = {
            "license1": { "amount": 5, "detail": "ใบอนุญาตธุรกิจร้านอาหาร" },
            "license2": { "amount": 10, "detail": "ใบอนุญาตก่อสร้าง" }
        };

        function renderMore(licenseKey) {
            let data = licenseData[licenseKey];
            if (!data) {
                document.getElementById("licenseDetails").innerHTML = "<p>❌ ไม่พบข้อมูลใบอนุญาต</p>";
                return;
            }
            
            document.getElementById("licenseDetails").innerHTML = `
                <h3>📌 รายละเอียดใบอนุญาต</h3>
                <p>🏢 จำนวนใบอนุญาต: <strong>${data.amount}</strong></p>
                <p>📃 รายละเอียด: ${data.detail}</p>
            `;
            document.getElementById("licenseDetails").style.display = "block";
        }
    </script>

</body>
</html>
