<?php

class UloginUserIdentity implements IUserIdentity
{

    private $id;
    private $username;
    private $isAuthenticated = false;
    private $states = array();

    public function authenticate($uloginModel = null)
    {

        $user = User::find()->where([
            'identity' => $uloginModel->identity,
            'network' => $uloginModel->network,
        ])->one();


        if (null !== $user) {
            $this->id = $user->id;
            if ($user->full_name)
                $this->username = $user->full_name;
            elseif ($user->username)
                $this->username = $user->username;
        } else {
            $user = new User();
            $user->identity = $uloginModel->identity;
            $user->network = $uloginModel->network;
            $user->email = $uloginModel->email;
            $user->full_name = $uloginModel->full_name;
            $user->username = $uloginModel->full_name;
            $user->password = md5($uloginModel->identity);
            $user->create_at = date("Y-m-d H:i:s");

            $user->save();

            /*
              if(sizeof($user->erros)>0){
              return false;
              }
             * 
             */

            $this->id = $user->id;
            $this->name = $user->full_name;
        }
        $this->isAuthenticated = true;
        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIsAuthenticated()
    {
        return $this->isAuthenticated;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPersistentStates()
    {
        return $this->states;
    }

}
