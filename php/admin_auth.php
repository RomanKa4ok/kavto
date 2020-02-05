<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db_connection.php';

$errors = [];
$data = [];
if (isset($_POST['auth'])) {
    if (!isset($_POST['username']) || empty($_POST['username']) || trim($_POST['username'])=='')
        $errors['username'] = 'Логин обязателен.';

    if (!isset($_POST['password']) || empty($_POST['password']) || trim($_POST['password'])=='' )
        $errors['password'] = 'Пароль обязателен.';

    if ( ! empty($errors)) {


        $data['success'] = false;
        $data['errors']  = $errors;
        echo json_encode($data);

    }else{
        doAuth($_POST['username'], $_POST['password']);
    }
}

function doAuth($username, $password)
{
    $data = [];

        $dbh = connectToDb();

    if ((is_array($dbh) && $dbh['error'] == 'connection_failed') || !($dbh instanceof PDO)) {
        $data['success'] = false;
        $data['errors'] = 'Внутренняя ошибка. 1'; // Ошибка соединения с базой
        echo json_encode($data);
        exit();

    } elseif($dbh instanceof PDO) {
        try {


            $stmt = $dbh->prepare("SELECT * FROM admins where username=? LIMIT 1");
            $stmt->bindParam(1, $username);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result)
            {
                if (password_verify($password,$result['password']))
                {
                    session_start();
                    $_SESSION['admin'] = ['auth_status'=> 'signedIN','username'=>$result['username']];
                    $data['success'] = true;
                    $data['message'] = 'Авторизация успешна!';
                }else{
                    $data['success'] = false;
                    $data['errors'] = 'Авторизация не успешна! Не верный пароль!';
                }
            }else{
                $data['success'] = false;
                $data['errors'] = 'Не найден пользователь с таким логином!';
            }
        }
        catch (Exception $exception)
        {
            $data['errors'] = 'Внутренняя ошибка. 2'; // Ошибка вставки в базу
        }
    }
    echo json_encode($data);
    exit();

}
