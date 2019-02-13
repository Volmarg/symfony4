<?php

namespace App\Controller\Routes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;

class HomePageController extends AbstractController {
    /**
     * @Route("/", name="home_page")
     */
    public function index() {
        $all_posts = $this->getPosts();

        return $this->render('routes/home_page/index.html.twig', [
            'all_posts' => $all_posts
        ]);
    }

    public function getPosts() {
        return $this->getDoctrine()->getRepository(Posts::class)->findAll();
    }


}
