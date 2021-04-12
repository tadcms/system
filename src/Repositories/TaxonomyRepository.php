<?php

namespace Tadcms\System\Repositories;

use Tadcms\System\Models\Taxonomy;
use Theanh\Lararepo\Repositories\EloquentRepository;

class TaxonomyRepository extends EloquentRepository
{
    public function model()
    {
        return Taxonomy::class;
    }
}