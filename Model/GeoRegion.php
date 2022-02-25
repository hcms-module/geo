<?php

declare (strict_types=1);

namespace App\Application\Geo\Model;

use Hyperf\Database\Model\Relations\HasMany;
use Hyperf\DbConnection\Model\Model;

/**
 * @property int    $id
 * @property int    $code
 * @property int    $p_code
 * @property string $region_name
 * @property int    $level
 */
class GeoRegion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'geo_region';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'code' => 'integer', 'p_code' => 'integer', 'level' => 'integer'];

    function children(): HasMany
    {
        return $this->hasMany(self::class, 'p_code', 'code');
    }
}