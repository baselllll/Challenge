<?php

namespace App\Http\Repository;

use App\Models\FormBuilder;
use App\Models\User;

class CustomQueryRepo
{
    public function __construct(User $user , FormBuilder $formBuilder)
    {
        $this->user= $user;
        $this->formBuilder= $formBuilder;
    }

    public function login($email){
        return $this->user->where('email',$email)->exists();
    }
    public function register($data){
        return $this->user->create($data);
    }
    public function verify($code,$email){

        $user =  $this->user->where('email',$email)->where('verification_code',$code)->first();
        $currentDate = date('Y-m-d H:i:s');
        $expireDate = $user->code_expire;

        if (strtotime($currentDate) < strtotime($expireDate)) {
            return "The current date is before the expiration date.";
        } else {
            return "The current date has passed the expiration date.";
        }
    }
    public function updateUser($code,$email,$expireDate){
        return $this->user->where('email',$email)->update(['verification_code'=>$code,'code_expire'=>$expireDate]);
    }
    public function publish_form($id,$code,$expireDate){
        return $this->formBuilder->find($id)->update(['form_code'=>$code,'form_code_expire'=>$expireDate]);
    }


    //form builder query

    public function store($data){
        $count = 1;
        foreach ($data['Details'] as &$item) {
            $item["id"] = $count++;
        }
        $data['Details'] = json_encode($data['Details']);
        return $this->formBuilder->create($data);
    }
    public function update($data,$id){
        $data['Details'] = json_encode($data['Details']);
        return $this->formBuilder->find($id)->update($data);
    }

    public function show($id){
        return $this->formBuilder->with('users')->find($id);
    }

    public function delete($id){
        return $this->formBuilder->find($id)->delete();
    }
}
