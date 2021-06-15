<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseRepository implements RepositoryInterface
{
    //model
    protected $model;

    /**
     * constructor
     * @param null
     * @return null
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model class
     */
    abstract public function getModel();

    /**
     * set model
     * @param null
     * @return null
     */
    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * get all element off the model repo
     * @param null
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * find an element by its id
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->model->find($id);
        return $result;
    }

    /**
     * create a new model element
     * @param $attributes
     * @return mixed
     */
    public function create($attributes)
    {

        if (isset($attributes['id'])) {
            unset($attributes['id']);
        }
        return $this->model->create($attributes);
    }

    /**
     * update an element
     * @param $id, $attributes
     * @return mixed
     */
    public function update($id, $attributes)
    {
        $result = $this->model->find($id);
        if ($result) {
            if (isset($attributes['id'])) {
                unset($attributes['id']);
            }
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {

        $result = $this->model->find($id);
        if ($result->delete()) {
            return true;
        }

        return false;
    }

    /**
     * Get all element that enable( is_disabled = 0 )
     * @param null
     * @return mixed
     */
    public function getEnabled()
    {
        if ($this->model->where('is_disabled', '=', 0)->get())
            return $this->model->where('is_disabled', '=', 0)->get();
        else return [];
    }

    /**
     * Get all element that enable( is_disabled = 0 )
     * And another condition($other)
     * @param $other
     * @param $other_value
     * @return mixed
     */
    public function getByConditions($other, $other_value)
    {
        return $this->model
            ->where('is_disabled', '=', 0)
            ->where($other, '=', $other_value)->get();
    }

    /**
     * Where
     * @param $condition
     * @param $value
     * @return mixed
     */
    public function where($condition, $value)
    {
        return $this->model->where($condition, $value);
    }
}
