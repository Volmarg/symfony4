<?php

namespace App\Controller\Routes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Posts;
use App\Entity\UserSettings;
use App\Entity\User;

class HomePageController extends AbstractController {
    /**
     * @Route("/", name="home_page")
     */
    public function index() {
        $all_posts = $this->getPosts();

        return $this->render('routes/home_page/index.html.twig', [
            'all_posts' => $all_posts,
        ]);
    }

    protected function getPosts() {

        $posts = $this->getDoctrine()->getRepository(Posts::class)->findAll();
        $posts_clones = [];
        foreach ($posts as $id => $post) {
            $user_id = $this->getUserId($post->getAuthor());
            $avatar = $this->getUserAvatar($user_id);

            $post_clone = clone $post;
            $post_clone->avatar = $avatar;
            $posts_clones[] = $post_clone;
        }
        return $posts_clones;
    }

    protected function getUserAvatar($id) {
        $user_settings = $this->getDoctrine()->getRepository(UserSettings::class)->findBy(['user_id_id' => $id])[0];
        return $user_settings->getAvatar();
    }

    protected function getUserId($id) {
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(['uuid' => $id])[0];
        return $user->getId();
    }


}
