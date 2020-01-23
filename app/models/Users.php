<?php

namespace App\Models;

use Igoframework\Core\Base\Model;

class Users extends Model
{
    protected $table = 'users';

    public $attributes = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'image' => 'no-user.jpg',
    ];

    public $rules = [
        'required' => [
            ['name'],
            ['email'],
            ['password'],
            ['password_confirmation'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            ['name', 3],
            ['password', 6],
        ],
        'lengthMax' => [
            ['name', 15],
            ['email', 40],
            ['password', 30],
        ],
        'equals' => [
            ['password', 'password_confirmation']
        ],
    ];

    public function checkUnique()
    {
        $user = $this->findOneWhere([
            'email' => $this->attributes['email'],
        ]);
        if ($user) {
            $currentEmail = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_COOKIE['user']['email'];
            if ($user['email'] == $this->attributes['email'] && $currentEmail != $user['email']) {
                $this->errors['email'][] = 'Такой email уже занят';
                return false;
            }
            
        }
        return true;
    }

    public function checkUniqueEmail()
    {
        $user = $this->findOneWhere([
            'email' => $this->attributes['email'],
        ]);
        if ($user) {
            if ($user['email'] == $this->attributes['email']) {
                $this->errors['email'][] = 'Такой email уже занят';
                return false;
            }
            
        }
        return true;
    }

    public function login($data)
    {
        $this->rules = [
            'required' => [
                ['email'],
                ['password']
            ],
            'email' => [
                ['email'],
            ],
        ];

        $this->load($data);

        $email = isset($this->attributes['email']) ? $this->attributes['email'] : null;
        $password = isset($this->attributes['password']) ? $this->attributes['password'] : null;
        $remember = isset($data['remember']);

        if ($email && $password) {
            $user = $this->findOneWhere(['email' => $this->attributes['email']]);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    foreach ($user as $key => $value) {
                        if ($key != 'password') {
                            if (! $remember) {
                                $_SESSION['user'][$key] = $value;
                            } else {
                                setcookie("user[$key]", $value, time() + 15, '/');
                            }
                        } 
                    }
                    return true;
                }
            }
        } else {
            if (!$this->validate(['email' => $email, 'password' => $password])) {
                $this->rememberFieldsData($data);
                $this->getMiniErrors();
            }
        }
        return false;
    }

    public function changeProfile($data, $currentUser)
    {
        $this->attributes = [
            'name' => '',
            'email' => '',
            'image' => 'no-user.jpg',
        ];

        $this->rules = [
            'email' => [
                ['email'],
            ],
            'lengthMin' => [
                ['name', 3],
            ],
            'lengthMax' => [
                ['name', 15],
                ['email', 40],
            ],
        ];

        unset($data['edit']);
        $data['name'] = !empty($data['name']) ? $data['name'] : $currentUser['name'];
        $data['email'] = !empty($data['email']) ? $data['email'] : $currentUser['email'];
        $data['image'] = !empty($data['image']) ? $data['image'] : $currentUser['image'];
        if ($_FILES['file']['error'] < 1) {
            $uploadDir = WWW . '/images/';
            $availableExt = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $extension;
            $uploadFile = $uploadDir . $fileName;
            if (in_array($extension, $availableExt)) {
                $userData = $this->findOne($currentUser['email'], 'email');
                $this->uploadFile($_FILES['file'], $uploadDir, $userData['image'], $uploadFile);
                $data['image'] = $fileName;
            } else {
                $this->errors['file'][] = "Недопустимый формат файла. Допустимые форматы: " . implode(',', $availableExt);
            }
        }
        $this->load($data);
        if (!empty($this->errors) || !$this->validate($data) || !$this->checkUnique()) {
            return false;
        }
        $this->update($this->attributes, $currentUser['id']);
        $user = $this->findOne($this->attributes['email'], 'email');
        foreach ($user as $key => $value) {
            if ($key != 'password')  {
                if (isset($_SESSION['user'])) {
                    $_SESSION['user'][$key] = $value;
                } else {
                    setcookie("user[$key]", $value, time() + 15, '/');
                }
            }
        }
        return true;
    }

    public function changePassword($data, $currentUser)
    {
        $this->attributes = [
            'current' => '',
            'new_password' => '',
            'new_password_confirmation' => '',
        ];

        $this->rules = [
            'required' => [
                ['current'],
                ['new_password'],
                ['new_password_confirmation'],
            ],
            'equals' => [
                ['new_password', 'new_password_confirmation']
            ],
            'lengthMin' => [
                ['new_password', 6],
            ],
            'lengthMax' => [
                ['new_password', 30],
            ],
        ];

        unset($data['edit-passw']);
        $this->load($data);
        if (! empty($data['current']) && ! empty($data['new_password']) && ! empty($data['new_password_confirmation'])) {
            $user = $this->findOne($currentUser['email'], 'email');
            if (! password_verify($data['current'], $user['password'])) {
                $this->errors['current'][] = "Неверный текущий пароль";
            }
        }
        if (!empty($this->errors) || !$this->validate($data)) {
            return false;
        }
        $newPassword = password_hash($this->attributes['new_password'], PASSWORD_DEFAULT);
        $this->update(['password' => $newPassword], $currentUser['email'], 'email');
        return true;
    }

    public static function isAdmin()
    {
        if ((isset($_SESSION['user']) && $_SESSION['user']['name'] == 'admin') || (isset($_COOKIE['user']) && $_COOKIE['user']['name'] == 'admin')) {
            return true;
        }
        return false;
    }
}