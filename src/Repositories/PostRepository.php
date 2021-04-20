<?php

namespace Tadcms\System\Repositories;

use Illuminate\Support\Arr;
use Tadcms\System\Models\Post;
use Theanh\Lararepo\Repositories\EloquentRepository;

class PostRepository extends EloquentRepository
{
    public function model()
    {
        return Post::class;
    }
    
    public function getConfig($postType)
    {
        $types = apply_filters('post_types', []);
        return collect(Arr::get($types, $postType, []));
    }
    
    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $taxonomies = $attributes['taxonomies'] ?? [];
        $model->taxonomies()->sync(
            $this->combinePivot($taxonomies, [
                'term_type' => 'post-type'
            ])
        );
    }
    
    public function update($id, array $attributes)
    {
        $model = parent::update($id, $attributes);
        $taxonomies = $attributes['taxonomies'] ?? [];
        $model->taxonomies()->sync(
            $this->combinePivot($taxonomies, [
                'term_type' => 'post-type'
            ])
        );
    }
    
    /**
     * Create pivot array from given values
     *
     * @param array $entities
     * @param array $pivots
     * @return array combined $pivots
     */
    protected function combinePivot($entities, $pivots = [])
    {
        // Set array
        $pivotArray = [];
        // Loop through all pivot attributes
        foreach ($pivots as $pivot => $value) {
            // Combine them to pivot array
            $pivotArray += [$pivot => $value];
        }
        // Get the total of arrays we need to fill
        $total = count($entities);
        // Make filler array
        $filler = array_fill(0, $total, $pivotArray);
        // Combine and return filler pivot array with data
        return array_combine($entities, $filler);
    }
}