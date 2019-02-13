<?php

namespace App\Controller\Dashboards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Dashboards\Components\User\PostsCreationController;

class ProfileDashboardController extends AbstractController {
    /**
     * @Route("/profile/dashboard", name="profile_dashboard")
     */
    public function index() {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProfileDashboardController.php',
        ]);
    }
}
