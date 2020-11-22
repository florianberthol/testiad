<?php
namespace Controller;

use Core\Controller;
use Core\Request;
use Core\Session;

class User extends Controller
{
    public function index(Request $request, Session $session)
    {
        if ($session->get('name') && $session->get('id')) {
            $this->redirect('/chat');
        } else {
            $this->render('login', ['request' => $request]);
        }
    }

    public function login(Request $request, Session $session)
    {
        $userModel = new \Model\User();
        $userName = $request->getPost('username');
        $password = $request->getPost('password');
        $errors = [];

        if (!empty($userName) && !empty($password)) {
            $user = $userModel->identifyUser(
                $userName,
                $password
            );
            if ($user) {
                $session->set('name', $user['name']);
                $session->set('id', $user['id']);
                $this->redirect('/chat');
            } else {
                $errors[] = 'Mot de passe incorecte';
            }
        } else {
            if (empty($userName)) {
                $errors[] = 'Le nom d\'utilisateur ne peut pas être vide';
            }
            if (empty($password)) {
                $errors[] = 'Le mot de passe ne peut pas être vide';
            }
        }

        $this->render('login', ['request' => $request, 'errors' => $errors]);
    }
}