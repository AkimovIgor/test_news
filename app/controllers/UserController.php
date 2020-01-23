<?php

namespace App\Controllers;

use App\Models\Users;
use Igoframework\Core\Base\View;

class UserController extends BaseController
{
    public function registerAction()
    {
        if (!empty($_POST)) {
            $user = new Users();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUniqueEmail()) {
                $user->getMiniErrors();
                $user->rememberFieldsData($data);
                redirect();
            }
            $user->attributes['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($user->attributes['password_confirmation']);
            if ($id = $user->save($user->attributes)) {
                unset($user->attributes['password']);
                $user->attributes['id'] = $id;
                $_SESSION['user'] = $user->attributes;
                $_SESSION['success'] = 'Вы успешно зарегистрированы!';
            } else {
                $_SESSION['errors'] = 'Ошибка регистрации!';
            }
            redirect('/');
        }
        View::setMeta('Регистрация');
    }

    public function loginAction()
    {
        if (! empty($_POST)) {
            $user = new Users();
            $data = $_POST;
            if ($user->login($data)) {
                $_SESSION['success'] = 'Авторизация прошла успешно';
                redirect('/');
            } else {
                if (! isset($_SESSION['errors'])) {
                    $_SESSION['errors'] = 'Неверный логин/пароль';
                }
            }
            redirect();
        }
        View::setMeta('Авторизация');
    }

    public function logoutAction()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        } elseif (isset($_COOKIE['user'])) {
            setcookie('user', '', time() - 5);
        }
        redirect('/');
    }

    public function profileAction()
    {
        if (isset($_SESSION['user']) || isset($_COOKIE['user'])) {
            $currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : $_COOKIE['user'];
            if (!empty($_POST)) {
                $user = new Users();
                $data = $_POST;
                if (isset($data['edit'])) {
                    if ($user->changeProfile($data, $currentUser)) {
                        $_SESSION['success'] = 'Профиль успешно обновлен';
                        $currentUser = isset($_SESSION['user']) ? $_SESSION['user'] : $_COOKIE['user'];
                    } else {
                        $user->getMiniErrors();
                    }
                } elseif (isset($data['edit-passw'])) {
                    if ($user->changePassword($data, $currentUser)) {
                        $_SESSION['success'] = 'Пароль успешно изменен';
                    } else {
                        $user->getMiniErrors();
                        $user->rememberFieldsData($data);
                    }
                }
                redirect();
            }
            $this->setVars(compact('currentUser'));
        } else {
            redirect('/');
        }
        
        View::setMeta('Профиль');
    }
}