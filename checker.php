<?php

echo 'script start' . PHP_EOL;
$config = include('config/database.php');
$connect = connect($config);
echo 'test_connect' . PHP_EOL;
test_connect($connect);
echo 'test_put_record' . PHP_EOL;
test_put_record($connect);
echo 'test_read_record' . PHP_EOL;
test_read_record($connect);
echo 'test_count_record' . PHP_EOL;
test_count_record($connect);
echo 'script end' . PHP_EOL;

function connect(array $config)
{
    $dsn = $config['db_driver'] . ':host=' . $config['db_host'] . ';dbname=' . $config['db_dbname'];

    try {
        $pdo = new PDO(
            $dsn,
            $config['db_user'],
            $config['db_password']
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        logger('Error create PDO object- ' . $e->getMessage());
    }

    return $pdo;
}

function logger(string $info)
{
    $message = date('Y-m-d H:i:s') . ' - ' . $info . PHP_EOL;
    file_put_contents('logs/checker.log', $message, FILE_APPEND);
}

function test_connect(PDO $connect)
{
    if ($connect) {
        logger('test_connect() - Connection established');
    } else {
        logger('test_connect() - Connection error');
    }
}

function test_put_record(PDO $connect)
{
    $query_first = "INSERT INTO links (url, short) VALUES ('url-value', 'short-value')";
    $query_second = "INSERT INTO links (url, short) VALUES ('url-value', 'short-value')";

    try {
        $connect->beginTransaction();
        $connect->exec($query_first);
        $connect->exec($query_second);
        $connect->commit();
    } catch (Exception $exception) {
        logger('test_put_record() - ' . $exception->getMessage());
        $connect->rollBack();
    }
}

function test_read_record(PDO $connect)
{
    $query = "SELECT * FROM links WHERE url = 'url-value'";

    try {
        $result = $connect->query($query);
        while ($row = $result->fetch()) {
            if ($row) {
                logger("Read record - " .  json_encode($row));
            }
        }
    } catch (Exception $exception) {
        logger('test_read_record() - ' . $exception->getMessage());
    }
}

function test_count_record(PDO $connect)
{
    $query = "SELECT count(*) FROM links";

    try {
        $result = $connect->query($query);
        while ($row = $result->fetch()) {
            foreach ($row as $item) {
                logger('Count records = ' . $item);
            }
        }
    } catch (Exception $exception) {
        logger('test_count_record() - ' . $exception->getMessage());
    }
}

