<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Data Table</title>
    <!-- ลิงค์ไปยัง Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
        }
        #result {
            margin-top: 20px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">API Data Table Example</h1>

        <!-- Input for ID -->
        <div class="mb-3">
            <label for="inputId" class="form-label">Enter ID:</label>
            <input type="text" id="inputId" class="form-control" placeholder="Enter ID to fetch data">
        </div>

        <div class="d-flex justify-content-center mb-3">
            <button id="fetchButton" class="btn btn-primary btn-lg">Fetch Data</button>
        </div>

        <!-- <table class ="table table-bordered">
            <thead>
                <tr>
                    <th>xx</th>
                    <th>xx</th>
                    <th>xx</th>

                </tr>
            </thead>
        </table> -->
        <div id="result" class="mt-4"></div>
    </div>

    <!-- ลิงค์ไปยัง Bootstrap JS และ Popper.js -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF+5xY6Y5jKh6UMtI9D+7m6l7t9zpr6KCwflrF7bGGbo2Q2tn0b" crossorigin="anonymous"></script> -->
    <script>
        document.getElementById("fetchButton").addEventListener("click", fetchData);

        async function fetchData() {
            const id = document.getElementById("inputId").value.trim(); // รับค่า ID จาก input
            if (!id) {
                alert("Please enter a valid ID.");
                return;
            }

            const apiUrl = `https://apigw1.bot.or.th/bot/public/BotLicenseCheckAPI/AuthorizedDetail`; // ใส่ ID ใน URL
            const clientId = 'dd007760-8e36-452f-a77f-4b7ad1d67075';
            const clientSecret = 'N3nM7kY7oP5tJ7nW1fM7vB8iC2fA8oV4mG8cF6pU0uK3bD3qS0';
            const filterType = document.getElementById('id').value;


            let url =`${apiUrl}?id=${'filterType'}`;
            if (id && id)
           
            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-IBM-Client-Id': clientId,
                        'X-IBM-Client-Secret':clientSecret,
                        'Accept':application/json
                    }
                });

                if (!response.ok) {
                    throw new Error(`Error: ${response.status}`);
                }

                const data = await response.json();
                displayTable(data);
            } catch (error) {
                console.error('There was an error!', error);
                document.getElementById('result').textContent = 'An error occurred while fetching data.';
            }
        }
         
        // ฟังก์ชันในการแสดงผลข้อมูลในตาราง
        function displayTable(data) {
            let table = `
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            // สมมุติว่า API ตอบกลับเป็นอาร์เรย์ของข้อมูล
            if (Array.isArray(data)) {
                data.forEach((item, index) => {
                    table += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.column1 || 'N/A'}</td>
                            <td>${item.column2 || 'N/A'}</td>
                            <td>${item.column3 || 'N/A'}</td>
                        </tr>
                    `;
                });
            } else {
                table += `
                    <tr>
                        <td colspan="4">No data available.</td>
                    </tr>
                `;
            }

            table += `
                    </tbody>
                </table>
            `;
            document.getElementById('result').innerHTML = table;
        }
    </script>
</body>
</html>
