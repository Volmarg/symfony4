<?php

namespace App\Service;

use App\Entity\Posts as EntityPosts;
use App\Entity\UserSettings;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Posts {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getPosts() {

        $posts = $this->em->getRepository(EntityPosts::class)->findAll();
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
        $user_settings = $this->em->getRepository(UserSettings::class)->findBy(['user_id_id' => $id])[0];
        return $user_settings->getAvatar();
    }

    protected function getUserId($id) {
        $user = $this->em->getRepository(User::class)->findBy(['uuid' => $id])[0];
        return $user->getId();
    }

}