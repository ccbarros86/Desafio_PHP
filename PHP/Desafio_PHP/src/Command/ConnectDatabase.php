<?php

function ConnectPDO($sql)
{
    $dsn = "mysql:host=app-mysql;dbname=app_db";
    $conn = new PDO($dsn, "admin", "admin");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $result = $conn->prepare($sql);
    $result->execute();
    return $result;
}
