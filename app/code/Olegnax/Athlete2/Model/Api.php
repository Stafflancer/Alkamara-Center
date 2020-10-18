<?php


namespace Olegnax\Athlete2\Model;


use Closure;
use Exception;

/**
 * License Keys's API wrapper.
 */
class Api
{
    /**
     * Activates a license key.
     * Returns call response.
     * @param Client $client Client to use for api calls.
     * @param Closure $getRequest Callable that returns a LicenseRequest.
     * @param $setRequest Callable that sets a LicenseRequest casted as string.
     *
     * @return object|stdClass
     * @throws Exception when LicenseRequest is not present.
     *
     * @since 1.0.0
     *
     */
    public static function activate(Client $client, Closure $getRequest, $setRequest)
    {
        // Prepare
        $license = $getRequest();
        if (!is_a($license, LicenseRequest::class)) {
            throw new Exception(__('Closure must return an object instance of LicenseRequest.'));
        }
        // Call
        if (!array_key_exists('domain', $license->request) || empty($license->request['domain'])) {
            $license->request['domain'] = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown';
        }
        $license->request['domain'] = preg_replace('/^(www|dev)\./i', '', $license->request['domain']);
        $license->request['user'] = static::get_client_ip();
        $response = $client->call('license_key_activate', $license);
        if ($response && isset($response->error)
            && $response->error === false
        ) {
            if (isset($response->notices)) {
                $license->notices = (array)$response->notices;

            }
            $license->data = (array)$response->data;
            $license->touch();
            call_user_func($setRequest, (string)$license);
        }

        return $response;
    }

