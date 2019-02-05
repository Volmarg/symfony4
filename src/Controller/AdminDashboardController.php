<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController {
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index() {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin_dashboard/index.html.twig', [
            'controller_name' => 'AdminDashboardController',
        ]);


    }
}
