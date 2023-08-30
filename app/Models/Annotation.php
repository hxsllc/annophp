<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Annotation extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "annotation_page_id",
        "item_id",
        "creator_id",
        "creator_name",
        "creator_type",
        "motivation",
        "type"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function annotationSelectors()
    {
        return $this->hasMany(AnnotationSelector::class);
    }

    public function annotationBodies()
    {
        return $this->hasMany(AnnotationBody::class);
    }
}