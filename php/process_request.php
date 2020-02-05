<?php
ini_set('display_errors', 1);
    error_reporting(E_ALL);
require_once 'db_connection.php';

$errors         = [];
$data           = [];

if (!isset($_POST['name']) || empty($_POST['name']))
    $errors['name'] = 'Пожалуйста, введите имя!';

if (!isset($_POST['phone_number']) || empty($_POST['phone_number']))
    $errors['phone_number'] = 'Телефон обязателен.';

if ( !isset($_POST['message']) || empty($_POST['message']))
    $errors['message'] = 'Пожалуйста, введите описание!';


if ( ! empty($errors)) {


    $data['success'] = false;
    $data['errors']  = $errors;
} else {
    try{
        $dbh = connectToDb();
    }catch (Exception $e){
        echo json_encode($e->getMessage());
    }

    if ((is_array($dbh) && $dbh['error'] == 'connection_failed') || !($dbh instanceof PDO)  )
    {
        $data['success'] = false;
        $data['errors']  ='Внутренняя ошибка. 1'; // Ошибка соединения с базой
    }else {
        try {


            $stmt = $dbh->prepare("INSERT INTO requests (name, phone_number,message) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $phone_number);
            $stmt->bindParam(3, $message);

            $name = $_POST['name'];
            $phone_number = $_POST['phone_number'];
            $message = $_POST['message'];
            $stmt->execute();
        }
        catch (Exception $exception)
        {
            $data['errors'] = 'Внутренняя ошибка. 2'; // Ошибка вставки в базу
        }
        if (!empty($data['errors']))
        {
            $data['success'] = false;
        }else{
            $data['success'] = true;
            $data['message']  = 'Ваша заявка принята! Ожидайте звонка!';
        }

    }
}

echo json_encode($data);


