<?php

namespace App\Computers\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class IndexController
{
    public function listAction(Request $request, Application $app)
    {
        $computers = $app['repository.computer']->getAll();

        return $app['twig']->render('computers.list.html.twig', array('computers' => $computers));
    }

    public function deleteAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $app['repository.computer']->delete($parameters['id']);

        return $app->redirect($app['url_generator']->generate('computers.list'));
    }

    public function editAction(Request $request, Application $app)
    {
        $parameters = $request->attributes->all();
        $computer = $app['repository.computer']->getById($parameters['id']);
        $users = $app['repository.user']->getAll();

        return $app['twig']->render('computers.form.html.twig', array('computer' => $computer, 'users' => $users));
    }

    public function saveAction(Request $request, Application $app)
    {
        $parameters = $request->request->all();
        if ($parameters['id']) {
            $computer = $app['repository.computer']->update($parameters);
        } else {
            $computer = $app['repository.computer']->insert($parameters);
        }

        return $app->redirect($app['url_generator']->generate('computers.list'));
    }

    public function newAction(Request $request, Application $app)
    {
      $users = $app['repository.user']->getAll();
        return $app['twig']->render('computers.form.html.twig', array('users' => $users ));
    }
}
