<?php

namespace PlayWrightClient\Api;

use PlayWrightClient\Exception\JsError;
use PlayWrightClient\Js\Builder;
use PlayWrightClient\Js\Functions;
use PlayWrightClient\Js\Vars;

class Context extends Builder
{

    private $contextName = 'context';

    /**
     * @param string $name
     * @param string $value
     * @param string|null $url either url or domain / path are required (https://example.com)
     * @param string|null $domain either url or domain / path are required
     * @param string|null $path either url or domain / path are required
     * @param int|null $expires Unix time in seconds. *1000 for js
     * @param bool|null $httpOnly
     * @param bool|null $secure
     * @param string|null $sameSite "Strict"|"Lax"|"None"
     * @return $this
     */
    public function addCookie(
        string $name,
        string $value,
        string $url = null,
        string $domain = null,
        string $path = null,
        int $expires = null,
        bool $httpOnly = null,
        bool $secure = null,
        string $sameSite = null
    ): Context
    {
        if (is_int($expires)) {
            $expires *= 1000;
        }

        $data = [
            'name' => $name,
            'value' => $value,
            'url' => $url,
            'domain' => $domain,
            'path' => $path,
            'expires' => $expires,
            'httpOnly' => $httpOnly,
            'secure' => $secure,
            'sameSite' => $sameSite,
        ];

        $this->merge(Functions::callAwaitSafe("$this->contextName.addCookies", [$data]));

        return $this;
    }

    public function getContextVarName(): string {
        return $this->contextName;
    }

    public function clearCookies(): Context
    {
        $this->merge(Functions::callAwaitSafe("$this->contextName.clearCookies"));

        return $this;
    }

    public function clearPermissions(): Context
    {
        $this->merge(Functions::callAwaitSafe("$this->contextName.clearPermissions"));

        return $this;
    }

    public function close(): Context
    {
        $this->merge(Functions::callAwaitSafe("$this->contextName.close"));

        return $this;
    }

    /**
     * Get cookies array, saved to var by urls list
     *
     * @param string $varToSave
     * @param string[] $urls
     * @return $this
     */
    public function cookiesToVar(string $varToSave, array $urls): Context
    {
        $builder = Functions::callAwaitSafe("$this->contextName.cookies", $urls);
        $builder->toVar($varToSave);

        $this->merge($builder);

        return $this;
    }


    /**
     * @param string[] $permissions
     * '*'
     * 'geolocation'
     * 'midi'
     * 'midi-sysex' (system-exclusive midi)
     * 'notifications'
     * 'push'
     * 'camera'
     * 'microphone
     * 'background-sync'
     * 'ambient-light-sensor'
     * 'accelerometer'
     * 'gyroscope'
     * 'magnetometer'
     * 'accessibility-events'
     * 'clipboard-read'
     * 'clipboard-write'
     * 'payment-handler'
     * @param string $origin url
     * @return Context
     */
    public function grantPermissions(array $permissions, string $origin): Context
    {
        $options = [
            'origin' => $origin,
        ];

        $this->merge(Functions::callAwaitSafe("$this->contextName.grantPermissions", $permissions, $options));


        return $this;
    }

    public function newPage(): Page
    {
        $customVarName = 'page' . Vars::generateRandomVarName();

        $builder = Functions::callAwaitSafe("$this->contextName.newPage");
        $builder->toVar($customVarName);

        $this->merge($builder);

        return new Page($customVarName, $this->jsString, $this->requestTimeout);
    }

    /**
     * @param int $index
     * @return Page
     */
    public function pageByIndex(int $index): Page
    {
        $customVarName = 'page' . Vars::generateRandomVarName();

        $builder = Functions::callAwaitSafe("$this->contextName.page");
        $builder->index($index)->toVar($customVarName);
        return new Page($customVarName, $this->jsString, $this->requestTimeout);
    }

    /**
     * @param string $rule `**\/*.{png,jpg,jpeg}` or /(\.png$)|(\.jpg$)/
     * @return $this
     */
    public function routeAbort(string $rule): Context
    {
        $builder = Functions::callAwaitSafe("$this->contextName.route", $rule, 'route => route.abort()');
        $this->merge($builder);

        return $this;
    }

    /**
     * @param string $rule `**\/*.{png,jpg,jpeg}` or /(\.png$)|(\.jpg$)/
     * @return $this
     */
    public function unroute(string $rule): Context
    {
        $this->merge(Functions::callAwaitSafe("$this->contextName.unroute", $rule));

        return $this;
    }

    public function setGeolocation(float $latitude, float $longitude, int $accuracy = 0): Context
    {
        $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
        ];

        $this->merge(Functions::callAwaitSafe("$this->contextName.setGeolocation", $data));

        return $this;
    }

    public function setHTTPCredentials(string $username, string $password): Context
    {
        $data = [
            'username' => $username,
            'password' => $password,
        ];

        $this->merge(Functions::callAwaitSafe("$this->contextName.setHTTPCredentials", $data));
        return $this;
    }

    public function setOffline(bool $offline): Context
    {
        $this->merge(Functions::callAwaitSafe("$this->contextName.setOffline", $offline));
        return $this;
    }

    /**
     * @param string $event "close" or "page"
     * @param int $timeout milliseconds - 0 to disable
     * @return $this
     */
    public function waitForEvent(string $event, int $timeout = 30000): Context
    {

        $data = [
            'timeout' => $timeout,
        ];

        $this->merge(Functions::callAwaitSafe("$this->contextName.waitForEvent", $event, $data));

        return $this;
    }


}
