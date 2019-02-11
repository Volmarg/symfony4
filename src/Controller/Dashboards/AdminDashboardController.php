<?php

namespace App\Controller\Dashboards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\UserSettings;

//TODO: add controller for user dashlet

class AdminDashboardController extends AbstractController {
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index() {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $all_users = $this->usersDashlet_getUsers();

        return $this->render('dashboards/admin_dashboard/index.html.twig', [
            'all_users' => $all_users,
        ]);
    }

    public function usersDashlet_getUsers() {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('App\Entity\User')->findAll();
    }

    public function usersDashlet_removeUser($user_uuid) {
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

        //BUG - this reinitiliazes view nicely but url is wrong
        return $this->index();
    }

    public function usersDashlet_changeRole($user_id) {
        $new_role = filter_input(INPUT_GET, 'role', FILTER_DEFAULT);
        //TODO: add get to private

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($user_id);
        $user->setRoles([$new_role]);
        $em->persist($user);
        $em->flush();

        //BUG - this reinitiliazes view nicely but url is wrong
        return $this->index();
    }
}
