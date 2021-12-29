<?php

namespace models;

use models\File;

abstract class BaseModel 
{
    protected File $file;

    protected int $id;
    protected $title;
    protected $author;
    protected $date_added;
    protected $description;
    protected $image;

    public $error = array();
   
    abstract public function view($id);
    abstract public static function getList();

    public function __set($property, $value)
    {
        $a = array_map("ucfirst", explode( "_", $property));
        $validateMethod = "validate".implode($a);

        if (method_exists($this, $validateMethod)) {
            if ($this->$validateMethod($value)) {
                $this->$property = $value;
            }
        } else {
            $this->$property = $value; 
        }
    }

    public function __get($property)
    {
        return $this->$property;
    }

    public function __sleep()
    {
        return array('id', 'title', 'author', 'date_added');
    }


    public function getOneById(int $id)
    {
        foreach ($this->file->read() as $key=>$item) {
            if ($item->id == $id) {
                return $key;
            }
        }
        return null;
    }

    public function setId()
    {
        //список элементов
        $list = $this->file->read();
        if (count($list) == 0) {
            $this->id = 1;
        }
        //нашли порядковый номер последнего элемента
        $count = count($list) - 1; //5-1 = 4
        //получаем id последнего элемента
        if (isset($list[$count])) {
            $this->id = $list[$count]->id + 1;
            return $this->id;
        }
        return false;
    }

    protected function validateTitle($title)
    {
        if (isset($title) && !empty($title)) {
            if(strlen($title) > 10 && strlen($title) < 70) {
              $this->title = $title;                
            } else {
              $this->error['title'] = 'Не подходящая длина заголовка (10<...<70)';
            }
        } else {
            $this->error['title'] = 'Введите заголовок';
        }
    }

    protected function validateDateAdded($date_added)
    {
        if (isset($date_added) && !empty($date_added)) {
            $this->date_added = $date_added;
          } else {
            $this->date_added = date('Y-m-', time());
        }
    }

    protected function validateDescription($description)
    {
        if (isset($description) && !empty($description)) {
            if (strlen($description) > 20 && strlen($description) < 1000) {
              $this->description = htmlspecialchars($description);
            } else {
              $this->error['description'] = 'Описание должно включать больше 20 символов и не привішать 1000 символов';
            }
          } else {
            $this->error['description'] = 'Введите описание';
          }
    }

    protected function validate($data)
    {
        foreach($data as $property=>$value){
            $this->validateItem($property, $value);
        }
    }

    protected function validateItem($property, $value)
    {
        $a = array_map("ucfirst", explode( "_", $property));
        $validateMethod = "validate".implode($a);

        if (method_exists($this, $validateMethod)) {
            if ($this->$validateMethod($value)) {
                $this->$property = $value;
            }
        } else {
            $this->$property = $value; 
        }
    }

}