<?php

require_once 'vendor/autoload.php';

use Database\PostgrePDO;
use EntityMapper\EmployeeMapper;

$db = new PostgrePDO();
$employeeMapper = new EmployeeMapper($db->connection);

echo 'поиск по ID:';
$employeeSearch = $employeeMapper->findById(1);
var_dump($employeeSearch);

echo 'добавление записи:';
$employeeInsert = $employeeMapper->insert([
    'name' => 'Василий',
    'surname' => 'Губин',
    'phone' => '89229115566',
    'company' => 'SSK Kirov',
    'job' => 'Инженер по ТБ',
    'salary' => 120000.00
]);
var_dump($employeeInsert);

echo 'получение всех записей:';
$employeeGetAll = $employeeMapper->getAllEmployee();
var_dump($employeeGetAll);

echo 'изменение записи:';
$employeeInsert->setSalary(85000.00);
$updateResult = $employeeMapper->update($employeeInsert);
var_dump($updateResult);

echo 'удаление записи:';
$deleteResult = $employeeMapper->delete($employeeInsert->getId());
var_dump($deleteResult);

$db->closeConnection();