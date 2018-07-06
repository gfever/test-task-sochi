<?php
/**
 * @author d.ivaschenko
 */

namespace App\Repositories;


use App\Models\ModelInterface;

/**
 * Class Repository
 * @package App\Repositories
 */
abstract class Repository implements RepositoryInterface
{
    protected $table;
    protected $connect;
    protected $model;

    protected $where;

    public function __construct()
    {
        $config = include '../../config/database.php';
        $this->connect = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['username'], $config['password']);
    }

    /**
     * @param ModelInterface $model
     * @return bool
     */
    public function create(ModelInterface $model)
    {
        $attributes = array_filter($model->getAttributes());

        $keys = array_map(function ($value) {
            return ':' . $value;
        }, array_keys($attributes));

        $sql = "INSERT INTO {$this->table} ({implode(',', array_keys($attributes))}) VALUES ({implode(',', $keys)})";

        $query = $this->connect->prepare($sql);

        return $query->execute(array_combine($keys, array_values($attributes)));
    }

    /**
     * @param string $name
     * @param string $value
     * @return mixed
     */
    public function getOneBy(string $name, string $value)
    {
        $code = \PDO::quote($value);
        $result = $this->connect->query("SELECT * FROM {$this->table} WHERE {$name} = {$code} LIMIT 1");
        $result->setFetchMode(\PDO::FETCH_CLASS, $this->model);

        return $result->fetch();
    }

}