<?php
namespace controllers;
use models\User;

/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 24.06.17
 * Time: 20:15
 */
class Users extends \core\base\Controller
{
    public function authAction(){
        global $link;
        $this->layout = false;
        if(isset($_POST['login'])){
            $pass = inputControl(passHash($_POST['pass']));
            $login = inputControl($_POST['login']);
            $query = $link->query("SELECT login, status FROM users WHERE login ='".$login."' AND password = '".$pass."'");
            if (mysqli_num_rows($query) > 0) {
                $query = $query->fetch_array();
                $_SESSION['id'] = $query['login'];
                $_SESSION['status'] = $query['status'];
                $link->query("UPDATE users SET dateSignUp='".date('Y-m-d')."' WHERE login = '".$_SESSION['id']."'");
                header("location: /admin");
            }
            else {
                $_SESSION['error'] = "Неверно указан логин или пароль";
            }
        }
    }
    public function logoutAction(){
        session_destroy();
        header("location: /admin");
    }
    public function indexAction(){
        $this->usersListAction();
    }
    public function usersListAction(){
        $permission = array('main');
        accessControl($permission);

    }

    public function addUserAction(){
        $this->layout = false;

        $permission = array('main');
        accessControl($permission);

        $login = inputControl($_POST['user']['login']);
        if(User::getElementList('users', array('login'), "login = '$login'")){
            echo "Пользователь с логином $login уже существует";
        }
        else{
            $_POST['user']['password'] = inputControl(passHash($_POST['user']['password']));
            $_POST['user']['login'] = $login;

            if(User::save('users', $_POST['user'])){
                header("location:{$_SERVER['HTTP_REFERER']}");
            }
        }

    }

    public function deleteUserAction(){

        if(User::delete('users', $this->route['id'])){
            header("location:{$_SERVER['HTTP_REFERER']}");
        }
    }

    public function editUserAction(){

        if(isset($_POST['user']['password']) && strlen($_POST['user']['password']) > 0){
            $_POST['user']['password'] = inputControl(passHash($_POST['user']['password']));
        }
        else{
            $_POST['user']['password'] = User::getPropertyList('users', $_POST['user']['id'], array('password'))['password'];
        }
        $_POST['user']['login'] = inputControl($_POST['user']['login']);
        if(User::update('users', $_POST['user'])){
            header("location:{$_SERVER['HTTP_REFERER']}");

        }
    }
}