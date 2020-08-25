<?php

namespace PlayWrightClient\Api;

use PlayWrightClient\Exception\JsError;
use PlayWrightClient\Js;

class Context extends Js
{

    private $contextName = 'context';

    /**
     * @param string $name
     * @param string $value
     * @param string|null $url either url or domain / path are required
     * @param string|null $domain either url or domain / path are required
     * @param string|null $path either url or domain / path are required
     * @param int|null $expires Unix time in seconds. *1000 for js
     * @param bool|null $httpOnly
     * @param bool|null $secure
     * @param string|null $sameSite "Strict"|"Lax"|"None"
     * @return $this
     */
    public function addCookies(
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

        $cookieObject = self::build($data, true);

        $this->safeAwaitAppend("await $this->contextName.addCookies($cookieObject))");

        return $this;
    }

    public function clearCookies(): Context
    {
        $this->safeAwaitAppend("await $this->contextName.clearCookies()");

        return $this;
    }

    public function clearPermissions(): Context
    {
        $this->safeAwaitAppend("await $this->contextName.clearPermissions()");

        return $this;
    }

    public function close(): Context
    {
        $this->safeAwaitAppend("await $this->contextName.close()");

        return $this;
    }

    /**
     * @param string $varToSave
     * @param string[] $urls
     * @return $this
     */
    public function cookies(string $varToSave, array $urls): Context
    {

        $this->saveToVar($varToSave, '', false);
        $this->safeAwaitAppend("await $this->contextName.cookies(" . self::buildList($urls) . ")");
        $this->append(''); //new line

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
     * 'microphone'
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

        $this->safeAwaitAppend("await $this->contextName.grantPermissions(" .
            self::buildList($permissions) . ", " .
            self::build($options) .
            ")");

        return $this;
    }

    public function newPage(): Page
    {
        $customVarName = 'page' . self::generateRandomVarName();

        $this->saveToVar($customVarName, '', false);
        $this->safeAwaitAppend("await $this->contextName.newPage()");
        $this->append('');

        return new Page($customVarName, $this->jsString);
    }

    /**
     * @param int $index
     * @return Page
     */
    public function pageByIndex(int $index): Page
    {
        $customVarName = 'page' . self::generateRandomVarName();

        $this->saveToVar($customVarName, "(await $this->contextName.page())[$index]");
        return new Page($customVarName, $this->jsString);
    }

    /**
     * @param string $rule `**\/*.{png,jpg,jpeg}` or /(\.png$)|(\.jpg$)/
     * @return $this
     */
    public function routeAbort(string $rule): Context
    {
        $this->safeAwaitAppend("await $this->contextName.route($rule, route => route.abort())");

        return $this;
    }

    /**
     * @param string $rule `**\/*.{png,jpg,jpeg}` or /(\.png$)|(\.jpg$)/
     * @return $this
     */
    public function unroute(string $rule): Context
    {
        $this->safeAwaitAppend("await $this->contextName.unroute($rule)");

        return $this;
    }

    public function setGeolocation(float $latitude, float $longitude, int $accuracy = 0): Context
    {
        $data = [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
        ];

        $this->safeAwaitAppend("await $this->contextName.setGeolocation(" . self::build($data) . ")");

        return $this;
    }

    public function setHTTPCredentials(string $username, string $password): Context
    {
        $data = [
            'username' => $username,
            'password' => $password,
        ];

        $this->safeAwaitAppend("await $this->contextName.setHTTPCredentials(" . self::build($data) . ")");

        return $this;
    }

    public function setOffline(bool $offline): Context
    {
        $this->safeAwaitAppend("await $this->contextName.setOffline($offline)");

        return $this;
    }

    /**
     * @param string $event
     * @param int $timeout milliseconds - 0 to disable
     * @return $this
     */
    public function waitForEvent(string $event, int $timeout = 30000): Context
    {

        $data = [
            'timeout' => $timeout
        ];

        $this->safeAwaitAppend("await $this->contextName.waitForEvent("
            . self::build($event)
            . ','
            . self::build($data)
            . ")");

        return $this;
    }

    

















}
