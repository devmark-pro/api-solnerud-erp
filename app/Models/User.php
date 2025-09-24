<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Directory\EmployeePositionDirectory;
use App\Models\Directory\EmployeeStatusDirectory;
use App\Models\Warehouse;



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'surname',
        'patronymic',  // отчество
        'phone',
        'employee_position_id',
        'employment_date',
        'employee_status_id',
        'city',
        'deleted_at'
    ];

    protected $appends = [ 
        'is_password',     // Пароль задан 
        'warehouse',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employeePosition():BelongsTo 
    {
        return $this->belongsTo(EmployeePositionDirectory::class);
    }

    public function employeeStatus():BelongsTo 
    {
        return $this->belongsTo(EmployeeStatusDirectory::class);
    }
    public function user():BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
    
    public function getIsPasswordAttribute() 
    {
        return !!$this->password;
    }
    public function getWarehouseAttribute() 
    {
        return  Warehouse::where('user_id', $this->id)->first();
    }
    
    
}
