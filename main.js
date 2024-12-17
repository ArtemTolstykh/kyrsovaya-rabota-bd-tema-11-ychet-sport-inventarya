const buttons = document.querySelectorAll('.button');
        const tables = document.querySelectorAll('.table-container');

        // Добавляем обработчик событий для каждой кнопки
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                // Убираем активный класс у всех кнопок и таблиц
                buttons.forEach(btn => btn.classList.remove('active'));
                tables.forEach(table => table.classList.remove('active'));

                // Добавляем активный класс для выбранной кнопки и таблицы
                button.classList.add('active');
                const tableId = button.getAttribute('data-table');
                document.getElementById(tableId).classList.add('active');
            });
        });