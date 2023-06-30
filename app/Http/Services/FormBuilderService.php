<?php

namespace App\Http\Services;

use App\Http\Repository\CustomQueryRepo;

class FormBuilderService
{

    public function __construct(CustomQueryRepo $customQueryRepo)
    {
        $this->customQueryRepo = $customQueryRepo;

    }

    public function store($data){
        return $this->customQueryRepo->store($data);
    }
    public function update($data,$id){
        return $this->customQueryRepo->update($data,$id);
    }
    public function verify($code,$email){
        return $this->customQueryRepo->verify($code,$email);

    }

    public function logicCode(){
        $code = rand(1000, 9999);
        $expirationTime = strtotime('+3 minutes');
        $expireDate = date('Y-m-d H:i:s', $expirationTime);
        return [$code,$expireDate];
    }
    public function send_code($email){
       $data = $this->logicCode();
        return $this->customQueryRepo->updateUser($data[0],$email,$data[1]);

    }

    public function show($id){
        return $this->customQueryRepo->show($id);
    }


    public function delete($id){
        return $this->customQueryRepo->delete($id);
    }

    public function publish_form($id){
        //to add expire data
        $data = $this->logicCode();
        return $this->customQueryRepo->publish_form($id,$data[0],$data[1]);

    }

}
