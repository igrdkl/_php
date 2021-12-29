<?php
namespace models\admin;

use models\BaseModel;
use models\IModel;
use models\File;

class Article extends BaseModel implements IModel
{

    public $error;

    public function __construct()
    {
        $this->file = new File('article');
    }

    public function __sleep()
    {
        //return array_merge(parent::__sleep(), ['date_added']);
        return parent::__sleep();
    }
    
    public function create(array $data)
    {
        $this->title = $this->validateTitle($data['title']);
        $this->setId();
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->date_added = $data['date_added'];
        $this->description = $data['description'];
        if (empty($this->error)) {
            $this->file->new_data = $this;
            return $this->file->save(); 
        }
        return $this->error;
    }

    public function update(int $id, array $data)
    {
        
        $model = new self();
        $model->id = $id;
        $model->title = $data['title'];
        $model->author = $data['author'];
        $model->date_added = $data['date_added'];
        $model->description = $data['description'];

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

    public function view($id)
    {
        //из списка достаем тот, который нам нужен
        $key =  $this->getOneById($id);
        return (self::getList()[$key])?:null;
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