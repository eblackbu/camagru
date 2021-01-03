<?php

/**
 * Class Model
 * Mini-analog of ORM
 */
class Model
{
    public function __construct(...$kwargs)
    {
        // TODO обернуть в блок try
        foreach ($this->_fields as $field_name)
            $this->__set($kwargs[$field_name], $field_name);
    }

    /**
     * Function for getting instance of some Model by id
     * @param int $id
     * @return Model
     * @throws ORMException
     */
    public static function getOne(int $id): Model
    {
        $model_name = static::class;
        if ($model_name == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $pdo = DB::getInstance();
        $query = $pdo->prepare("SELECT 1 FROM :model_name WHERE `id`=:id");
        if (!$query)
            throw new ORMException('Error in preparation of query', 227);
        $query->bindValue(':model_name', $model_name, PDO::PARAM_STR);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $result = $query->execute();
        $query->closeCursor();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $current_model = get_called_class();
        return new $current_model($query->fetch());
    }

    /**
     * Function for array of instances of some Model. You can send filters in DjangoORM format.
     * @param array ...$kwargs
     * @return array
     * @throws ORMException
     */
    public static function getMany(array ...$kwargs): array
    {
        $model_name = static::class;
        if ($model_name == 'Model')
            throw new ORMException("Error: you can't call methods directly from class Model", 226);
        $pdo = DB::getInstance();
        $query = $pdo->prepare("SELECT * FROM :model_name");

        # TODO make WHERE

        if (!$query)
            throw new ORMException('Error in preparation query', 227);
        $query->bindParam(':model_name', $model_name, PDO::PARAM_STR);
        $result = $query->execute();
        $query->closeCursor();
        if (!$result)
            throw new ORMException('Error in execution prepared query', 228);
        $current_model = get_called_class();
        return array_map(function ($row) use ($current_model) {
            return new $current_model($row);
        }, $query->fetchall());
    }

    protected function __bind_params($query, $fields_array)
    {
        $query->bindParam(':model_name', static::class, PDO::PARAM_STR);

        foreach ($fields_array as $field)
            if (gettype($this->__get($field) == 'int'))
                $query->bindParam(':' . $field, $this->__get($field), PDO::PARAM_INT);
            else
                $query->bindParam(':' . $field, $this->__get($field), PDO::PARAM_STR);
    }

    protected function __prepare_string_for_update(): string
    {
        $arr = [];
        foreach ($this->_fields as $field)
        {
            if ($field != 'id')
                $arr[] = '`' . (string)$field . '` = :' . (string)$field;
        }

        return implode(', ', $arr);
    }

    protected function _update(): bool
    {
        $prepared_string = $this->__prepare_string_for_update();
        $query = DB::getInstance()->prepare('UPDATE :model_name SET ' . $prepared_fields . 'WHERE `id` = :id');

        $this->__bind_params($query, $this->_fields);

        $query->execute();
        $query->closeCursor();
        return True;
    }

    protected function __prepare_string_for_create($needed_fields)
    {
        $columns = '(' . implode(', ', $needed_fields) . ')';
        $values = '(' . implode(', ', array_map(function ($field) {
                return ':' . $field;
            }, $needed_fields)) . ')';

        return $columns . ' VALUES ' . $values;
    }

    protected function _create(): bool
    {
        $needed_fields = implode(',',  array_filter($this->_fields, function ($field) {
            return $field != null;
        }));
        $prepared_string = $this->__prepare_string_for_create($needed_fields);
        $query = DB::getInstance()->prepare('INSERT INTO :model_name ' . $prepared_string);

        $this->__bind_params($query, $this->_fields);

        $query->execute();
        $query->closeCursor();
        return True;
    }

    /**
     * Function for saving an instance of some Model in database.
     * @return bool
     */
    public function save(): bool
    {
        if (!$this->id)
            return $this->_create();
        else
            return $this->_update();
    }

    /**
     * Function for deleting an instance of some Model in database
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        # TODO
        return True;
    }
}