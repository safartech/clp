<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'email', 'password', 'role_id', 'online', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function logins(){
        return $this->hasMany('App\Login');
    }

    public function personnel(){
        return $this->belongsTo('App\Personnel');
    }

    public function responsable(){
        return $this->belongsTo('App\Responsable');
    }



    public function hasRole($role){
        return $this->role->name == $role;
    }

    public function isEnseignant(){
        return $this->role->name === "enseignant";
    }

    public function isResponsable(){
        return $this->role->name === "parent";
    }

    public function isVieScolaire(){
        return $this->role->name === "vie scolaire";
    }

    public function isAdmin(){
        return $this->role->name === "admin";
    }

    public function isEleve(){
        return $this->role->name === "eleve";
    }



    /*public function responsable(){
        return $this->hasOne('App\Responsable');
    }*/

    public function eleve(){
        return $this->hasOne('App\Eleve');
    }




}
