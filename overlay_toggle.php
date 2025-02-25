<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Details & Show Modal</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <h2 class="text-center mb-4">แสดงข้อมูลใน Modal และ Toggle รายละเอียด</h2>

    <div class="container text-center">
        <button class="btn btn-success" onclick="toggleDetails()">Toggle รายละเอียด</button>
        <button class="btn btn-primary" onclick="showDetails('รายละเอียดเพิ่มเติม', 'นี่คือข้อมูลที่แสดงใน Modal!')">เปิด Modal</button>

        <!-- ✅ กล่องแสดงรายละเอียด -->
        <div id="details" class="alert alert-info mt-3 d-none">
            <p>นี่คือรายละเอียดเพิ่มเติมที่สามารถซ่อนหรือแสดงได้เมื่อกดปุ่ม "Toggle รายละเอียด"</p>
        </div>
    </div>

    <!-- ✅ Bootstrap Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">รายละเอียด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
        // ✅ ฟังก์ชันแสดงรายละเอียดใน Modal
        function showDetails(name, details) {
            document.getElementById("modalTitle").textContent = name;
            document.getElementById("modalDetails").textContent = details;
            var myModal = new bootstrap.Modal(document.getElementById("detailsModal"));
            myModal.show();
        }

        // ✅ ฟังก์ชัน Toggle รายละเอียดในหน้าเว็บ
        function toggleDetails() {
            var details = document.getElementById("details");
            details.classList.toggle("d-none");
        }
    </script>

</body>
</html>
