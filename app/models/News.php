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

    public function addImage($data)
    {
        if ($data['image']['error'] < 1) {
            $uploadDir = WWW . '/images/';
            $availableExt = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($data['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $fileName;
            if (in_array($extension, $availableExt)) {
                $this->uploadFile($data['image'], $uploadDir, $data['image']['name'], $uploadFile);
                $this->attributes['image'] = $fileName;
                return true;
            } else {
                $this->errors['image'][] = "Недопустимый формат файла. Допустимые форматы: " . implode(',', $availableExt);
            }
        }
        return false;
    }

    public function deleteImage($item)
    {

        $dir = WWW . '/images/';
        if (file_exists($dir . $item['image']) && is_file($dir . $item['image'])) {
            unlink($dir . $item['image']);
        }
    }
}