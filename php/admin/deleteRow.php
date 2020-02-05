<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once '../db_connection.php';

$dbh = connectToDb();
$data = [];
$errors = [];
if ((is_array($dbh) && $dbh['error'] == 'connection_failed') || !($dbh instanceof PDO)) {
    $data['errors'] = 'Внутренняя ошибка. 1'; // Ошибка соединения с базой

} elseif($dbh instanceof PDO) {
    try {


        $stmt = $dbh->prepare("DELETE FROM requests where id=?");
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT);

        $stmt->execute();
        $data['message'] = 'Запись удалена!';
    }
    catch (Exception $exception)
    {
        $data['errors'] = 'Внутренняя ошибка. 2'; // Ошибка удаления с базы
    }
}

echo json_encode($data);