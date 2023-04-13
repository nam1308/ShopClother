function getSecondaryCategory() {
    let primaryCategory = document.getElementById("PhanLoaiChinh").value;
    let urlGetSecondaryCategory = "https://localhost:44365/api/ProductAPI/GetSecondaryCategory?primarycategory=" + primaryCategory;
    $.ajax({
        url: urlGetSecondaryCategory,
        method: 'GET',
        contentType: 'json',
        dataType: 'json',
        success: function (response) {
            let option = '';
            for (let i = 0; i < response.length; i++) {
                option += '<option value="' + response[i].MaPhanLoai + '">' + response[i].PhanLoaiPhu + '</option>';
            }
            document.getElementById("PhanLoaiPhu").innerHTML = option;
        },
        error: function (response) {
        }
    });
}

$("#PhanLoaiChinh").change(getSecondaryCategory);

$(document).ready(function () {
    $('#category-color-size-table').DataTable({
        "language": {
            "decimal": "",
            "emptyTable": "Không có dữ liệu",
            "info": "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty": "Hiển thị 0 kết quả",
            "infoFiltered": "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu": "Hiển thị _MENU_ kết quả",
            "search": "Tìm kiếm:",
            "zeroRecords": "Không tìm thấy kết quả",
            "paginate": {
                "next": "Tiếp theo",
                "previous": "Trước đó"
            }
        }
    });
    $('#product-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#coupon-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#classify-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#review-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#order-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#user-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        }
    });
    $('#revenue-table').DataTable({
        "language": {
            "decimal":        "",
            "emptyTable":     "Không có dữ liệu",
            "info":           "Hiển thị từ _START_ đến _END_ của _TOTAL_ kết quả",
            "infoEmpty":      "Hiển thị 0 kết quả",
            "infoFiltered":   "(đã lọc từ _MAX_ kết quả)",
            "lengthMenu":     "Hiển thị _MENU_ kết quả",
            "search":         "Tìm kiếm:",
            "zeroRecords":    "Không tìm thấy kết quả",
            "paginate": {
                "next":       "Tiếp theo",
                "previous":   "Trước đó"
            }
        },
    });
});