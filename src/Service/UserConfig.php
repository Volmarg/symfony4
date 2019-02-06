<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\UserSettings;

class UserConfig extends AbstractController {

    private $default_avatar = 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909__340.png';

    public function getAvatar() {

        $user = $this->getUser();
        $entity_manager = $this->getDoctrine()->getManager();
        $query_builder = $entity_manager->createQueryBuilder();

        $user_config = $query_builder->select(array('us'))
            ->from('App:UserSettings', 'us')
            ->where('us.user_id_id = ' . $user->getId())
            ->getQuery()
            ->getResult()[0];
        $avatar = $user_config->getAvatar();

        if (isset($avatar) && !empty($avatar)) {
            return $avatar;
        }

        return $this->default_avatar;
    }


}
