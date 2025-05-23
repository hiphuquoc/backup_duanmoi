<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends BaseCategory {
    use HasFactory, Searchable;
    protected $table        = 'category_info';
    protected $fillable     = [
        'seo_id',
        'icon',
        'flag_show',
        'notes',
    ];
    public $timestamps = true;

    /* index dữ liệu SearchData */
    public function toSearchableArray() {
        $this->loadMissing(['seo', 'seos.infoSeo', 'tags.infoTag']);

        return [
            'id'                => $this->id,
            'title'         => $this->seo->title ?? '',
            'seos'              => $this->seos->pluck('infoSeo.title')->filter()->values()->toArray(),
            'tags'              => $this->tags->pluck('infoTag.seos.infoSeo.title')->filter()->values()->toArray(),
        ];
    }

    public static function listLanguageNotExists($params = null){
        $countLanguage  = count(config('language'));
        $result         = self::select('*')
                            ->with('seo', 'seos')
                            ->withCount('seos') // Đếm số lượng `seos` cho mỗi phần tử
                            ->orderBy('created_at', 'DESC')
                            ->having('seos_count', '<', $countLanguage) // Lọc các phần tử có `seos_count` < tổng ngôn ngữ
                            ->paginate($params['paginate']);
        return $result;
    }

    public static function insertItem($params){
        $id             = 0;
        if(!empty($params)){
            $model      = new Category();
            foreach($params as $key => $value) $model->{$key}  = $value;
            $model->save();
            $id         = $model->id;
        }
        return $id;
    }

    public static function updateItem($id, $params){
        $flag           = false;
        if(!empty($id)&&!empty($params)){
            $model      = self::find($id);
            foreach($params as $key => $value) $model->{$key}  = $value;
            $flag       = $model->update();
        }
        return $flag;
    }

    public function seo() {
        return $this->hasOne(\App\Models\Seo::class, 'id', 'seo_id');
    }

    public function seos() {
        return $this->hasMany(\App\Models\RelationSeoCategoryInfo::class, 'category_info_id', 'id');
    }

    public function files(){
        return $this->hasMany(\App\Models\SystemFile::class, 'attachment_id', 'id')->where('relation_table', 'category_info')->inRandomOrder();
    }

    public function tags(){
        return $this->hasMany(\App\Models\RelationCategoryInfoTagInfo::class, 'category_info_id', 'id');
    }

    public function thumnails(){
        return $this->hasMany(\App\Models\RelationCategoryThumnail::class, 'category_info_id', 'id')->orderBy('id', 'DESC');
    }
}
