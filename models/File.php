<?php

namespace models;

class File
{
    private const DIR_PATH = './filelist/';
    public $name;
    public $new_data = null;
    public $data_list = array();

    public function __construct($name)
    { 
        if ($this->validate(self::DIR_PATH.$name.'.txt')) {
            $this->name = $name;
        }
    }

    private function validate ($name)
    {
        if (file_exists($name)) {
            return true;
        }
        return false;
    }

    public function read ()
    {
        //считываем файл в массив
        $list = file(self::DIR_PATH.$this->name.'.txt');
        //перебираем элементы
        $this->data_list = array();
        foreach ($list as $item) {
            //если не пустая строка
            if($item != ''){
                //распаковываем
                $this->data_list[] = unserialize($item);
            }
        }
        return $this->data_list;
    }

    public function writeOne()
    {
        //открываем файл-каталог
        $handle = fopen(self::DIR_PATH.$this->name.'.txt', 'a+');
        //записываем в конец файла
        fwrite($handle, serialize($this->new_data)."\n");
        fclose($handle);

        return true; 
    }

    public function rewriteAll()
    {        
        $handle = fopen(self::DIR_PATH.$this->name.'.txt', 'w');
        foreach ($this->data_list as $item) {
            fwrite($handle, serialize($item)."\n");
        }
        fclose($handle);
    } 

    public function save()
    {   
        if (!is_null($this->new_data)) {
            //записываем в конец файла
            $this->writeOne();
        } else {
            //перезаписываем массив
            $this->rewriteAll();
        }
        return true;
    }


}