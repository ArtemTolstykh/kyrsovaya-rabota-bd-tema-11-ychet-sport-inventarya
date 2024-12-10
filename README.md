# kyrsovaya-rabota-bd-tema-11-ychet-sport-inventarya
Курсовая работа БД. Тема Учет спортивного инвентаря. Толстых А.А.

sql запрос для создания структуры
-- Создание базы данных
CREATE DATABASE IF NOT EXISTS sports_rental;
USE sports_rental;

-- Таблица для хранения данных об инвентаре
CREATE TABLE equipment (
    equipment_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    size VARCHAR(50),
    price_per_day DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    status ENUM('available', 'out_of_stock', 'repair') NOT NULL DEFAULT 'available'
);

-- Таблица для хранения данных о клиентах
CREATE TABLE customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    address VARCHAR(255)
);

-- Таблица для хранения данных о заказах
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date DATETIME NOT NULL,
    return_date DATETIME NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('active', 'completed', 'canceled') NOT NULL DEFAULT 'active',
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Таблица для хранения деталей заказов
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    equipment_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (equipment_id) REFERENCES equipment(equipment_id) ON DELETE CASCADE
);

-- Таблица для хранения данных о платежах
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    payment_date DATETIME NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    payment_method ENUM('cash', 'card', 'online') NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

Что делает этот скрипт:
Создает базу данных sports_rental и использует её.
Создает пять таблиц:
equipment для хранения данных об инвентаре.
customers для хранения данных о клиентах.
orders для хранения данных о заказах.
order_items для хранения состава заказов.
payments для хранения данных о платежах.
Устанавливает связи между таблицами через внешние ключи (FOREIGN KEY).
