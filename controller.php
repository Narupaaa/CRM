<?php

class Controller
{
    public function init()
    {
        $case = $_GET["case"] ?? "N/A";

        switch ($case) {
            case 'test':
                include("view/test.php");
                break;

            case 'stock':
                include("view/stock.php");
                break;

            case 'customer':
                include("view/customer.php");
                break;

            default:
                include("view/dashbroad.php");
                break;
        }
    }
}
