<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Auth\Admin\RoleTrait;
use App\Http\Controllers\NoApi\SearchTrait;
use App\Http\Controllers\NoApi\TimeTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemplateEmail;
use Illuminate\Support\Facades\Crypt;

/**
 *
 */
trait UserEmailTrait
{

    use RoleTrait;
    use TimeTrait;
    use UserOperationTrait;
    use SearchTrait;

    public $emailDatas = [];

   /*
   public function emailDatas(){

        return [

            "view" => 'emails.welcome',
            "nameFrom" => env('MAIL_FROM_NAME'),
            "from" => env('MAIL_FROM_NAME'),
            "nameTo" => env('MAIL_FROM_NAME'),
            "to" => env('MAIL_FROM_ADDRESS'),
            "replyTo" => '' ,
            "suject" => 'test sending email',
            "message" => 'send successfully',

        ];
    }
    */

    /**
     * Verify email
     *
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function verify(Request $request) {

        $data = $request->all();

       /* if (! $request->hasValidSignature()) {
            return $this->errorResponse("invalid", ['error' => 'invalid verification email url'], 404);
        }*/

       // $email = Crypt::decryptString($data['hash']);

        $email = $data['email'];
       // $token =  $data['token'];

        $user = User::where('email', $email)->where([["emailCodeVerify",$data['code']],
        ["emailCodeValidity",'>', now()]])->first();

        if($user){

            if (!$user->hasVerifiedEmail()) {

                $user->markEmailAsVerified();

                    $user->accountStatus= 'actived';
                    $user->save();

                //return redirect(route('ozstream.web.user.login'));

                return $this->successResponse( $user, ['success' => ["message" => 'email verified successfully']], 201);
            }

            return $this->errorResponse( 'error', ['success' => 'email is already verificated'], 401);

        }

        return $this->errorResponse("invalid", ['error' => 'email '.$email. ' has not registed in the système or invalid verification code '], 404);

    }


}
