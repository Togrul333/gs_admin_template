<?php

namespace App\Services;

use App\Actions\Backend\News\NewsCreateAction;
use App\Actions\Backend\News\NewsUpdateAction;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsService
{
    public News $news;

    public function create(array $data)
    {
        try {
            DB::beginTransaction();
            $action = new NewsCreateAction();
            $action->setData($data)->handle();
            $this->news = $action->news;
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
    public function update(array $data)
    {
        try {
            DB::beginTransaction();
            $action = new NewsUpdateAction();
            $action->setData($data)->handle();
            $this->news = $action->news;
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \Exception($exception->getMessage());
        }
    }
}
