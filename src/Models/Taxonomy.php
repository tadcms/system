<?php

namespace Tadcms\System\Models;

use Illuminate\Database\Eloquent\Model;
use Tadcms\System\Traits\UserModifyAble;

/**
 * Tadcms\System\Models\Taxonomy
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy query()
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Taxonomy whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Taxonomy extends Model
{
    use UserModifyAble;
    
    protected $table = 'taxonomies';
    protected $fillable = [
        'name',
        'description',
        'type',
        'thumbnail',
        'taxonomy',
        'parent_id',
    ];
    
    public function parent()
    {
        return $this->belongsTo(Taxonomy::class, 'parent_id', 'id');
    }
    
    public function childrens()
    {
        return $this->hasMany(Taxonomy::class, 'parent_id', 'id');
    }
    
    public function posts()
    {
        return $this->morphedByMany('Tadcms\System\Models\Post', 'post', 'post_taxonomies');
    }
}
