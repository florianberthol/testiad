<?php
namespace Controller;

use Core\Controller;
use Core\Request;
use Core\Session;
use Model\Message;
use Model\User;

class Chat extends Controller
{
    public function index(Session $session)
    {
        $this->checkLogin($session);
        $userModel = new User();
        $messageModel = new Message();

        $messages = $messageModel->getMessages();

        $error = [];
        $sessionError = $session->get('error');
        if (!empty($sessionError)) {
            $error[] = $sessionError;
            $session->delete('error');
        }

        $this->render('chat', [
            'username' => $session->get('user'),
            'messages' => $messages,
            'connectedUsers' => $userModel->getConnectedUser(),
            'errors' => $error
        ]);
    }

    public function post(Request $request, Session $session)
    {
        $this->checkLogin($session);
        $messageModel = new Message();
        $message = $request->getPost('message');
        if (!empty($message)) {
            $messageModel->insertMessage($request->getPost('message'), $session->get('id'));
        } else {
            $session->set('error', 'Le message ne peut pas être vide');
        }

        $this->redirect('/chat');
    }

    protected function checkLogin(Session $session)
    {
        if (!$session->get('name') || !$session->get('id')) {
            $this->redirect('/');
        }
    }
}