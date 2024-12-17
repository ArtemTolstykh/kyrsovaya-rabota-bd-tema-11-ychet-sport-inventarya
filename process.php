<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Добавление нового заказа
    if (isset($_POST['add_record'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $equipment_id = $_POST['equipment_id'];
        $quantity = $_POST['quantity'];
        $order_date = $_POST['order_date'];
        $return_date = $_POST['return_date'];
        $total_price = $_POST['total_price'];

        // Получаем ID клиента по ФИО
        $customer_id = getCustomerIdByFullName($first_name, $last_name, $middle_name);
        if ($customer_id) {
            // Добавляем запись в orders и order_items
            $order_id = addOrder($customer_id, $order_date, $return_date, $total_price);
            addOrderItem($order_id, $equipment_id, $quantity);
        } else {
            die("Ошибка: Клиент с таким ФИО не найден!");
        }
    }

    // Добавление нового клиента
    elseif (isset($_POST['add_customer'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $middle_name = $_POST['middle_name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];

        addCustomer($first_name, $last_name, $middle_name, $phone, $email, $address);
    }

    // Добавление нового товара
    elseif (isset($_POST['add_equipment'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $size = $_POST['size'];
        $price_per_day = $_POST['price_per_day'];
        $quantity = $_POST['quantity'];
        $status = $_POST['status'];

        addEquipment($name, $category, $size, $price_per_day, $quantity, $status);
    }

    // Удаление заказа
    elseif (isset($_POST['delete_record'])) {
        deleteOrder($_POST['order_id']);
    }
}

header('Location: index.php');
exit();
?>
