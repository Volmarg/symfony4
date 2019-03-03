<?php

namespace App\Repository;

use App\Entity\UserSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSettings[]    findAll()
 * @method UserSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSettingsRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, UserSettings::class);
    }

    public function getUserAvatar($user_id) {
        $user_settings = $this->getEntityManager()->getRepository(UserSettings::class)->findBy(['user_id_id' => $user_id])[0];
        return $user_settings->getAvatar();
    }

    public function getUserSettingsByUseId($user_id) {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $query_result = $qb->select(array('us'))
            ->from('App:UserSettings', 'us')
            ->where('us.user_id_id = ' . $user_id)
            ->getQuery()
            ->getResult();

        return $query_result;
    }


}
