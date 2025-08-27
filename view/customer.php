<div class="col-md-12">

    <div class="card" style="margin-bottom:10px;">
        <div class="card-header"><b><i class="bx bx-list"></i> customer</b></div>
        <div class="card-body">
            <div id="product-list-page">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2>list</h2>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                        add customer
                    </button>
                </div>


                <table class="table">
                    <thead>
                        <tr>
                            <th>รหัสลูกค้า</th>
                            <th>ชื่อบริษัท</th>
                            <th>ผู้ติดต่อหลัก</th>
                            <th>เบอร์โทร</th>
                            <th>อีเมล</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="customer-table-body">
                      
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
<div class="modal fade" id="addCustomer">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">addCustomer</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <form class="form">
                    <input type="hidden" name="case" value="addProduct">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">รหัสลูกค้า</label>
                            <input type="text" class="form-control" name="product-sku" placeholder="SKU" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">ชื่อบริษัท</label>
                            <input type="text" class="form-control" name="product-name" placeholder="ชื่อสินค้า"
                                required>
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