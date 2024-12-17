<?php
require_once 'functions.php';

$search = $_POST['search'] ?? '';
$orders = getOrders($search);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Административная панель</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 style="text-align: center;">Административная панель: Управление заказами</h1>

    <div class="button-container">
        <div class="button active" data-table="table1">Добавление заказа</div>
        <div class="button" data-table="table2">Добавление товара</div>
        <div class="button" data-table="table3">Добавление клиента</div>
    </div>

    <div id="table1" class="table-container active">
    <!-- Поиск -->
    <h2>Поиск по заказам</h2>
    <form method="POST" class="form_search">
        <input type="text" name="search" placeholder="Поиск по ФИО" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Найти</button>
    </form>

    <h2>Добавить новый заказ</h2>
    <form method="POST" action="process.php" class="form_add_new_order">
        <input type="text" name="first_name" placeholder="Имя клиента" required>
        <input type="text" name="last_name" placeholder="Фамилия клиента" required>
        <input type="text" name="middle_name" placeholder="Отчество клиента" required>
            <select name="equipment_id" required>
                <option value="" disabled selected>Выберите товар</option>
                <?php
                $equipment = getEquipment(); // Получаем список всех товаров
                foreach ($equipment as $item): ?>
                    <option value="<?= $item['equipment_id'] ?>">
                        <?= htmlspecialchars($item['name']) ?> (Доступно: <?= $item['quantity'] ?>)
                </option>
                <?php endforeach; ?>
            </select>
        <input type="number" name="quantity" placeholder="Количество" min="1" required>
        <input type="datetime-local" name="order_date" required>
        <input type="datetime-local" name="return_date" required>
        <input type="number" step="0.01" name="total_price" placeholder="Общая стоимость" required>
        <button type="submit" name="add_record">Добавить заказ</button>
    </form>

    <!-- Таблица с заказами -->
    <h2>Список заказов</h2>
    <table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>ФИО Клиента</th>
        <th>Дата заказа</th>
        <th>Дата возврата</th>
        <th>Стоимость</th>
        <th>Товар</th>
        <th>Количество</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order['order_id'] ?></td>
        <td><?= htmlspecialchars($order['customer_name']) ?></td>
        <td><?= $order['order_date'] ?></td>
        <td><?= $order['return_date'] ?></td>
        <td><?= $order['total_price'] ?></td>
        <td><?= htmlspecialchars($order['equipment_name']) ?></td>
        <td><?= $order['rented_quantity'] ?></td>
        <td>
            <!-- Форма удаления -->
            <form method="POST" action="process.php" style="display:inline;">
                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                <button type="submit" name="delete_record">Удалить</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>

    <div id="table2" class="table-container">
    <!-- Блок добавления нового товара -->
    <h2>Добавить новый товар</h2>
    <form method="POST" action="process.php">
        <input type="text" name="name" placeholder="Название товара" required>
        <input type="text" name="category" placeholder="Категория" required>
        <input type="text" name="size" placeholder="Размер">
        <input type="number" step="0.01" name="price_per_day" placeholder="Цена за день" required>
        <input type="number" name="quantity" placeholder="Количество" required>
        <input type="text" name="status" placeholder="Статус (available, out_of_stock, repair)" required>
        <button type="submit" name="add_equipment">Добавить товар</button>
    </form>

    <!-- Таблица с выводом всех товаров -->
    <h2>Список товаров</h2>
    <table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Категория</th>
        <th>Размер</th>
        <th>Цена за день</th>
        <th>Количество</th>
        <th>Статус</th>
    </tr>
    <?php 
    
    // Получаем список всех товаров
    $equipment = getEquipment(); 
    foreach ($equipment as $item): ?>
    <tr>
        <td><?= $item['equipment_id'] ?></td>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= htmlspecialchars($item['category']) ?></td>
        <td><?= htmlspecialchars($item['size']) ?></td>
        <td><?= $item['price_per_day'] ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= htmlspecialchars($item['status']) ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    </div>

    <div id="table3" class="table-container">

    <!--Добавление нового клиента-->
    <h2>Добавить нового клиента</h2>
    <form method="POST" action="process.php">
        <input type="text" name="first_name" placeholder="Имя" required>
        <input type="text" name="last_name" placeholder="Фамилия" required>
        <input type="text" name="middle_name" placeholder="Отчество" required>
        <input type="text" name="phone" placeholder="Телефон" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Адрес" required>
        <button type="submit" name="add_customer">Добавить клиента</button>
    </form>

    <h2>Список клиентов</h2>
    <table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Фамилия</th>
        <th>Имя</th>
        <th>Отчество</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Адрес</th>
    </tr>
    <?php 
    // Получаем список клиентов
    $customers = getCustomers(); 
    foreach ($customers as $customer): ?>
    <tr>
        <td><?= $customer['customer_id'] ?></td>
        <td><?= htmlspecialchars($customer['last_name']) ?></td>
        <td><?= htmlspecialchars($customer['first_name']) ?></td>
        <td><?= htmlspecialchars($customer['middle_name']) ?></td>
        <td><?= htmlspecialchars($customer['phone']) ?></td>
        <td><?= htmlspecialchars($customer['email']) ?></td>
        <td><?= htmlspecialchars($customer['address']) ?></td>
    </tr>
    <?php endforeach; ?>
    </table> 
    </div>

<script src="main.js"></script>
</body>
</html>
