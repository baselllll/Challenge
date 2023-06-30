<?php

namespace App\Http\Services;

use App\Http\Repository\CustomQueryRepo;

class AuthService
{

    public function __construct(CustomQueryRepo $customQueryRepo)
    {
        $this->customQueryRepo = $customQueryRepo;

    }

    public function login($email){
        return $this->customQueryRepo->login($email);

    }
    public function register($data){
        return $this->customQueryRepo->register($data);
    }
    public function verify($code,$email){
        return $this->customQueryRepo->verify($code,$email);

    }
    public function send_code($email){
        $code = rand(1000, 9999);
        $expirationTime = strtotime('+3 minutes');
        $expireDate = date('Y-m-d H:i:s', $expirationTime);
        return $this->customQueryRepo->updateUser($code,$email,$expireDate);

    }

}
