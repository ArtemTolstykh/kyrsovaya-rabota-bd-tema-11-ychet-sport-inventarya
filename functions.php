<?php
require_once 'db.php';

// Получение всех заказов с поиском
function getOrders($search = '') {
    global $pdo;
    $query = "SELECT o.*, 
                     CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
                     e.name AS equipment_name,
                     oi.quantity AS rented_quantity
              FROM orders o
              JOIN customers c ON o.customer_id = c.customer_id
              JOIN order_items oi ON o.order_id = oi.order_id
              JOIN equipment e ON oi.equipment_id = e.equipment_id";

    if ($search) {
        $query .= " WHERE CONCAT(c.first_name, ' ', c.last_name) LIKE :search 
                    OR e.name LIKE :search";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCustomerIdByFullName($first_name, $last_name, $middle_name) {
    global $pdo;
    $query = "SELECT customer_id FROM customers 
              WHERE first_name = ? AND last_name = ? AND middle_name = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name, $last_name, $middle_name]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);
    return $customer ? $customer['customer_id'] : null;
}

// Добавление записи
function addOrder($customer_id, $order_date, $return_date, $total_price) {
    global $pdo;
    $query = "INSERT INTO orders (customer_id, order_date, return_date, total_price, status) 
              VALUES (?, ?, ?, ?, 'active')";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$customer_id, $order_date, $return_date, $total_price]);
    return $pdo->lastInsertId();
}

function addOrderItem($order_id, $equipment_id, $quantity) {
    global $pdo;
    $query = "INSERT INTO order_items (order_id, equipment_id, quantity, price) 
              SELECT ?, ?, ?, price_per_day 
              FROM equipment WHERE equipment_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$order_id, $equipment_id, $quantity, $equipment_id]);

    // Обновляем количество доступного товара
    $update_query = "UPDATE equipment SET quantity = quantity - ? WHERE equipment_id = ?";
    $update_stmt = $pdo->prepare($update_query);
    $update_stmt->execute([$quantity, $equipment_id]);
}


// Добавление клиента
function addCustomer($first_name, $last_name, $middle_name, $phone, $email, $address) {
    global $pdo;
    $query = "INSERT INTO customers (first_name, last_name, middle_name, phone, email, address) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$first_name, $last_name, $middle_name, $phone, $email, $address]);
}

// Редактирование записи
function editOrder($order_id, $customer_id, $order_date, $return_date, $total_price, $status) {
    global $pdo;
    $query = "UPDATE orders SET customer_id = ?, order_date = ?, return_date = ?, total_price = ?, status = ? 
              WHERE order_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$customer_id, $order_date, $return_date, $total_price, $status, $order_id]);
}

// Удаление записи
function deleteOrder($order_id) {
    global $pdo;
    $query = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$order_id]);
}

// Вывод клиентов
function getCustomers() {
    global $pdo;
    $query = "SELECT * FROM customers ORDER BY last_name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Добавление нового товара
function addEquipment($name, $category, $size, $price_per_day, $quantity, $status) {
    global $pdo;
    $query = "INSERT INTO equipment (name, category, size, price_per_day, quantity, status) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $category, $size, $price_per_day, $quantity, $status]);
}

// Получение списка всех товаров
function getEquipment() {
    global $pdo;
    $query = "SELECT * FROM equipment ORDER BY name ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
