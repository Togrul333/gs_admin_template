<?php


namespace App\Utils\Filters\NewsFilter;

use App\Utils\Filters\FilterContract;

class Search implements FilterContract
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value = null): void
    {
        if ($value) {
            $this->query
                ->when(!is_array($value), function ($query) use ($value) {
                    $query->whereHas('translations', function ($query) use ($value) {
                        $query->where('title', 'like', "%$value%")
                            ->orWhere('description', 'like', "%$value%");
                    });
                });
        }
    }
}
