<?php

namespace devsergeev\yii2KladrModule\migrations;

use yii\db\Connection;

trait LoadDataInfileTrait
{
    private static $connection;

    public function loadDataInfile(
        string $tableName,
        string $csvFileName,
        string $fieldsTerminated = '$',
        string $enclosed = '%',
        int $ignoreLines = 1
    ): void
    {
        $sql = "LOAD DATA LOCAL INFILE :csvFilePath
            INTO TABLE $tableName
            FIELDS TERMINATED BY :fieldsTerminated
            ENCLOSED BY :enclosed
            LINES TERMINATED BY '\\n'
            IGNORE :ignoreLines LINES";

        $this->getConnection()->createCommand($sql, [
            ':csvFilePath' => __DIR__ . '/csv/' . $csvFileName,
            ':fieldsTerminated' => $fieldsTerminated,
            ':enclosed' => $enclosed,
            ':ignoreLines' => $ignoreLines,
        ])->execute();
    }

    private function getConnection(): Connection
    {
        if (self::$connection === null) {
            $config = $this->getConnectionConfig();
            // LOAD DATA LOCAL INFILE будет работать только с этой опцией, поэтому и создается новое подключение
            $config['attributes'] = [\PDO::MYSQL_ATTR_LOCAL_INFILE => true];
            self::$connection = new Connection($config);
        }
        return self::$connection;
    }

    private function getConnectionConfig(): array
    {
        $result['dsn'] = $this->db->dsn;
        $result['username'] = $this->db->username;
        $result['password'] = $this->db->password;
        $result['charset'] = $this->db->charset;
        return $result;
    }
}