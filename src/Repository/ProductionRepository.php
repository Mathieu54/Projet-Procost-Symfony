<?php

namespace App\Repository;

use App\Entity\Production;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Production|null find($id, $lockMode = null, $lockVersion = null)
 * @method Production|null findOneBy(array $criteria, array $orderBy = null)
 * @method Production[]    findAll()
 * @method Production[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Production::class);
    }

    // /**
    //  * @return Production[] Returns an array of Production objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Production
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function temps_production_list()
    {
        $rawSql = "SELECT proj.projet_id, e.id, e.nom, e.prenom, p.nom as nom_projet, pro.time_production, pro.date_ajout FROM employe e, projet p, production pro, production_projet proj, production_employe proe WHERE pro.id = proe.production_id AND proe.employe_id = e.id AND proe.production_id = proj.production_id AND proj.projet_id = p.id GROUP BY pro.time_production ORDER BY pro.date_ajout DESC LIMIT 8;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }

    public function total_production() {
        return $this->createQueryBuilder('p')
            ->select('SUM (p.time_production)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function production_profil($id)
    {
        $rawSql = " SELECT e.cout_horaire * pro.time_production AS cout_total, e.cout_horaire, p.nom as nom_projet, pro.time_production, pro.date_ajout FROM employe e, projet p, production pro, production_projet proj, production_employe proe WHERE pro.id = proe.production_id AND proe.employe_id = e.id AND proe.production_id = proj.production_id AND proj.projet_id = p.id AND e.id =" . $id . " ORDER BY pro.date_ajout DESC;";
        $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        $stmt->execute([]);
        return $stmt->fetchAll();
    }
}
