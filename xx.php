<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบใบอนุญาต - BOT API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
      <!-- Bootstrap JS (สำหรับปุ่ม Bootstrap) -->
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">ตรวจสอบใบอนุญาต - ธนาคารแห่งประเทศไทย</h2>

        <!-- Filter for search -->

        <input type="text" id="filterType" placeholder="ค้นหา">
        <button id="fetchData" class="btn btn-primary">ดึงข้อมูลทั้งหมด</button>
        <button onclick="clearSearch()" class="btn btn-secondary">ล้างข้อมูล</button>

        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ID</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>ประเภท</th>
                        <th>ที่อยู่</th>
                        <th>โทรศัพท์</th>
                        <th>เงินฝาก</th>
                        <th>เงินกู้</th>
                        <th>detail</th>
                    </tr>
                </thead>
                <tbody id="resultTable">
                    <tr><td colspan="7" class="text-center">ไม่มีข้อมูล</td></tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between">
            <button id="prevPage" class="btn btn-secondary" disabled>ก่อนหน้า</button>
            <span id="pageInfo" class="align-self-center">หน้า 1</span>
            <button id="nextPage" class="btn btn-secondary">ถัดไป</button>
        </div>
    </div>

    
    <div id="details" class="alert alert-info mt-3 d-none">
    <p>นี่คือรายละเอียดเพิ่มเติมที่จะแสดงเมื่อกดปุ่ม "More" คุณสามารถซ่อนหรือแสดงเนื้อหานี้ได้ตามต้องการ!</p>
</div>
    <script>
        let currentPage = 1;
        const recordsPerPage = 15;
        let totalRecords = 0;
        let allData = [];

        // ฟังก์ชันสำหรับล้างการค้นหา
        function clearSearch() {
            document.getElementById("filterType").value = "";
            fetchData(); // เรียกฟังก์ชัน fetchData ใหม่
        }

        // ฟังก์ชันดึงข้อมูลทั้งหมดจาก API
        async function fetchData() {
            const apiUrl = 'https://apigw1.bot.or.th/bot/public/BotLicenseCheckAPI/SearchAuthorized';
            const clientId = 'dd007760-8e36-452f-a77f-4b7ad1d67075';  // ใส่ API Key ของคุณที่นี่
            const clientSecret = 'N3nM7kY7oP5tJ7nW1fM7vB8iC2fA8oV4mG8cF6pU0uK3bD3qS0';
            const filterType = document.getElementById('filterType').value;

            const limit = 4450; // ปรับจำนวนข้อมูลต่อครั้งได้

            let url = `${apiUrl}?limit=${limit}`;
            if (filterType && filterType !== 'all') {
                url += `&keyword=${encodeURIComponent(filterType)}`;
            }

            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-IBM-Client-Id': clientId,
                        'X-IBM-Client-Secret': clientSecret,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`เกิดข้อผิดพลาดจาก API (สถานะ: ${response.status})`);
                }

                const data = await response.json();
                if (data.ResultSet) {
                    allData = data.ResultSet;
                    totalRecords = allData.length;
                    renderTable(); // เรียกฟังก์ชัน renderTable เพื่อแสดงข้อมูลทั้งหมด
                } else {
                    throw new Error("ไม่มีข้อมูลจาก API");
                }
            } catch (error) {
                console.error(error);
                document.getElementById('resultTable').innerHTML = '<tr><td colspan="7" class="text-center text-danger">เกิดข้อผิดพลาด: ' + error.message + '</td></tr>';
            }
        }

        // ฟังก์ชันสำหรับแสดงผลข้อมูลในตาราง
        function renderTable() {
            const resultTable = document.getElementById('resultTable');
            resultTable.innerHTML = '';
            
            //เรียง
            allData.sort((a,b) => a.Id- b.Id);

            const startIndex = (currentPage - 1) * recordsPerPage;  // คำนวณลำดับเริ่มต้น
            const endIndex = startIndex + recordsPerPage;  // คำนวณลำดับสุดท้ายที่แสดงในหน้าปัจจุบัน

            const paginatedData = allData.slice(startIndex, endIndex); // slice ข้อมูลตามที่ต้องการแสดง

            if (paginatedData.length > 0) {
                paginatedData.forEach((item, index) => {
                    const row = `<tr>
                        <td>${startIndex + index + 1}</td>  <!-- แสดงลำดับ -->
                         <td>${item.Id}</td>  <!-- แสดงID -->

                        <td>${item.AuthorizedName}</td>
                        <td>${item.TypeName}</td>
                        <td>${item.Address || '-'}</td>
                        <td>${item.Telephone || '-'}</td>
                        <td>${item.DepositFlag === 'T' ? '✔' : '✘'}</td>
                        <td>${item.LoanFlag === 'T' ? '✔' : '✘'}</td>
                        <td><button  onclick="toggleDetails()">More</button></td>
                        <td><button class="btn btn-info" onclick="showDetails('${item.AuthorizedName}', '${item.TypeName}', '${item.Address}', '${item.Telephone}')">more</button></td>
                    </tr>`;
                    resultTable.innerHTML += row;
                });
            } else {
                resultTable.innerHTML = '<tr><td colspan="7" class="text-center">ไม่มีข้อมูล</td></tr>';
            }

            document.getElementById('pageInfo').textContent = `หน้า ${currentPage}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = endIndex >= totalRecords;
        }


        // ฟังก์ชันสำหรับโหลดข้อมูลเมื่อคลิกปุ่ม "ดึงข้อมูลทั้งหมด"
        document.getElementById('fetchData').addEventListener('click', fetchData);
        

         // ✅ ฟังก์ชันแสดงรายละเอียด(alert)
         function showDetails(name, type, address, phone) {
            alert(`📌 รายละเอียดหน่วยงาน\n\n🏢 ชื่อ: ${name}\n📂 ประเภท: ${type}\n📍 ที่อยู่: ${address || '-'}\n📞 โทรศัพท์: ${phone || '-'}`);
        }
        // ✅ ฟังก์ชันแสดงรายละเอียด(ใช้ overlayใส่  table)
        function toggleDetails() {
            var details = document.getElementById("details");
            details.classList.toggle("d-none"); // ใช้ Bootstrap class `d-none` แทน `display: none`
        }
        
        // ฟังก์ชันสำหรับเปลี่ยนหน้า
        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) { 
                currentPage--;
                renderTable();
            }
        });
        document.getElementById('nextPage').addEventListener('click', () => {
            if ((currentPage * recordsPerPage) < totalRecords) {
                currentPage++;
                renderTable();
            }
        });
    </script>
</body>
</html>
