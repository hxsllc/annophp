<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnotationItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "annotation_id",
        "body_type",
        "body_value",
        "item_id",
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

    public function annotation() {
        return $this->belongsTo(Annotation::class);
    }

    public function annotationItemSelectors() {
        return $this->hasMany(AnnotationItemSelector::class);
    }
}
