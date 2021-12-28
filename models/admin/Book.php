<?php
namespace models\admin;

use models\BaseModel;
use models\IModel;
use models\File;

class Book extends BaseModel implements IModel
{
    public $error;

    protected $count_page;

    public function __construct()
    {
        $this->file = new File('book');
    }

    public function __sleep()
    {
        return array_merge(parent::__sleep(), ['count_page']);
    }

    public function view($id)
    {
        //из списка достаем тот, который нам нужен
        $key =  $this->getOneById($id);
        return (self::getList()[$key])?:null;
    }

    public function create(array $data)
    {
        $this->validate($data);
        if (empty($this->error)) {
            $this->setId();
            $this->file->new_data = $this;
            return $this->file->save(); 
        }
        return $this->error;
    }
    
    public function update(int $id, array $data)
    {
        $model = new self();
        $model->validate($data);
        if (empty($this->error)) {
            $model->id = $id;
        }

        $key = $this->getOneById($id);

        $this->file->data_list[$key] =  $model;

        if (empty($this->error)) {
            return $this->file->save(); 
        }
        return $this->error;
    }

    public function delete($id)
    {
        $key = $this->getOneById($id);
        unset($this->file->data_list[$key]);
        return $this->file->save();
    }

    public function index()
    {
        return self::getList();
    }
        
    public static function getList()
    {        
        $list = new self();
        return $list->file->read();
    }
}
