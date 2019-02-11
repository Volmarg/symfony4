<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\UserSettings;

class UserConfig extends AbstractController {

    const DEFAULT_AVATAR = 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909__340.png';

    public function getAvatar() {

        $user = $this->getUser();
        $entity_manager = $this->getDoctrine()->getManager();
        $query_builder = $entity_manager->createQueryBuilder();
        $query_result = $query_builder->select(array('us'))
            ->from('App:UserSettings', 'us')
            ->where('us.user_id_id = ' . $user->getId())
            ->getQuery()
            ->getResult();

        if (!empty($query_result)) {
            $avatar = $query_result[0]->getAvatar();
            return (!empty($avatar) ? $avatar : self::DEFAULT_AVATAR);
        }

        return self::DEFAULT_AVATAR;
    }

}
