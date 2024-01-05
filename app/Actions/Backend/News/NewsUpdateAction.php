<?php

namespace App\Actions\Backend\News;

use App\Actions\AbstractAction;
use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class NewsUpdateAction extends AbstractAction
{
    public News $news;
    public  $letterReplacements = [
        'Ə' => 'e',
        'ə' => 'e',
        'ü' => 'u',
        'ö' => 'o',
        'ş' => 's',
        'ç' => 'c',
        'ı' => 'i',
        'Ğ' => 'G',
    ];
    public function handle()
    {
        $model = $this->data['news'];
        $model->update([
            'order' => $this->check_param('order'),
            'action_date' =>  Carbon::parse($this->data['action_date'] . ' ' . $this->data['action_date_time']),
            'status' =>$this->check_param('status'),
            'news_type' =>$this->check_param('type') ,
            'video_url' =>$this->check_param('video_url'),
            'confirmed' =>$this->check_param('confirmed'),
            'for_free' =>$this->check_param('for_free'),
        ]);
        $model->categories()->sync($this->check_param('category_ids'));
        $model->options()->sync($this->check_param('option_ids'));
        foreach (Cache::get('active_langs') as $lang) {
            $model->translations()->updateOrcreate(
                ['locale' => $lang->code],
                [
                    'title' => $this->data['title:' . $lang->code] ??  null,
                    'sub_title' => $this->data['sub_title:' . $lang->code] ?? null ,
                    'description' => $this->data['description:' . $lang->code] ?? null ,
                    'slug' => $this->data['slug:' . $lang->code] ?? str_replace(array_keys($this->letterReplacements), array_values($this->letterReplacements), Str::slug($this->data['title:' . $lang->code] .'_'. $model->id .'_'. $lang->code)),
                ]
            );
        }
        Cache::delete('categories');
        Cache::delete('video_news');
        Cache::delete('fresh_news');
        Cache::delete('top_10_news');
        Cache::delete('main_news');
        $this->news = $model;
    }

    public function check_param($param)
    {
        return array_key_exists($param, $this->data) ? $this->data[$param] : $this->data['news']->$param;
    }
}
