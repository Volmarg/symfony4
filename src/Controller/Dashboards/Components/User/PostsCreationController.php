<?php

namespace App\Controller\Dashboards\Components\User;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;

class PostsCreationController extends AbstractController {

    /**
     * @Route("/posts/creation", name="posts_creation")
     */
    public function index() {

        $post_form = $this->buildPostsForm();

        return compact('post_form');
    }

    protected function buildPostsForm() {
        $post = new Posts();
        $post_form = $this->createFormBuilder($post)
            ->add('title', TextType::class, [
                'label' => 'Post title',
                'attr' => [
                    'class' => 'form-controll',
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => "Post content",
                'attr' => [
                    'class' => 'form-controll'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create new Post',
                'attr' => [
                    'class' => 'form-controll btn btn-lg btn-primary btn-block'
                ]
            ])->getForm();

        return $post_form;
    }

    public function savePost($form_data) {

        $date=new \DateTime('now');

        $post=new Posts();
        $post->setTitle($form_data['title']);
        $post->setText($form_data['text']);
        $post->setAuthor($this->getUser()->getUuid());
        $post->setCreateDate($date->format('D-M-Y'));
        $post->setModifyDate($date->format('D-M-Y'));

        $em=$this->getDoctrine()->getManager();
        $em->persist($post);
        $em->flush();
    }
}
