<?php

namespace City\Search;


use \Charcoal\Search\AbstractSearch;

/**
 *
 */
class EventSearch extends AbstractSearch
{

    /**
     * @param string $keyword The search term.
     * @return array Search results
     */
    public function search($keyword)
    {
        $results = ['event '.$keyword];
        $this->setResults($results);
        return $results;
    }
}
