# Домашнее задание №10
Индексы и анализ производительности.

**Цель:** научиться повышать производительность сервера БД на уровне администрирования настроек
## Задача
Подготовить список из 6 основных запросов к БД, разработанной на предыдущих занятиях. Целесообразно выбрать 3 "простых" (задействована 1 таблица), 3 "сложных" (агрегатные функции, связи таблиц).

Скрипт для наполнения основных таблиц БД тестовыми данными.
- Заполнить таблицы, увеличив общее количество строк текстовых данных до 10 000.
- Провести анализ производительности запросов к БД, сохранить планы выполнения.
- Заполнить таблицы, увеличив общее количество строк текстовых данных до 10 000 000.
- Провести анализ производительности запросов к БД, сохранить планы выполнения.

На основе анализа запросов и планов предложить оптимизации (индексы, структура, параметры и др.), выполнить их, сравнить результат (планы выполнения).

**Критерии оценки:**
- скрипт создания БД (с предыдущих занятий),
- скрипт заполнения БД тестовыми данными,
- таблица с результатами по каждому из 6 запросов,
    - запрос
    - план на БД до 10 000 строк
    - план на БД до 10 000 000 строк
    - план на БД до 10 000 000 строк, что удалось улучшить, перечень оптимизаций с пояснениями
- отсортированный список (15 значений) самых больших по размеру объектов БД (таблицы, включая индексы, сами индексы)
- отсортированные списки (по 5 значений) самых часто и редко используемых индексов
- особенно важно отследить изменения во времени исполнения запросов
## Как проверить выполненное задание
1. запустить все службы `docker-compose up -d`,
1. настроить подключение к БД по реквизитам доступа (указаны в файле `docker-compose.yml`, в секции `environment`),
1. запустить скрипт `10K.sql`,
1. запустить скрипт `10M.sql`,
1. по [таблице](report.md) сравнить результаты планов выполнения,
1. запустить скрипт `optimization.sql`, объяснения к методам оптимизации приведены в отчете, в разделе [Проведенные меры оптимизации](report.md#проведенные-меры-оптимизации) и  полученные результаты в разделе [После оптимизации](report.md#после-оптимизации).
