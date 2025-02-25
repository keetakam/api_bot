<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Details in Table as Expandable Row</title>
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
                        <button class="btn btn-primary btn-sm" onclick="toggleDetails('detail1')">More</button>
                    </td>
                </tr>
                <tr id="detail1" class="d-none">
                    <td colspan="4" class="text-start">
                        <strong>รายละเอียด:</strong> สมชายเป็นนักพัฒนาเว็บที่มีประสบการณ์ใน HTML, CSS, และ JavaScript
                    </td>
                </tr>

                <tr>
                    <td>2</td>
                    <td>สมหญิง</td>
                    <td>25</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="toggleDetails('detail2')">More</button>
                    </td>
                </tr>
                <tr id="detail2" class="d-none">
                    <td colspan="4" class="text-start">
                        <strong>รายละเอียด:</strong> สมหญิงเป็นนักออกแบบ UI/UX ที่เชี่ยวชาญใน Figma และ Adobe XD
                    </td>
                </tr>

                <tr>
                    <td>3</td>
                    <td>ก้อง</td>
                    <td>35</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="toggleDetails('detail3')">More</button>
                    </td>
                </tr>
                <tr id="detail3" class="d-none">
                    <td colspan="4" class="text-start">
                        <strong>รายละเอียด:</strong> ก้องเป็นวิศวกรซอฟต์แวร์ที่ทำงานด้าน AI และ Machine Learning
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleDetails(detailId) {
            var detailsRow = document.getElementById(detailId);
            detailsRow.classList.toggle("d-none");
        }
    </script>

</body>
</html>
