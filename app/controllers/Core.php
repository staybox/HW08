<?php

namespace Acme\Controllers;

use Acme\Models\Database;

class Core
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function run()
    {
        //Получение всех товаров
        if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['REQUEST_URI'] == "/orders") {
            $this->getAll();
            return;
        }

        //Открытие страницы формы, чтобы отправить POST
        if ($_SERVER['REQUEST_URI'] == "/order/add") {
            $this->openPostPage();
            return;
        }

        //просмотр одного товара
        if ($_SERVER['REQUEST_METHOD'] == "GET" && !empty($_GET['id'])) {
            $this->getOne($_GET['id']);
            return;
        }

        //создание товара
        if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['name'])) {
            $this->create($_POST['name']);
            return;
        }

        //редактирование товара
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
            $uriParts = explode('?', $_SERVER['REQUEST_URI'], 2);
            $uri = 'http://' . $_SERVER['HTTP_HOST'] . $uriParts[0];
            $orders = 'http://' . $_SERVER['HTTP_HOST'] . "/orders";

            if ($uri == $orders && !empty($_REQUEST['id'] && !empty($_REQUEST['name']))) {
                $this->edit($_REQUEST['id'], $_REQUEST['name']);
                return;
            }
        }

        //удаление товара
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_SERVER['REQUEST_URI'] == "/order/delete" && !empty($_POST['id'])) {
            $this->delete($_POST['id']);
            return;
        }
    }

    // отрисовка страницы формы для отправки POST

    public function getAll()
    {
        $Model = new Database();
        $allOrders = $Model->getAllOrders();

        $this->view->render('getAll', ['return' => $allOrders]);
    }

    // Запрос в базу получения всех пользователей и отрисовка на странице

    public function openPostPage()
    {
        $this->view->render('post', []);
    }

    // Запрос в базу получения одного пользователей и отрисовка на странице

    public function getOne($orderId)
    {
        $Model = new Database();
        $oneOrder = $Model->getOneOrder($orderId);
        $json = json_encode($oneOrder);

        $this->view->render('getOne', ['return' => $json]);
    }

    // Запрос в базу для создания пользователя и редирект на страницу с формой (обновление страницы)
    public function create($name)
    {
        $Model = new Database();
        $createOrder = $Model->createOrder($name);

        if (!empty($createOrder)) {
            echo "Данные успешно записаны, сейчас страница обновится";
            return header("Refresh: 5; url:/orders/add");
        }
    }

    public function edit($id, $name)
    {
        $Model = new Database();
        $putOrder = $Model->modifyOrder($id, $name);
        if ($putOrder === null) {
            echo "Нет такого ID, и ничего не изменилось";
        } else {
            echo "Данные были изменены";
        }
    }

    public function delete($id)
    {
        $Model = new Database();
        $delOrder = $Model->deleteOrder($id);
        if ($delOrder === null) {
            echo "Нет такого ID, и ничего не изменилось";
        } else {
            echo "Данные были удалены";
        }
    }
}
