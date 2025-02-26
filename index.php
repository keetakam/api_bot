<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตรวจสอบใบอนุญาต - BOT API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">ตรวจสอบใบอนุญาต - ธนาคารแห่งประเทศไทย</h2>

        <div class="mb-3 d-flex">
            <input type="text" id="filterType" class="form-control w-50 me-2" placeholder="ค้นหา">
            <button id="fetchData" class="btn btn-primary">ดึงข้อมูล</button>
            <button id="clearSearch" class="btn btn-secondary ms-2">ล้างข้อมูล</button>
        </div>

        <div class="mt-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อหน่วยงาน</th>
                        <th>ประเภท</th>
                        <th>ที่อยู่</th>
                        <th>โทรศัพท์</th>
                        <th>เงินฝาก</th>
                        <th>เงินกู้</th>
                        <th>รายละเอียด</th>
                    </tr>
                </thead>
                <tbody id="resultTable">
                    <tr><td colspan="8" class="text-center">ไม่มีข้อมูล</td></tr>
                </tbody>
            </table>
        </div>
<!-- Modal -->
<div class="modal fade" id="moreInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📌 รายละเอียดเพิ่มเติม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>📛 ชื่อใบอนุญาติ:</strong> <span id="modalName"></span></p>
                    <p><strong>📅 วันที่เริ่มดำเนินการ:</strong> <span id="modalStartDate"></span></p>
                    <p><strong>✅ สถานะ:</strong> <span id="modalStatusName"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
      


        <div class="d-flex justify-content-between">
            <button id="prevPage" class="btn btn-secondary" disabled>ก่อนหน้า</button>
            <span id="pageInfo" class="align-self-center">หน้า 1</span>
            <button id="nextPage" class="btn btn-secondary">ถัดไป</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPage = 1;
        const recordsPerPage = 10;
        let totalRecords = 0;
        let allData = [];

        // ✅ ฟังก์ชันเคลียร์การค้นหา
        function clearSearch() {
            document.getElementById("filterType").value = "";
            allData = [];
            currentPage = 1;
            document.getElementById('resultTable').innerHTML = '<tr><td colspan="8" class="text-center">ไม่มีข้อมูล</td></tr>';
            document.getElementById('pageInfo').textContent = `หน้า 1`;
            document.getElementById('prevPage').disabled = true;
            document.getElementById('nextPage').disabled = true;
        }
        function renderMore1(_data) {
            console.log("เรียกฟังก์ชั่น renderMore1")
            console.log(_data);
            console.log(_data[0]);
            console.log(_data[0].Name);
            console.log(_data[0].StartDate);
            console.log(_data[0].StatusName);
        }

        function renderMore2(_data) {
            console.log("📌 เรียกฟังก์ชั่น renderMore2");
            console.log(_data);

            // ดึงค่าจาก JSON
            document.getElementById("modalName").innerText = _data[0].Name;
            document.getElementById("modalStartDate").innerText = _data[0].StartDate;
            document.getElementById("modalStatusName").innerText = _data[0].StatusName;

            // แสดง Modal
            let modal = new bootstrap.Modal(document.getElementById('moreInfoModal'));
            modal.show();
        }
        
        // ฟังก์ชั่น render moredetail
        function renderMore(x1, xx){

            alert(`📌 รายละเอียดใบอนุญาติ\n\n🏢 
                        จำนวนใบอนุญาติ: ${x1}
                        รายละเอียด: ${xx}
                        `);

        }
        //✅ ฟังก์ชันดึงข้อมูลจาก AuthorizeDetail
        async function fetchData2(_id) {
            const apiUrl = 'https://apigw1.bot.or.th/bot/public/BotLicenseCheckAPI/AuthorizedDetail';
            const clientId = 'dd007760-8e36-452f-a77f-4b7ad1d67075';
            const clientSecret = 'N3nM7kY7oP5tJ7nW1fM7vB8iC2fA8oV4mG8cF6pU0uK3bD3qS0';
            const id = _id;
                
            console.log ('id',id);
            let url = apiUrl+`?id=`+id;

                console.log (url);
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
                const allData1 = data.LicenseInformations;

                console.log('ใบอนุญาติ', data.LicenseInformations.length);
                console.log('data AuthorizationInfo', data.AuthorizationInfo);
                console.log('data LicenseInformations', data.LicenseInformations);
                console.log('data LicenseInformationsid', data.LicenseInformations[0].Id);
                console.log('data LicenseInformationsid', data.LicenseInformations[0].PermitDate);


                // console.log('data LicenseInformationsx' ${allData1});


                console.log('alldata1 LicenseInformations', allData1);




                if (data.LicenseInformations) {
                    allData = data.LicenseInformations;
                    totalRecords = allData.length;

                let records = {};
                  allData.forEach((record, index) => {records[`record${index + 1}`] = record;});

// ตัวอย่างการเข้าถึงค่า เร็วกกว่ากรณี record เกิน 100000
// for (let key in records) {
//     console.log(`${key}:`, records[key]);
// }

//อ่านง่านกกว่า มั้ง^^
Object.values(records).forEach((value, index) => {
    console.log(`Record ${index + 1}:`, value);
    // renderMore1(value,index);
});


                
                    // for (let i = 0; i < totalRecords; i++) {
                    //      let record = allData[i];
                    //      console.log(`ใบอนุญาติที`+`record${i + 1}:`, record);
                    //     }

                        
                        // _record1 = allData[0];
                        // console.log(_record1);
                    // console.log(allData);
                    // renderMore(totalRecords, allData);           
                } else {
                    throw new Error("ไม่มีข้อมูลจาก API");
                }
            } catch (error) {
                console.error(error);
                document.getElementById('resultTable').innerHTML = `<tr><td colspan="8" class="text-center text-danger">เกิดข้อผิดพลาด: ${error.message}</td></tr>`;
            }

            console.log("end functionfectchdata2");
            renderMore2(allData);
        }
            
        

        // ✅ ฟังก์ชันดึงข้อมูลจาก APIAuthored
        async function fetchData() {
            const apiUrl = 'https://apigw1.bot.or.th/bot/public/BotLicenseCheckAPI/SearchAuthorized';
            const clientId = 'dd007760-8e36-452f-a77f-4b7ad1d67075';
            const clientSecret = 'N3nM7kY7oP5tJ7nW1fM7vB8iC2fA8oV4mG8cF6pU0uK3bD3qS0';
            const filterType = document.getElementById('filterType').value.trim();

           
            const limit = 4500; // ปรับจำนวนข้อมูลต่อครั้งได้

            // let url = `${apiUrl}?limit=${limit}`;
            let url = apiUrl+`?limit=`+limit;

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
                    currentPage = 1;
                    renderTable();
                } else {
                    throw new Error("ไม่มีข้อมูลจาก API");
                }
            } catch (error) {
                console.error(error);
                document.getElementById('resultTable').innerHTML = `<tr><td colspan="8" class="text-center text-danger">เกิดข้อผิดพลาด: ${error.message}</td></tr>`;
            }
        }

        // // ฟังก์ชั่น render moredetail
        // function renderMore(xx){

        //     alert(`📌 รายละเอียดหน่วยงาน\n\n🏢 bbb: ${id}`);

        // }



        // ✅ ฟังก์ชันแสดงผลข้อมูลในตาราง
        function renderTable() {
            const resultTable = document.getElementById('resultTable');
            resultTable.innerHTML = '';

            const startIndex = (currentPage - 1) * recordsPerPage;
            const endIndex = startIndex + recordsPerPage;
            const paginatedData = allData.slice(startIndex, endIndex);

            if (paginatedData.length > 0) {
                paginatedData.forEach((item, index) => {
                    const row = `<tr>
                        <td>${startIndex + index + 1}</td>
                        <td>${item.AuthorizedName}</td>
                        <td>${item.TypeName}</td>
                        <td>${item.Address || '-'}</td>
                        <td>${item.Telephone || '-'}</td>
                        <td>${item.DepositFlag === 'T' ? '✔' : '✘'}</td>
                        <td>${item.LoanFlag === 'T' ? '✔' : '✘'}</td>
                        <td><button class="btn btn-info btn-sm" onclick="showDetails('${item.Id}','${item.AuthorizedName}', '${item.TypeName}', '${item.Address}', '${item.Telephone}')">เพิ่มเติม</button></td>
                        <td><button class="btn btn-info btn-sm" onclick="fetchData2('${item.Id}')">เพิ่มเติม2</button></td>
                    </tr>`;
                    resultTable.innerHTML += row;
                });
            } else {
                resultTable.innerHTML = '<tr><td colspan="8" class="text-center">ไม่มีข้อมูล</td></tr>';
            }

            document.getElementById('pageInfo').textContent = `หน้า ${currentPage}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = endIndex >= totalRecords;
        }

       
         // ✅ ฟังก์ชันแสดงรายละเอียด
         function showDetails2(id, name, type, address, phone) {
            alert(`📌 รายละเอียดหน่วยงาน\n\n🏢 bbb: ${id}\n ชื่อ: ${name}\n📂 ประเภท: ${type}\n📍 ที่อยู่: ${address || '-'}\n📞 โทรศัพท์: ${phone || '-'}`);
        }


        // ✅ ฟังก์ชันแสดงรายละเอียด
        function showDetails(id, name, type, address, phone) {
            alert(`📌 รายละเอียดหน่วยงาน\n\n🏢 bbb: ${id}\n ชื่อ: ${name}\n📂 ประเภท: ${type}\n📍 ที่อยู่: ${address || '-'}\n📞 โทรศัพท์: ${phone || '-'}`);
        }
         // ✅ ฟังก์ชันแสดงรายละเอียด
        function showDetails(id, name, type, address, phone) {
            alert(`📌 รายละเอียดหน่วยงาน\n\n🏢 bbb: ${id}\n ชื่อ: ${name}\n📂 ประเภท: ${type}\n📍 ที่อยู่: ${address || '-'}\n📞 โทรศัพท์: ${phone || '-'}`);
        }
        // ✅ Event Listeners
        document.getElementById('fetchData').addEventListener('click', fetchData);
        document.getElementById('clearSearch').addEventListener('click', clearSearch);
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
