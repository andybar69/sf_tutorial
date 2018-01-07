<?php

namespace PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use PlatformBundle\Entity\Category;
/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends EntityRepository
{
    public function getAdvertWithCategories(array $categoryNames)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.categories', 'cat')
            ->addSelect('cat')
            //->where('cat.name IN (' . implode(',',$categoryNames ). ' )')
        ;

       $qb->where($qb->expr()->in('cat.name', $categoryNames));

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }

    public function getItems($id)
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->select('a.id')
            ->leftJoin('a.categories', 'cat')
            ->addSelect('cat.id, cat.name')
            ->where('a.id = '.$id)
        ;

        //dump($qb->getQuery()->getSQL());

        $data = $qb
            ->getQuery()
            ->getResult();

        $output = [];
        if ($data) {
            foreach ($data as $categories) {
                $obj = new Category();
                $obj->setId($categories['id'])->setName($categories['name']);
                $output[] = $obj;
                unset($obj);
            }
        }

        return $output;
    }

    public function createUniqueSlug($slug)
    {
        //$slug = str_replace(array(" ", "-"), "_", $slug);
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.slug = :slug')
            ->setParameter('slug', $slug)
        ;
        $query = $queryBuilder->getQuery();
        $results = $query->getResult();
        if (!empty($results)) {
            return $slug . '_' . time();
        }
        return $slug;
    }

    public function myfindAll()
    {
        /*$queryBuilder = $this->_em->createQueryBuilder()->select('a')->from($this->_entityName, 'a')
            ->where('a.title = \'Mission de webmaster\'')
        ;*/

        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.title = \'Mission de webmaster\'')
        ;

        // On n'ajoute pas de critère ou tri particulier, la construction

        // de notre requête est finie


        // On récupère la Query à partir du QueryBuilder

        $query = $queryBuilder->getQuery();


        // On récupère les résultats à partir de la Query

        $results = $query->getResult();
        //var_dump($results);


        // On retourne ces résultats

        return $results;
    }
}
