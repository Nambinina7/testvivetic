<?php

namespace App\Repository;

use App\Entity\Tasks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tasks>
 */
class TasksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tasks::class);
    }

    public function countTasksByStatus()
    {
        return $this->createQueryBuilder('t')
            ->select('t.status, COUNT(t.id) as task_count')
            ->groupBy('t.status')
            ->getQuery()
            ->getResult();
    }


    public function findOverdueTasks()
    {
        return $this->createQueryBuilder('t')
            ->where('t.endDate < :now')
            ->andWhere('t.status != :status')
            ->setParameter('now', new \DateTime())
            ->setParameter('status', 'terminé')
            ->getQuery()
            ->getResult();
    }

    // src/Repository/TaskRepository.php

    public function findStatsByUser()
    {
        return $this->createQueryBuilder('t')
            ->select('t.endDate, t.status, COUNT(t.id) as task_count')
            ->groupBy('t.endDate, t.status')
            ->getQuery()
            ->getResult();
    }

}
