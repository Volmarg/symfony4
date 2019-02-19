<?php

namespace App\Controller\Routes;

use App\Service\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController {
    /**
     * @Route("/", name="home_page")
     */
    public function index(Posts $posts) {

        $all_posts = $posts->getPosts();

        return $this->render('routes/home_page/index.html.twig', [
            'all_posts' => $all_posts,
        ]);
    }


}
