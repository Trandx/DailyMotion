<?php
namespace App\Http\Controllers\Api\Auth\social;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Laravel\Socialite\Two\User as ProviderUser;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use Exception;

class SocialController extends Controller
{
    //Les tableaux des providers autorisés
    protected $providers = [ "google", "github", "facebook" ];
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(Request $request)
    {
        $provider = $request->provider;
        // On vérifie si le provider est autorisé
        if (in_array($provider, $this->providers)) {
            return Socialite::driver($provider)->stateless()->redirect();
        }
        return '404';
    }

    /**
     * Obtain the user information from facebook, google...
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request)
    {
        $provider = $request->provider;

        if (in_array($provider, $this->providers)) {
        	// Les informations provenant du provider
            $user = Socialite::driver($provider)->stateless()->user();
            $user->token;
            $providerUser = Socialite::driver($provider)->userFromToken($user->token);
            //return   $user->getName();
            return $this->resolveUserByProviderCredentials($provider, $user->token);


    }

    }


    /**
     * Resolve user by provider credentials.
     *
     * @param string $provider
     * @param string $accessToken
     *
     * @return Authenticatable|null
     */
    public function resolveUserByProviderCredentials(string $provider, string $accessToken)
    {
        $providerUser = null;

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (Exception $exception) {}

        if ($providerUser) {

            return $this->findOrCreate($providerUser, $provider);
        }
        return null;
    }


    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        dd($providerUser);
    $linkedSocialAccount =LinkedSocialAccount::where('provider_name', $provider)
    ->where('provider_id', $providerUser->getId())
    ->first();
    if ($linkedSocialAccount) {
    return $linkedSocialAccount->user;
    } else {
    $user = null;
    if ($email = $providerUser->getEmail()) {
    $user = User::where('email', $email)->first();
    }
    if (! $user) {
    $user = User::create([
        'firstName' => $providerUser->getName(),
        'name' => $providerUser->getName(),
        'email' => $providerUser->getEmail(),
        'lastName'=> "lastName",
        'AvatarLink'=>$providerUser->getAvatar(),
        'tokenExternalAccount'=>$providerUser->token
    ]);
    }
    $user->linkedSocialAccounts()->create([
    'provider_id' => $providerUser->getId(),
    'provider_name' => $provider,
    ]);

    return $user;
    }
    }



}
