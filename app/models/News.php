<?php

namespace App\Models;

use Igoframework\Core\Base\Model;

class News extends Model
{
    protected $table = 'news';
    
    public $attributes = [
        'date' => '',
        'title' => '',
        'image' => '',
        'anonce' => '',
        'text' => '',
    ];

    public $rules = [
        'required' => [
            ['title'],
            ['anonce'],
            ['text'],
        ],
        'date' => [
            ['date']
        ],
        'lengthMax' => [
            ['title', 255],
            ['anonce', 200],
            ['text', 10000],
        ],
    ];

    /**
     * Добавить изображение
     *
     * @param array $file Массив $_FILES
     *
     * @return bool
     */
    public function addImage($file)
    {
        if ($file['image']['error'] < 1) {
            $uploadDir = WWW . '/images/';
            $availableExt = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $fileName;
            if (in_array($extension, $availableExt)) {
                $this->uploadFile($file['image'], $uploadDir, $file['image']['name'], $uploadFile);
                $this->attributes['image'] = $fileName;
                return true;
            } else {
                $this->errors['image'][] = "Недопустимый формат файла. Допустимые форматы: " . implode(',', $availableExt);
            }
        }
        return false;
    }

    /**
     * Удалить изображение
     *
     * @param array $item Массив данных записи из БД
     *
     * @return void
     */
    public function deleteImage($item)
    {

        $dir = WWW . '/images/';
        if (file_exists($dir . $item['image']) && is_file($dir . $item['image'])) {
            unlink($dir . $item['image']);
        }
    }
}