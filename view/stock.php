<div class="col-md-12">

    <div class="card" style="margin-bottom:10px;">
        <div class="card-header"><b><i class="bx bx-list"></i> เพิ่มหมวดหมู่</b></div>
        <div class="card-body">
            <div id="product-list-page">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>รายการสินค้า</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                        เพิ่มสินค้า
                    </button>
                </div>


                <table class="table">
                    <thead>
                        <tr>
                            <th>รหัสสินค้า (SKU)</th>
                            <th>ชื่อสินค้า</th>
                            <th>หมวดหมู่</th>
                            <th>ราคาต้นทุน</th>
                            <th>หน่วย</th>
                            <th>คงเหลือ</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-table-body">
                        <!-- Sample Data -->
                        <tr>
                            <td>PROD001</td>
                            <td>Chemical A</td>
                            <td>สารเคมี</td>
                            <td>350.00</td>
                            <td>KG</td>
                            <td>50</td>
                            <td class="action-buttons">
                                <a href="#" class="btn btn-secondary btn-sm btn-view-product">ดู</a>
                                <a href="#" class="btn btn-secondary btn-sm btn-edit-product">แก้</a>
                            </td>
                        </tr>
                        <tr>
                            <td>PROD002</td>
                            <td>Solvent B Premium</td>
                            <td>ตัวทำละลาย</td>
                            <td>120.50</td>
                            <td>LTR</td>
                            <td>150</td>
                            <td class="action-buttons">
                                <a href="#" class="btn btn-secondary btn-sm btn-view-product">ดู</a>
                                <a href="#" class="btn btn-secondary btn-sm btn-edit-product">แก้</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- <div style="text-align: center; margin-top: 20px;">
                    [Pagination: << < 1 2 3> >> ]
                </div> -->
            </div>
        </div>
    </div>
</div>

<!-- The Modal add-->
<div class="modal fade" id="addProduct">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">+ Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="form">
                    <input type="hidden" name="case" value="addProduct">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">รหัสสินค้า (SKU)</label>
                            <input type="text" class="form-control" name="product-sku" placeholder="SKU" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">ชื่อสินค้า</label>
                            <input type="text" class="form-control" name="product-name" placeholder="ชื่อสินค้า"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">หมวดหมู่</label>
                            <select class="form-select" name="product-category" required>
                                <option value="">-- เลือก --</option>
                                <option value="1">สารเคมี</option>
                                <option value="2">ตัวทำละลาย</option>
                                <option value="3">สารเติมแต่ง</option>
                                <option value="4">อื่นๆ</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">ราคาต้นทุน</label>
                            <input type="number" class="form-control" name="product-cost" placeholder="0.00"
                                step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">หน่วย</label>
                            <input type="text" class="form-control" name="product-unit" placeholder="เช่น KG, LTR"
                                required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">คงเหลือ</label>
                            <input type="number" class="form-control" name="product-stock" placeholder="0" min="0">
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <button type="reset" class="btn btn-secondary">ล้าง</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>



        </div>
    </div>
</div>
<!-- edit -->
<div class="modal fade" id="productEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form class="form">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">แก้ไขสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>

                <div class="modal-body">
                    <!-- hidden inputs -->
                    <input type="hidden" name="case"  value="editProduct">
                    <input type="hidden" name="id" id="edit_product_id"> 

                    <div class="mb-2">
                        <label class="form-label">รหัสสินค้า (SKU)</label>
                        <input type="text" class="form-control" name="product_sku" id="edit_product_sku" >
                    </div>

                    <div class="mb-2">
                        <label class="form-label">ชื่อสินค้า</label>
                        <input type="text" class="form-control" name="product_name" id="edit_product_name" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">หมวดหมู่</label>
                        <input type="text" class="form-control" name="product_category" id="edit_product_category">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">ราคาต้นทุน</label>
                        <input type="number" step="0.01" class="form-control" name="product_cost"
                            id="edit_product_cost">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">หน่วย</label>
                        <input type="text" class="form-control" name="product_unit" id="edit_product_unit">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">คงเหลือ</label>
                        <input type="number" step="1" class="form-control" name="product_stock" id="edit_product_stock">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึกการเปลี่ยนแปลง</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

    function removeProduct(id) {
        if (confirm("คุณต้องการลบสินค้านี้ใช่หรือไม่?")) {
            $.post("model.php", { 'case': 'deleteProduct', 'id': id }, function (res) {
                location.reload();
            })
        }
    }

    function editProduct(id) {
        $.get("model.php", { 'case': 'getProductById', 'id': id }, function (res) {
            var obj = JSON.parse(res);
            
            $("#edit_product_id").val(obj[0].product_id);
            $("#edit_product_sku").val(obj[0].product_sku);
            $("#edit_product_name").val(obj[0].product_name);
            $("#edit_product_category").val(obj[0].product_category);
            $("#edit_product_cost").val(obj[0].product_cost);
            $("#edit_product_unit").val(obj[0].product_unit);
            $("#edit_product_stock").val(obj[0].product_stock);

        })
    }


    $(document).ready(function () {

        $(".form").on('submit', (function (e) {
            e.preventDefault();
            $.ajax({
                url: "model.php", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) // A function to be called if request succeeds
                {
                    alert(data);
                    // location.reload();
                    // var obj = JSON.parse(data);
                    // if (obj.state == "true") {
                    //     alert(obj.text)
                    // }
                    // else{
                    //     alert(obj.text);
                    // }
                }
            });
            return false;
        }));
    });


    $.get("model.php", { 'case': 'getProduct' }, function (data) {
        var obj = JSON.parse(data);
        $.each(obj, function (i, item) {
            $.get("model.php", { 'case': 'getProduct' }, function (data) {
                var obj = JSON.parse(data);
                var rows = "";

                $.each(obj, function (i, item) {
                    rows += `
            <tr>
                <td>${item.product_sku}</td>
                <td>${item.product_name}</td>
                <td>${item.product_category}</td>
                <td>${item.product_cost}</td>
                <td>${item.product_unit}</td>
                <td>${item.product_stock}</td>
                <td>
                      <button class="btn btn-sm btn-primary" onclick="editProduct(${item.product_id})" data-bs-toggle="modal" data-bs-target="#productEditModal"">
                        <i class="bi bi-pencil"></i> แก้ไข
                    </button>
                    <button class="btn btn-sm btn-danger delete-product"  onclick="removeProduct(${item.product_id})">
                        <i class="bi bi-trash"></i> ลบ
                    </button>
                </td>
            </tr>
        `;
                });

                $("#product-table-body").html(rows);
            });
        });
    });
</script>