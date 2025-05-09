<?php

declare(strict_types = 1);

namespace App\Models;

use App\Trait\TenantModelTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    //
    use TenantModelTrait;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['tenant_id', 'name'];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
