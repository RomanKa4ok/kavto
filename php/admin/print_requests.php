<?php
require_once 'php/db_connection.php';

$dbh = connectToDb();
$data = [];
$errors = [];
if ((is_array($dbh) && $dbh['error'] == 'connection_failed') || !($dbh instanceof PDO)) {
    $errors['internal'] = 'Внутренняя ошибка. 1'; // Ошибка соединения с базой

} elseif($dbh instanceof PDO) {
    try {


        $stmt = $dbh->prepare("SELECT * FROM requests ORDER BY status ASC");

        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($result)
        {
            $data['results'] = $result;
        }else{

            $data['info'] = '<div class="no-requests">Нет входящих заявок</div>';
        }
    }
    catch (Exception $exception)
    {
        $errors['internal'] = 'Внутренняя ошибка. 2'; // Ошибка выборки с базы
    }
}