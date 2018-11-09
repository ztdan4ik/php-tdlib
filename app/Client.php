<?php
namespace ztdan4ik\phptd;

/**
 * Class Client
 * @package phptd
 */
class Client
{
    /**
     * Update types
     */
    const TYPE_UPDATE_AUTH = 'updateAuthorizationState';
    const TYPE_UPDATE_TERMS = 'updateTermsOfService';
    const TYPE_OK = 'ok';
    const TYPE_ERROR = 'error';

    /**
     * Authorization States
     */
    const AUTH_STATE_PARAMS = 'authorizationStateWaitTdlibParameters';
    const AUTH_STATE_KEY = 'authorizationStateWaitEncryptionKey';
    const AUTH_STATE_PHONE = 'authorizationStateWaitPhoneNumber';
    const AUTH_STATE_CODE = 'authorizationStateWaitCode';
    const AUTH_STATE_READY = 'authorizationStateReady';
    const AUTH_STATE_CLOSED = 'authorizationStateClosed';
    const AUTH_STATE_CLOSING = 'authorizationStateClosing';
    const AUTH_STATE_LOGGING_OUT = 'authorizationStateLoggingOut';
    const AUTH_STATE_PASSWD = 'authorizationStateWaitPassword';

    /**
     * @var int
     */
    public $log_level = 1;

    /**
     * @var int
     */
    public $timeout = 5;

    /**
     * @var
     */
    private $client;

    /**
     * Client constructor.
     * @param array $parameters
     */
    public function __construct($parameters = [])
    {
        foreach ($parameters as $name => $value)
            $this->{$name} = $value;

        $this->client = td_json_client_create($this->log_level);
    }

    /**
     * @param $parameters \ztdan4ik\phptd\Parameters;
     */
    public function setTdlibParameters($parameters) : void
    {
        $this->send('setTdlibParameters', ['parameters' => $parameters->toArray()], 'setTdlibParameters');
    }

    /**
     * @param string|null $key
     */
    public function setDatabaseEncryptionKey($key = null) : void
    {
        $this->send('setDatabaseEncryptionKey', ['new_encryption_key' => $key], 'setDatabaseEncryptionKey');
    }

    /**
     * @param string $phone
     */
    public function setAuthenticationPhoneNumber($phone) : void
    {
        $this->send('setAuthenticationPhoneNumber', ['phone_number' => $phone], 'setAuthenticationPhoneNumber');
    }

    /**
     * @param string $code
     */
    public function checkAuthenticationCode($code, $first_name = null, $last_name = null) : void
    {
        $this->send('checkAuthenticationCode', ['code' => $code, 'first_name' => $first_name, 'last_name' => $last_name], 'checkAuthenticationCode');
    }

    /**
     * @param $id
     */
    public function acceptTermsOfService($id) : void
    {
        $this->send('acceptTermsOfService', ['terms_of_service_id' => $id]);
    }

    /**
     * @param $type
     * @param array $parameters
     * @param null|string|integer $extra
     */
    public function send($type, $parameters = [], $extra = false) : void
    {
        $request['@type'] = $type;
        if($extra) $request['@extra'] = $extra;
        $parameters = json_encode(array_merge($request, $parameters));
        td_json_client_send($this->client, $parameters);
    }


    /**
     * @param string $type
     * @param array $parameters
     * @return string
     */
    public function execute($type, $parameters = [])
    {
        $parameters = json_encode(array_merge(['@type' => $type], $parameters));
        return td_json_client_execute($this->client, $parameters);
    }

    /**
     * @return string
     */
    public function receive()
    {
        return td_json_client_receive($this->client, $this->timeout);
    }


    public function destroy() : void
    {
        td_json_client_destroy($this->client);
    }

}