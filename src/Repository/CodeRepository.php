<?php

namespace App\Repository;

use App\Entity\Code;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

/**
 * @method Code|null find($id, $lockMode = null, $lockVersion = null)
 * @method Code|null findOneBy(array $criteria, array $orderBy = null)
 * @method Code[]    findAll()
 * @method Code[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Code::class);
    }

    public function insertRandomCode(string $routeFile, string $database)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "LOAD DATA INFILE '$routeFile' 
        INTO TABLE $database 
        FIELDS TERMINATED BY ',' 
        ENCLOSED BY '\"'
        LINES TERMINATED BY '\\n'
        IGNORE 1 ROWS";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}
