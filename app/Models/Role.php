<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    /**
     * Get all of the users for the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    protected $fillable = ['id','name',];
    
    public function users(){
        return $this->hasMany(User::class);
    }
    public function hasRole($role):bool
    {
        return $this->name == $role;
    }
}
