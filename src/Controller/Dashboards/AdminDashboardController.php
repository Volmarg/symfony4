<?php

namespace App\Controller\Dashboards;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Dashboards\Components\Admin\UsersDashletController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminDashboardController extends AbstractController {

    private $new_role = '';
    private $user_id = '';

    public function __construct() {
        $this->new_role = filter_input(INPUT_GET, 'role', FILTER_DEFAULT) ?? null;
        $this->user_id = filter_input(INPUT_GET, 'user_id', FILTER_DEFAULT) ?? null;
    }

    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index($action = null, UsersDashletController $users_dashlet_ctrl) {

        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $all_users = $users_dashlet_ctrl->getUsers();

        if (!is_null($action)) {
            $action_result = $this->pickUsersDashletAction($action, $users_dashlet_ctrl);
            $message = json_encode(['message' => $action_result]);
            return new Response($message, 200, [
                'Content-Type' => 'application/json'
            ]);
        }

        return $this->render('dashboards/admin_dashboard/index.html.twig', [
            'all_users' => $all_users,
        ]);
    }

    protected function pickUsersDashletAction($action, $users_dashlet_ctrl) {
        $action_result = 'Your request could not been handled';

        if (is_null($this->user_id)) return $action_result;

        switch ($action) {
            case 'changeRole':
                if (!is_null($this->new_role)) $action_result = $users_dashlet_ctrl->changeRole($this->new_role, $this->user_id);
                break;
            case
            'removeUser':
                $action_result = $users_dashlet_ctrl->removeUser($this->user_id);
                break;
        }
        return $action_result;
    }
}
