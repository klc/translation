<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translation
 *
 * @property integer id
 * @property integer language_id
 * @property string slug
 * @property string translation
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @mixin Builder
 */
class Translation extends Model
{
    use HasFactory;

    protected $table = 'translations';
    protected $fillable = ['language_id', 'slug', 'translation'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
