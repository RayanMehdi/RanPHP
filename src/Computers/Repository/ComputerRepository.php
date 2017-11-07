<?php

namespace App\Computers\Repository;

use App\Computers\Entity\Computer;
use Doctrine\DBAL\Connection;

/**
 * User repository.
 */
class ComputerRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

   /**
    * Returns a collection of Computers.
    *
    * @param int $limit
    *   The number of Computers to return.
    * @param int $offset
    *   The number of Computers to skip.
    * @param array $orderBy
    *   Optionally, the order by info, in the $column => $direction format.
    *
    * @return array A collection of Computers, keyed by user id.
    */
   public function getAll()
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('c.*')
           ->from('computers', 'c');

       $statement = $queryBuilder->execute();
       $computersData = $statement->fetchAll();
       $computerEntityList = null;
       foreach ($computersData as $computerData) {
           $computerEntityList[$computerData['id']] = new Computer($computerData['id'], $computerData['marque'], $computerData['prix'], $computerData['idUser']);
       }

       return $computerEntityList;
   }

   /**
    * Returns an User object.
    *
    * @param $id
    *   The id of the user to return.
    *
    * @return array A collection of Computers, keyed by user id.
    */
   public function getById($id)
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('c.*')
           ->from('computers', 'c')
           ->where('id = ?')
           ->setParameter(0, $id);
       $statement = $queryBuilder->execute();
       $computerData = $statement->fetchAll();

       return new Computer($computerData[0]['id'], $computerData[0]['marque'], $computerData[0]['prix'], $computerData[0]['idUser']);
   }

   public function getByUserId($userId)
   {
       $queryBuilder = $this->db->createQueryBuilder();
       $queryBuilder
           ->select('c.*')
           ->from('computers', 'c')
           ->where('idUser = ?')
           ->setParameter(0, $userId);
       $statement = $queryBuilder->execute();

       $computersData = $statement->fetchAll();
       $computerEntityList = null;
       foreach ($computersData as $computerData) {
           $computerEntityList[$computerData['id']] = new Computer($computerData['id'], $computerData['marque'], $computerData['prix'], $computerData['idUser']);
       }

       return $computerEntityList;

   }

    public function delete($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->delete('computers')
          ->where('id = :id')
          ->setParameter(':id', $id);

        $statement = $queryBuilder->execute();
    }

    public function update($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->update('computers')
          ->where('id = :id')
          ->setParameter(':id', $parameters['id']);

        if ($parameters['marque']) {
            $queryBuilder
              ->set('marque', ':marque')
              ->setParameter(':marque', $parameters['marque']);
        }

        if ($parameters['prix']) {
            $queryBuilder
            ->set('prix', ':prix')
            ->setParameter(':prix', $parameters['prix']);
        }
        if ($parameters['idUser']) {
            $queryBuilder
            ->set('idUser', ':idUser')
            ->setParameter(':idUser', $parameters['idUser']);
        }



        $statement = $queryBuilder->execute();
    }

    public function insert($parameters)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
          ->insert('computers')
          ->values(
              array(
                'marque' => ':marque',
                'prix' => ':prix',
                'idUser'=> ':idUser'

              )
          )
          ->setParameter(':marque', $parameters['marque'])
          ->setParameter(':prix', $parameters['prix'])
          ->setParameter(':idUser', $parameters['idUser']);


        $statement = $queryBuilder->execute();
    }
}
