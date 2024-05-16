<?php


namespace App\Services\VideoCommService;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class O2OMeetConnector implements VideoCommProviderInterface
{
    private $user;
    private $serverClient;
    private $passwordClient;
    private $clientAccessToken = null;
    private $clientId = null;
    private $clientSecret = null;
    private $masterAccount = null;
    private $accessToken = null;
    private $loggedIn = false;
    private $baseApiUrl = 'https://api.o2omeet.com/v1';
    private $baseSpaUrl = 'https://app.o2omeet.com';
    private $defaultCustomPlan = 'search_meetings_complete';

    public function __construct()
    {
        $this->clientId = config('services.o2omeet.client_id');
        $this->clientSecret = config('services.o2omeet.client_secret');
        $this->masterAccount = config('services.o2omeet.master_account');

        $this->serverClient = new Client();
        $this->passwordClient = new Client();

        if(config('app.env') === 'production')
        {
            $this->initializeServerClient();
        }
    }

    private function clientInitialized()
    {
        return $this->clientAccessToken !== null;
    }

    private function initializeServerClient()
    {
        if ($this->clientId && $this->clientSecret) {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/oauth/token',
                [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'scope' => '*',
                    ],
                ]
            );

            if ($res->getStatusCode() == 200) {
                $body = json_decode($res->getBody());
                $this->clientAccessToken = $body->access_token;

                $this->refreshClient('server');
            }
        } else {

            throw new \Exception('client credentials missing');
        }
    }

    private function refreshClient($client_type)
    {
        switch($client_type)
        {
            case "server":
                $this->serverClient = new \GuzzleHttp\Client(
                    [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => sprintf('Bearer %s', $this->clientAccessToken),
                        ],
                    ]
                );
                break;
            case "password":
                $this->passwordClient  = new \GuzzleHttp\Client(
                    [
                        'headers' => [
                            'Accept' => 'application/json',
                            'Content-type' => 'application/json',
                            'Authorization' => sprintf('Bearer %s', $this->accessToken),
                        ],
                    ]
                );
                break;
        }
    }

    public function checkUser($userData, $organizationData = null)
    {
        if (!$this->clientInitialized()) {
            $this->handleClientNotInitialized();
        }

        Validator::make($userData, [
            'name' => ['string', 'required'],
            'email' => ['email', 'required'],
            'type' => ['string', 'required', 'in:admin,user'],
        ]);

        if($organizationData)
        {
            Validator::make($userData, [
                'title' => ['string', 'required'],
            ]);
        }

        try
        {
            if(isset($userData['type']) && $userData['type'] === 'admin' && !$organizationData)
            {
                throw new \Exception('organization is required');
            }

            try
            {
                $getUserResponse = $this->getUser($userData['email']);
            }
            catch(\Exception $exception)
            {
                if($exception->getMessage() === 'user does not exist')
                {
                    if($userData['type'] === 'admin')
                    {
                        $userData['type'] = 'user';
                        $createUserResponse = $this->createUser($userData);
                        $createOrganizationResponse = $this->createOrganization($organizationData);
                        $this->assignAdminToOrganization($createUserResponse->data->email, $createOrganizationResponse->data->id);
                        $this->initializeSubscription($createOrganizationResponse->data->id, $this->defaultCustomPlan);
                        return [
                            'status' => 'success',
                            'organization' => $createOrganizationResponse->data,
                            'user' => $createUserResponse->data
                        ];
                    }
                    else
                    {
                        $createUserResponse = $this->createUser($userData);
                        return [
                            'status' => 'success',
                            'user' => $createUserResponse->data
                        ];
                    }
                }
                else
                {
                    throw $exception;
                }
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet create user failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    private function getUser($email)
    {
        try
        {
            $res = $this->serverClient->request(
                'GET',
                $this->baseApiUrl . '/client/user'."?email=$email",
                );

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }

        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet get user failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    private function createUser($data)
    {
        if (!$this->clientInitialized()) {
            $this->handleClientNotInitialized();
        }

        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/client/auth/register',
                [
                    'form_params' => [
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'sign_on_type' => 'client',
                        'email_verified' => true,
                        'type' => $data['type'] ?? 'user',
                    ],
                ],
            );

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet create user failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    private function createOrganization($data)
    {
        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/client/organization',
                [
                    'form_params' => [
                        'title' => $data['title'],
                    ],
                ]
            );

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }

            return false;
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet create organization failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    private function assignAdminToOrganization($email, $organization_id)
    {
        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/client/organization/assign-admin',
                [
                    'form_params' => [
                        'email' => $email,
                        'organization_id' => $organization_id,
                    ],
                ]
            );

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());

            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet assign admin to organization failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    private function initializeSubscription($organization_id, $custom_plan_id)
    {
        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/client/organization/subscription/initialize',
                [
                    'form_params' => [
                        'plan_id' => $custom_plan_id,
                        'organization_id' => $organization_id,
                    ],
                ]
            );

            if ($res->getStatusCode() == 200) {
                return json_decode($res->getBody());
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());

            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2omeet initialize subscription failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    public function setUser($user = null)
    {
        if(!$user)
        {
            $user = new User([
                'name' => 'Search meetings admin',
                'email' => $this->masterAccount
            ]);

            $this->user = $user;
            $this->checkUser([
                'name' => $user->name,
                'email' => $user->email,
                'type' => 'admin'
            ], [
                'title' => 'Search meetings',
            ]);
        }
        else
        {
            $this->user = $user;
            $this->checkUser([
                'name' => $user->name,
                'email' => $user->email,
                'type' => 'user'
            ]);
        }
    }

    public function login()
    {
        if (!$this->clientInitialized()) {
            $this->handleClientNotInitialized();
        }

        if (!$this->user) {
            $this->handleUserNotSet();
        }

        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . '/client/auth/get-access-token',
                [
                    'form_params' => [
                        'email' => $this->user->email
                    ],
                ]
            );

            if ($res->getStatusCode() == 200) {
                $body = json_decode($res->getBody());

                $this->loggedIn = true;
                $this->accessToken = $body->data->access_token;

                $this->refreshClient('password');
            }
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2o meet login failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    public function logout()
    {
        $this->loggedIn = false;
        $this->user = null;
        $this->accessToken = null;
    }

    public function getDirectLoginUrl($redirect = null)
    {
        if (!$this->clientInitialized()) {
            $this->handleClientNotInitialized();
        }

        if (!$this->user) {
            $this->handleUserNotSet();
        }

        try
        {
            $res = $this->serverClient->request(
                'POST',
                $this->baseApiUrl . "/client/auth/get-direct-login",
                [
                    'form_params' => [
                        'email' => $this->user->email
                    ],
                ]
            );

            $url = null;

            if ($res->getStatusCode() == 200) {
                $body = json_decode($res->getBody());
                $url = $body->data->direct_url;
            }

            if ($redirect) {
                $url = $url . '&redirect_to=' . $redirect;
            }

            return $url;
        }
        catch (ClientException $e) {
            $response = $e->getResponse();
            $error = json_decode($response->getBody()->getContents());
            throw new \Exception($error->message);
        }
        catch (\Exception $exception)
        {
            Log::error('o2o meet direct login failed: ' . $exception->getMessage());
            throw $exception;
        }
    }

    public function getChannelLink($type, $id)
    {
        return $this->baseSpaUrl . "/" . $type . "s/". $id;
    }

    public function getChannelParticipantJoinLink($type, $id)
    {
        return $this->getDirectLoginUrl("/". $type . "s/" . $id ."/session/live");
    }

    public function getAnonymousJoinLink($type, $id)
    {
        return $this->baseSpaUrl . "/" . $type ."s/". $id ."/session/live?mode=anonymous";
    }

    public function createMeeting($data)
    {
        if (!$this->accessToken) {
            $this->login();
        }

        Log::info($this->accessToken);

        $res = $this->passwordClient->request('POST',
            $this->baseApiUrl . '/meetings',
            [
                'debug' => false,
                'headers' => [
                    'Authorization' => "Bearer $this->accessToken",
                    'Accept' => 'application/json',
                    'Content-type' => 'application/x-www-form-urlencoded',
                ],
                'form_params' => [
                    "title" => (strlen($data['title']) > 60) ? substr($data['title'], 0, 56).'...' : $data['title'],
                    "description" => strip_tags($data['description']),
                    "timezone" => $data['timezone'],
                    "start_on" => Carbon::createFromFormat('Y-m-d H:i:s',$data['start_on'])->format('Y-m-d H:i'),
                    "access" => "none",
                    "invites" => $data['invites'] ?? null
                ]
            ]);

        if ($res->getStatusCode() == 200) {
            return json_decode($res->getBody());
        }

        if ($res->getStatusCode() == 401) {
            try {
                $this->login();
                $this->create_meeting($data);
            } catch (\Exception $e) {
                throw $e;
            }
        }

        if ($res->getStatusCode() == 400) {
            throw new \Exception('invalid request', 1);
        }
    }

    private function handleClientNotInitialized()
    {
        $this->initializeServerClient();
    }

    private function handleUserNotSet(){
        throw new \Exception('user unavailable');
    }

    private function handleUnauthenticated(){
        throw new \Exception('unauthenticated');
    }
}