<?php
class ConnectionPool
{
    private $config = require_once 'bdconfig.php';
    private $url;
    private $user, $pass;
    private $options;
    private $connections;
    private $usedConnections;
    private function __construct(array $connections)
    {
        $this->url = 'mysql:dbname=' + $this->config['db_name'] + ";host=" + $this->config['host'];
        $this->user = $this->config['user'];
        $this->pass = $this->config['pass'];
        $this->options = $this->config['options'];
        $this->connections = $connections;
        $this->usedConnections = array();
    }

    public static function create(): ConnectionPool
    {
        $configuration = require_once 'bdconfig.php';
        $url = 'mysql:dbname=' + $configuration['db_name'] + ";host=" + $configuration['host'];
        $connectionList = array();
        for ($i = 0; $i < $configuration['max_pool_size']; $i++) {
            array_push($connectionList, new PDO($url, $configuration['user'], $configuration['pass'], $configuration['options']));
        }
        return new ConnectionPool($connectionList);
    }

    public function getConnection(): PDO
    {
        if (sizeof($this->connections) < 1) {
            if (sizeof($this->usedConnections) < $this->config['max_pool_size']) {
                array_push($this->connections, new PDO('mysql:dbname=' + $this->database + ";host=" + $this->host, $this->user, $this->pass, $this->options));
            } else {
                throw new RuntimeException("Max pool size reached!!");
            }
        }
        $position = sizeof($this->connections) - 1;
        $connection = $this->connections[$position];
        unset($connection[$position]);
        if ($connection->getAttribute(PDO::ATTR_TIMEOUT) == 0) {
            $connection = new PDO('mysql:dbname=' + $this->database + ";host=" + $this->host, $this->user, $this->pass, $this->options);
        }
        array_push($this->usedConnections, $connection);
        return $connection;
    }

    public function releaseConnection(PDO $connection): bool
    {
        $iniLength = sizeof($this->usedConnections);
        array_push($this->connections, $connection);
        unset($this->usedConnections[array_search($connection, $this->usedConnections)]);
        return $iniLength == $this->usedConnections;
    }
    public function getSize(): int
    {
        return sizeof($this->connections) + sizeof($this->usedConnections);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function shutDown()
    {
        foreach ($this->usedConnections as $value) {
            $value->close();
        }
        foreach ($this->connections as $value) {
            $value->close();
        }
    }
}
