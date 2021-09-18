<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Language
 *
 * @property integer id
 * @property string name
 * @property string code
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @mixin Builder
 */
class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $fillable = ['name', 'code'];

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
