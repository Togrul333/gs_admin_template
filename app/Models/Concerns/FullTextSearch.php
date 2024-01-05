<?php
namespace App\Models\Concerns;
 
use Illuminate\Database\Eloquent\Builder;

trait FullTextSearch
{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~', 'SELECT', 'FROM' ,'USERS','*','WHERE','NEWS','users','sum','having','UNION','MSysObjects','Type','NULL','from','Left[Name]','MSys','ORDER','In','BY','select','Table_Name','table_name','$','^','Users','DROP','TABLE','IF','ELSE','THEN','BEGIN','END','CASE','CONCAT','LOAD_FILE','ALL','1=1',"'",'"','#','GROUP BY','HAVING','insert into','SUBSTRING','EXEC','DECLARE','shutdown','script','alert','XSS','IN','BOOLEAN','UPDATE','update','DELETE','delete'];
        $term = str_replace($reservedSymbols, '', $term);
 
        $words = explode(' ', $term);
 
        foreach($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if(strlen($word) >= 3) {
                $words[$key] = '+' . $word . '*';
            }
        }
 
        $searchTerm = implode( ' ', $words);
 
        return $searchTerm;
    }
 
    /**
     * Scope a query that matches a full text search of term.
     *
     * @param Builder $query
     * @param string $term
     * @return Builder
     */
    public function scopeSearch($query, $term)
    {
        $columns = implode(',',$this->searchable);
 
        $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)" , $this->fullTextWildcards($term));
 
        return $query;
    }
}