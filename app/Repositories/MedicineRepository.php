<?php

namespace Repositories;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class MedicineRepository extends EntityRepository
{
  public function myfindOne(Request $request)
  {
    $requestUri = substr(
      $request->getRequestUri(),
      strpos($request->getRequestUri(), '?') + 1
    );

    parse_str($requestUri, $searchParams);

    $qb = $this->createQueryBuilder('m');

    $qb->where('1=1');

    if(isset($searchParams['query'])){
      $qb
        ->andWhere(' m.name LIKE :name ')
        ->setParameter('name', $searchParams['query'].'%');
    }



      $qb
        ->orderBy('m.name', 'ASC')
        ->setFirstResult(0)
        ->setMaxResults(15);
      
     return new Paginator( $qb->getQuery());
    
  }
  
}