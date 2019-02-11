<?php

namespace App\Controller\Dashboards\Components\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostsCreationController extends AbstractController
{
    /**
     * @Route("/posts/creation", name="posts_creation")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostsCreationController.php',
        ]);
    }

    protected function buildPostsForm(){
    //$this->createFormBuilder($this)
    }
}