    public static function get_client_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                return $_SERVER['REMOTE_ADDR'];
            } else {
                if (isset($_SERVER['REMOTE_HOST'])) {
                    return $_SERVER['REMOTE_HOST'];
                }
            }
        }

        return 'UNKNOWN';
    }

    /**
     * Validates a license key.
     * Returns flag indicating if license key is valid.
     * @param Client $client Client to use for api calls.
     * @param Closure $getRequest Callable that returns a LicenseRequest.
     * @param $setRequest Callable that sets (updates) a LicenseRequest casted as string.
     * @param bool $force Flag that forces validation against the server.
     * @param bool $allowRetry Allow to connection retries.
     * @param int $retryAttempts Retry attempts.
     * @param string $retryFrequency Retry frequency.
     *
     * @return bool
     * @throws Exception when LicenseRequest is not present.
     *
     * @since 1.0.0
     *
     */
    public static function validate(
        Client $client,
        Closure $getRequest,
        $setRequest,
        $domain = null,
        $force = false,
        $allowRetry = false,
        $retryAttempts = 2,
        $retryFrequency = '+1 hour'
    ) {
        // Prepare
        $license = $getRequest();
        if (!is_a($license, LicenseRequest::class)) {
            throw new Exception(' \Closure must return an object instance of LicenseRequest.');
        }
        $license->updateVersion();
        // Check license data

        if ($license->isEmpty || empty($license->data['the_key'])) {
            return false;
        }
        // No need to check if license already expired.
        if ('active' != $license->data['status']) {
            return false;
        }
        // Validate cached license data
        if (!$force
            && time() < $license->nextCheck
            && $license->isValid
        ) {
            return true;
        }
        // Call
        if (empty($domain)) {
            $domain = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown';
        }
        $license->request['domain'] = preg_replace('/^(www|dev)\./i', '', $domain);
        $license->request['user'] = static::get_client_ip();
        $response = null;
        try {
            $response = $client->call('license_key_validate', $license);
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Could not resolve host') === false) {
                throw $e;
            }
        }

        if ($response
            && isset($response->error)
        ) {
            if (isset($response->data)) {
                $license->data = (array)$response->data;
            } else {
                $license->data = [];
            }
            if ($response->error && isset($response->errors)) {
                $license->data = ['errors' => $response->errors];
            }
            $license->touch();
            call_user_func($setRequest, (string)$license);
            return $response->error === false;
        } else {
            if (empty($response)
                && $license->url
                && isset($license->data['allow_offline'])
                && isset($license->data['offline_interval'])
                && isset($license->data['offline_value'])
                && $license->data['allow_offline'] === true
            ) {
                if (!$license->isOffline) {
                    $license->enableOffline();
                    call_user_func($setRequest, (string)$license);
                    return true;
                } else {
                    if ($license->isOfflineValid) {
                        return true;
                    }
                }
            } else {
                if (empty($response)
                    && $allowRetry
                    && $license->retries < $retryAttempts
                ) {
                    $license->addRetryAttempt($retryFrequency);
                    call_user_func($setRequest, (string)$license);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Deactivates a license key.
     * Returns call response.
     * @param Client $client Client to use for api calls.
     * @param Closure $getRequest Callable that returns a LicenseRequest.
     * @param $setRequest Callable that updates a LicenseRequest casted as string.
     *
     * @return object|stdClass
     * @throws Exception when LicenseRequest is not present.
     *
     * @since 1.0.0
     *
     */
    public static function deactivate(Client $client, Closure $getRequest, $setRequest, $domain = null)
    {
        // Prepare
        $license = $getRequest();
        if (!is_a($license, LicenseRequest::class)) {
            throw new Exception(' \Closure must return an object instance of LicenseRequest.');
        }
        $license->updateVersion();
        // Call
        if (empty($domain)) {
            $domain = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown';
        }
        $license->request['domain'] = preg_replace('/^(www|dev)\./i', '', $domain);
        $license->request['user'] = static::get_client_ip();
        $response = $client->call('license_key_deactivate', $license);
        // Remove license
        if ($response && isset($response->error)) {
            if ($response->error === false) {
                call_user_func($setRequest, null);
            } else {
                if (isset($response->errors)) {
                    foreach ($response->errors as $key => $message) {
                        if ($key === 'activation_id') {
                            call_user_func($setRequest, null);
                            break;
                        }
                    }
                }
            }
        }
        return $response;
    }

    /**
     * Validates a license key (NO SERVER VALIDATION).
     * @param Closure $getRequest Callable that returns a LicenseRequest.
     *
     * @return bool
     * @throws Exception when LicenseRequest is not present.
     *
     * @since 1.0.9
     *
     */
    public static function softValidate(Closure $getRequest)
    {
        // Prepare
        $license = $getRequest();
        if (!is_a($license, LicenseRequest::class)) {
            throw new Exception(' \Closure must return an object instance of LicenseRequest.');
        }
        $license->updateVersion();
        // Check license data
        if ($license->isEmpty || !$license->data['the_key']) {
            return false;
        }
        if ('active' != $license->data['status']) {
            return false;
        }
        // Validate cached license data
        return $license->isValid;
    }

    /**
     * Returns validate endpoint's response.
     * @param Client $client Client to use for api calls.
     * @param Closure $getRequest Callable that returns a LicenseRequest.
     * @param $setRequest Callable that updates a LicenseRequest casted as string.
     *
     * @return object|stdClass
     * @throws Exception when LicenseRequest is not present.
     *
     * @since 1.0.10
     *
     */
    public static function check(Client $client, Closure $getRequest, $setRequest)
    {
        // Prepare
        $license = $getRequest();
        if (!is_a($license, LicenseRequest::class)) {
            throw new Exception(' \Closure must return an object instance of LicenseRequest.');
        }
        $license->updateVersion();
        // Check license data
        if ($license->isEmpty || !$license->data['the_key']) {
            return false;
        }
        if ('active' != $license->data['status']) {
            return false;
        }
        // Call
        $license->request['domain'] = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'Unknown';
        $response = null;
        try {
            $response = $client->call('license_key_validate', $license);
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'Could not resolve host') === false) {
                throw $e;
            }
        }
        if ($response && isset($response->error)) {
            if (isset($response->data)) {
                $license->data = (array)$response->data;
            } else {
                $license->data = [];
            }
            if ($response->error && isset($response->errors)) {
                $license->data = ['errors' => $response->errors];
            }
            $license->touch();

            call_user_func($setRequest, (string)$license);
        }
        return $response;
    }
}