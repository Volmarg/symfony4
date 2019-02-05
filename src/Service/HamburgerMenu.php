<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HamburgerMenu extends AbstractController {

    public function getElements() {
        $menu_elements = [
            [
                'role' => 'ROLE_ADMIN',
                'negate' => false,
                'type' => 'route',
                'url' => 'admin_dashboard',
                'name' => 'Admin'
            ],
            [
                'role' => 'IS_AUTHENTICATED_FULLY',
                'negate' => false,
                'type' => 'route',
                'url' => 'user_dashboard',
                'name' => 'Dashboard'
            ],
            [
                'role' => 'IS_AUTHENTICATED_FULLY',
                'negate' => false,
                'type' => 'href',
                'url' => '/logout',
                'name' => 'Logout'
            ],
            [
                'role' => 'IS_AUTHENTICATED_FULLY',
                'negate' => true,
                'type' => 'route',
                'url' => 'app_login',
                'name' => 'Register'
            ],
            [
                'role' => 'IS_AUTHENTICATED_FULLY',
                'negate' => true,
                'type' => 'route',
                'url' => 'app_login',
                'name' => 'Login'
            ],
        ];

        return $menu_elements;
    }


}
