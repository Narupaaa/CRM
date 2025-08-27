<?php
include('DB.php');
$DB = new DB();

switch ($_REQUEST['case']) {
    case 'addProduct':

        $arr = array();
        $col = array();
        $values = array();
        $type = array();

        // Mapping ค่าจากฟอร์ม
        $col[] = "product_sku";
        $values[] = $_POST['product-sku'];
        $type[] = "s";

        $col[] = "product_name";
        $values[] = $_POST['product-name'];
        $type[] = "s";

        $col[] = "product_category";
        $values[] = $_POST['product-category'];
        $type[] = "s";

        $col[] = "product_cost";
        $values[] = $_POST['product-cost'];
        $type[] = "d";  // double / decimal

        $col[] = "product_unit";
        $values[] = $_POST['product-unit'];
        $type[] = "s";

        $col[] = "product_stock";
        $values[] = $_POST['product-stock'];
        $type[] = "i";  // integer


        $tb_name = "CRM_products";
        $DB->insert($tb_name, $col, $values, $type);


        $arr["state"] = "true";
        $arr["text"] = "ดำเนินการสำเร็จ";

        //----//

        echo json_encode($arr);
        break;


    case 'getProduct':
        $query = "SELECT * FROM CRM_products";
        $rs = $DB->Query1($query);
        echo json_encode($rs);

        break;

    case 'getProductById':
        $query = "SELECT * FROM CRM_products  where product_id =" . $_GET["id"];
        $rs = $DB->Query1($query);
        echo json_encode($rs);

        break;

    case 'deleteProduct':
        $query = "delete FROM CRM_products where product_id =" . $_POST["id"];
        $rs = $DB->Query1($query);
        echo json_encode($rs);

        break;

    case 'editProduct':

        $arr = array();
        $col = array();
        $values = array();
        $type = array();

        $col[] = "product_sku";
        $values[] = $_POST['product_sku'];
        $type[] = "s";

        $col[] = "product_name";
        $values[] = $_POST['product_name'];
        $type[] = "s";

        $col[] = "product_category";
        $values[] = $_POST['product_category'];
        $type[] = "s";

        $col[] = "product_cost";
        $values[] = $_POST['product_cost'];
        $type[] = "d";  // double / decimal

        $col[] = "product_unit";
        $values[] = $_POST['product_unit'];
        $type[] = "s";

        $col[] = "product_stock";
        $values[] = $_POST['product_stock'];
        $type[] = "i";  // integer


        $Ccols = array();
        $Cvalues = array();
        $Ctype = array();

        $Ccols[] = "product_id";
        $Cvalues[] = $_POST['id'];
        $Ctype[] = "i";

        $tb_name = "CRM_products";
        $DB->update($tb_name, $col, $values, $type, $Ccols, $Cvalues, $Ctype);

        $arr["state"] = "true";
        $arr["text"] = "ดำเนินการสำเร็จ";
        echo json_encode($arr);
        break;
}




?>