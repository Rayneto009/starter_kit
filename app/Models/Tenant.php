<?php

declare(strict_types = 1);

namespace App\Models;

//use App\Trait\TenantScopeTrait;

use App\Trait\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Auth;

class Tenant extends Model implements Auditable
{
    
    use UuidTrait;
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'cnpj',
        'email',
        'uuid',
    ];

    protected static function booted()
    {
        static::addGlobalScope('tenant', function ($query) {
            if (Auth::check() && Auth::user()->tenant_id && session('tenant')) {
                $query->where('id', session('tenant.id'));
            }
        });
    }

    /**
     * Obtém todos os usuários pertencentes a este inquilino (tenant).
     * Este método estabelece um relacionamento um-para-muitos onde:
     * - Um inquilino pode ter múltiplos usuários
     * - Cada usuário pertence a um inquilino
     * - A chave estrangeira 'tenant_id' na tabela users referencia este inquilino
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
