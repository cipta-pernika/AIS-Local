<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Two\User;

class KeycloakUser extends User
{

    public $idToken;

    public function setIdToken($idToken)
    {
        $this->idToken = $idToken;

        return $this;
    }

    public function getIdToken()
    {
        return $this->idToken;
    }
}
