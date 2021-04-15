<?php

declare(strict_types=1);

namespace App\Doctrine\DQL\Walkers;

use Doctrine\ORM\Query\SqlWalker;

class MysqlPaginationWalker extends SqlWalker
{
    public function walkSelectClause($selectClause)
    {
        $sql = parent::walkSelectClause($selectClause);
        
        if ($this->getQuery()->getHint('mysqlWalker.sqlCalcFoundRows') === true) {
            if ($selectClause->isDistinct) {
                $sql = $this->str_replace_once('SELECT DISTINCT', 'SELECT DISTINCT SQL_CALC_FOUND_ROWS', $sql);
            } else {
                $sql = $this->str_replace_once('SELECT', 'SELECT SQL_CALC_FOUND_ROWS', $sql);
            }
        }
        
        return $sql;
    }
    
    private function str_replace_once($search, $replace, $text)
    {
        $pos = strpos($text, $search);
        return $pos !== false ? substr_replace($text, $replace, $pos, strlen($search)) : $text;
    }
}