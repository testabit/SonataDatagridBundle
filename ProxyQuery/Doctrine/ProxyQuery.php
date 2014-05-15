<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * (c) Jonathan H. Wage <jonwage@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\DatagridBundle\ProxyQuery\Doctrine;

use Doctrine\ORM\Query;
use Sonata\DatagridBundle\ProxyQuery\BaseProxyQuery;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;

/**
 * Class ProxyQuery
 *
 * This is the Doctrine proxy query class
 */
class ProxyQuery extends BaseProxyQuery implements ProxyQueryInterface
{
    /**
     * {@inheritdoc}
     */
    public function execute(array $params = array(), $hydrationMode = null)
    {
        $query = $this->queryBuilder->getQuery();

        // Sorted field and sort order
        $sortBy = $this->getSortBy();
        $sortOrder = $this->getSortOrder();

        if ($sortBy && $sortOrder) {
            $sortBy = sprintf('%s.%s', $query->getRootAlias(), $sortBy);
            $query->orderBy($sortBy, $sortOrder);
        }

        // Limit & offset
        $query->setFirstResult($this->getFirstResult());
        $query->setMaxResults($this->getMaxResults());

        return $query->execute();
    }
}
