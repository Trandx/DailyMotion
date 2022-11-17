<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Admin\RoleTrait;


trait UserOperationTrait{

    use RoleTrait;
    use SessionTrait;

    // ici on va instacier le gestionnaire des session

    // version test mais pas terminé
    public static function user_id(){

        return ["user_id" => self::getUserIdApi()];
    }
    public static function updated_by(){

        return ["updated_by" => self::getUserIdApi()];
    }

    public static function created_by(){

        return ["created_by" => self::getUserIdApi()];
    }

    public static function save_by(){

        return ["updated_by" => self::getUserIdApi(), "created_by" => self::getUserIdApi()];
    }
/**
 * @ function to get parent diffusor
 * @ return parent diffusor id
 * @ param $id = if of diffusor
 * @param $col = specific column name that we want to update
 */
    public static function userParentId($dif_id, $col = 'user_id'){

         $id = self::getUserIdApi(); // on va remplacer par l'id de l'utilisateur présent dans la session

        $statusRole = self::roleSpace($dif_id, $id);

        // regarder l'état du compte

       /* $parent = User::with(['allMyspace' =>function($q) use ($dif_id){
            $q->where('diffuser_id', $dif_id);
        }, ])->where('id',$id);;*/

        //die(var_dump($statusRole));

        if(!$statusRole[0]){

           return $statusRole;

        }

        return [$col => $id];
    }
}

