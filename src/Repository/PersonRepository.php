<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Random\RandomException;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * @throws RandomException
     */
    public function generateRandomPerson(): array
    {
        $offset = random_int(0, count($this->findAll()) - 1);

        return $this->createQueryBuilder('p')
            ->setFirstResult($offset)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }
}
