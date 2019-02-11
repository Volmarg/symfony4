<?php

namespace App\Controller\Dashboards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserDashboardController extends AbstractController
{
    /**
     * @Route("/user/dashboard", name="user_dashboard")
     */
    public function index()
    {
        return $this->render('dashboards/user_dashboard/index.html.twig', [
            'controller_name' => 'UserDashboardController',
        ]);
    }
}
