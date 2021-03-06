<?php

namespace App\Controller\Dashboards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Controller\Dashboards\Components\User\PostsCreationController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\PostCreationType;

class UserDashboardController extends AbstractController {

    private $post_ctrl = '';

    public function __construct(PostsCreationController $post_ctrl) {
        $this->post_ctrl = $post_ctrl;
    }

    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function index(Request $request) {
        $post_data = $request->request->get('post_creation');
        $post_form = $this->post_ctrl->index()['post_form'];
        $post_form->handleRequest($request);

        if ($post_form->isSubmitted() && $post_form->isValid()) {
            $this->post_ctrl->savePost($post_data);
        }

        return $this->render('dashboards/user_dashboard/index.html.twig', [
            'post_form' => $post_form->createView(),
        ]);
    }
}
