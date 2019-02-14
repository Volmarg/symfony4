<?php

namespace App\Controller\Dashboards\Components\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\UserSettings;

class UsersDashletController extends AbstractController {
    /**
     * @Route("/dashboards/components/admin/users/dashlet", name="dashboards_components_admin_users_dashlet")
     */

    public function getUsers() {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('App\Entity\User')->findAll();
    }

    public function removeUser($user_uuid) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($user_uuid);

        //foreign key first
        $user_settings = $em->getRepository(UserSettings::class)->findOneBy(['user_id_id' => $user->getId()]);
        if (!is_null($user_settings)) {
            $em->remove($user_settings);
            $em->flush();
        }

        if (!is_null($user)) {
            $em->remove($user);
            $em->flush();
        }

        return 'User removed';
    }

    public function changeRole($new_role, $user_id) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($user_id);
        $user->setRoles([$new_role]);
        $em->persist($user);
        $em->flush();

        return 'Use Role was changed';
    }
}
