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

Заполнение таблиц:
-- Заполнение таблицы equipment (Инвентарь)
INSERT INTO equipment (name, category, size, price_per_day, quantity, status) VALUES
('Горный велосипед', 'Велосипеды', 'Средний', 20.00, 10, 'available'),
('Сноуборд', 'Зимний спорт', 'Большой', 15.00, 5, 'available'),
('Теннисная ракетка', 'Ракетки', 'Стандартный', 5.00, 20, 'available'),
('Лыжный комплект', 'Зимний спорт', 'Средний', 25.00, 8, 'available'),
('Страховочная система', 'Альпинизм', 'Регулируемый', 10.00, 15, 'available');

-- Заполнение таблицы customers (Клиенты)
INSERT INTO customers (first_name, last_name, phone, email, address) VALUES
('Иван', 'Иванов', '89001234567', 'ivan.ivanov@example.com', 'ул. Ленина, д. 10'),
('Мария', 'Петрова', '89007654321', 'maria.petrova@example.com', 'ул. Пушкина, д. 15'),
('Алексей', 'Сидоров', '89005557777', 'alexey.sidorov@example.com', 'ул. Чехова, д. 20'),
('Екатерина', 'Дмитриева', '89004448888', 'ekaterina.dmitrieva@example.com', 'ул. Горького, д. 25'),
('Дмитрий', 'Кузнецов', '89003339999', 'dmitry.kuznetsov@example.com', 'ул. Тургенева, д. 30');

-- Заполнение таблицы orders (Заказы)
INSERT INTO orders (customer_id, order_date, return_date, total_price, status) VALUES
(1, '2024-12-01 10:00:00', '2024-12-05 10:00:00', 100.00, 'active'),
(2, '2024-12-02 14:30:00', '2024-12-06 14:30:00', 75.00, 'completed'),
(3, '2024-12-03 09:00:00', '2024-12-04 09:00:00', 25.00, 'active'),
(4, '2024-12-04 12:15:00', '2024-12-07 12:15:00', 50.00, 'active'),
(5, '2024-12-05 16:45:00', '2024-12-10 16:45:00', 125.00, 'active');

-- Заполнение таблицы order_items (Состав заказов)
INSERT INTO order_items (order_id, equipment_id, quantity, price) VALUES
(1, 1, 2, 40.00),
(1, 2, 1, 15.00),
(2, 3, 3, 15.00),
(3, 4, 1, 25.00),
(4, 5, 5, 50.00);

-- Заполнение таблицы payments (Платежи)
INSERT INTO payments (order_id, payment_date, amount, payment_method) VALUES
(1, '2024-12-01 11:00:00', 100.00, 'card'),
(2, '2024-12-02 15:00:00', 75.00, 'cash'),
(3, '2024-12-03 10:00:00', 25.00, 'online'),
(4, '2024-12-04 13:00:00', 50.00, 'card'),
(5, '2024-12-05 17:00:00', 125.00, 'card');

