<?php

namespace App\Controller\Dashboards\Components\User;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostCreationType;

class PostsCreationController extends AbstractController {

    /**
     * @Route("/posts/creation", name="posts_creation")
     */
    public function index() {

        $post_form = $this->createForm(PostCreationType::class, null);

        return compact('post_form');
    }

    public function savePost($form_data) {

        $date = new \DateTime('now');

        $post = new Posts();
        $post->setTitle($form_data['title']);
        $post->setText($form_data['text']);
        $post->setAuthor($this->getUser()->getUuid());
        $post->setCreateDate($date->format('D-M-Y'));
        $post->setModifyDate($date->format('D-M-Y'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
    }
}
