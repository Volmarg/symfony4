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
            $user_id = $this->em->getRepository(User::class)->getUserIdByLogin($post->getAuthor());
            $avatar = $this->em->getRepository(UserSettings::class)->getUserAvatar($user_id);

            $post_clone = clone $post;
            $post_clone->avatar = $avatar;
            $posts_clones[] = $post_clone;
        }
        return $posts_clones;
    }


}