<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Details as overlay</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <h2 class="text-center mb-4">ตารางแสดงข้อมูลพร้อมปุ่ม More</h2>

    <div class="container">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>ชื่อ</th>
                    <th>อายุ</th>
                    <th>เพิ่มเติม</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>สมชาย</td>
                    <td>30</td>
                    <td>
                    <button class="btn btn-primary btn-sm" onclick="toggleDetails()">More</button>

                        <button class="btn btn-primary btn-sm" onclick="showDetails('สมชาย', 'นักพัฒนาเว็บที่มีประสบการณ์ใน HTML, CSS, และ JavaScript')">More</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>สมหญิง</td>
                    <td>25</td>
                    <td>
                    <button class="btn btn-primary btn-sm" onclick="showDetails()">More</button>

                        <button class="btn btn-primary btn-sm" onclick="showDetails('สมหญิง', 'นักออกแบบ UI/UX ที่เชี่ยวชาญใน Figma และ Adobe XD')">More</button>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>ก้อง</td>
                    <td>35</td>
                    <td>
                    <button class="btn btn-primary btn-sm" onclick="showDetails()">More</button>

                        <button class="btn btn-primary btn-sm" onclick="showDetails('ก้อง', 'วิศวกรซอฟต์แวร์ที่ทำงานด้าน AI และ Machine Learning')">More</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="details" class="alert alert-info mt-3 d-none">
    <p>นี่คือรายละเอียดเพิ่มเติมที่จะแสดงเมื่อกดปุ่ม "More" คุณสามารถซ่อนหรือแสดงเนื้อหานี้ได้ตามต้องการ!</p>
</div>


    <!-- Bootstrap Modal (Overlay) -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">รายละเอียด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 id="modalTitle"></h4>
                    <p id="modalDetails"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




    <script>

         // ✅ ฟังก์ชันแสดงรายละเอียด(ใช้ overlayใส่  table)
         function toggleDetails() {
            var details = document.getElementById("details");
            details.classList.toggle("d-none"); // ใช้ Bootstrap class `d-none` แทน `display: none`
        }
        

        function showDetails(name, details) {
            document.getElementById("modalTitle").textContent = name;
            document.getElementById("modalDetails").textContent = details;
            var myModal = new bootstrap.Modal(document.getElementById("detailsModal"));
            myModal.show();
        }
    </script>

</body>
</html>
