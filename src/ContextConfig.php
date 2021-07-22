<?php


class ContextConfig
{

    private $options = [
        'acceptDownloads' => false,//bool
        'bypassCSP' => null, //bool
        'deviceScaleFactor' => null, //int
        'extraHTTPHeaders' => null, //object
        'geolocation' => null, //object
        'hasTouch' => null, //bool
        'httpCredentials' => null, //bool
        'ignoreHTTPSErrors' => true, //bool
        'isMobile' => null, //bool
        'javaScriptEnabled' => true,
        'locale' => null, //string
        'offline' => null, //bool
        'permissions' => null, //array of string,
        'proxy' => null, //object
        'userAgent' => null, //string
        'viewport' => null, //object
    ];

    public function setAcceptDownloads(?bool $acceptDownloads)
    {
        $this->options['acceptDownloads'] = $acceptDownloads;
    }

    public function setBypassCsp(?bool $bypassCSP)
    {
        $this->options['bypassCSP'] = $bypassCSP;
    }

    public function setDeviceScaleFactor(?int $deviceScaleFactor)
    {
        $this->options['deviceScaleFactor'] = $deviceScaleFactor;
    }

    /**
     * @param null|array $extraHTTPHeaders array of headers, key -> header name, value -> header body
     */
    public function setExtraHTTPHeaders(?array $extraHTTPHeaders)
    {
        if (is_array($extraHTTPHeaders)) {
            $this->options['extraHTTPHeaders'] = [];
        } else {
            $this->options['extraHTTPHeaders'] = null;
        }
    }

    public function addExtraHTTPHeader(string $name, string $value)
    {
        if (!is_array($this->options['extraHTTPHeaders'])) {
            $this->options['extraHTTPHeaders'] = [];
        }

        $this->options['extraHTTPHeaders'][$name] = $value;
    }

    public function setGeolocation(?float $latitude, ?float $longitude, int $accuracy = 0)
    {
        $this->options['geolocation'] = null;

        if (is_float($latitude) && is_float($longitude)) {
            $this->options['geolocation']['latitude'] = $latitude;
            $this->options['geolocation']['longitude'] = $longitude;
            $this->options['geolocation']['accuracy'] = $accuracy;
        }
    }

    public function hasTouch(?bool $hasTouch)
    {
        $this->options['hasTouch'] = $hasTouch;
    }

    public function setHttpCredentials(?string $username = null, ?string $password = null)
    {
        $this->options['httpCredentials'] = null;

        if (is_string($username) && is_string($password)) {
            $this->options['httpCredentials']['username'] = $username;
            $this->options['httpCredentials']['password'] = $password;
        }
    }

    public function setIgnoreHTTPSErrors(?bool $ignoreHTTPSErrors = null)
    {
        $this->options['ignoreHTTPSErrors'] = $ignoreHTTPSErrors;
    }

    public function isMobile(?bool $isMobile = null)
    {
        $this->options['isMobile'] = $isMobile;
    }

    public function setJavaScriptEnabled(?bool $javaScriptEnabled = null)
    {
        $this->options['javaScriptEnabled'] = $javaScriptEnabled;
    }

    public function setLocale(?string $locale = null)
    {
        $this->options['locale'] = $locale;
    }

    public function setOffline(?bool $offline = null)
    {
        $this->options['offline'] = $offline;
    }

    public function setPermissions(?array $permissions = null)
    {
        if (is_array($this->options['permissions'])) {
            $this->options['permissions'] = [];

            $this->options['permissions'] = array_values($permissions);
        } else {
            $this->options['permissions'] = null;
        }
    }

    public function setProxy(?string $server = null, ?string $bypass = null, ?string $username = null, ?string $password = null)
    {
        if (is_string($server)) {
            $this->options['proxy'] = [
                'server' => $server,
                'bypass' => $bypass ?? '',
                'username' => $username ?? '',
                'password' => $password ?? '',
            ];
        } else {
            $this->options['proxy'] = null;
        }
    }

    public function setUserAgent(?string $userAgent = null)
    {
        $this->options['userAgent'] = $userAgent;
    }

    public function setViewport(?int $width = null, ?int $height = null)
    {
        if (is_int($width) && is_int($height)) {
            $this->options['viewport']['width'] = $width;
            $this->options['viewport']['height'] = $height;
        } else {
            $this->options['viewport'] = null;
        }
    }

    public function toArray(): array
    {
        $options = [];

        foreach ($this->options as $key => $option) {
            if (!is_null($option)) {
                $options[$key] = $option;
            }
        }

        return $options;
    }
}