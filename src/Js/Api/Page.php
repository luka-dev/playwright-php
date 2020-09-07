<?php


namespace PlayWrightClient\Api;


use Exception;
use PlayWrightClient\Api\Structures\Header;
use PlayWrightClient\Api\Structures\SelectOption;
use PlayWrightClient\Js\Builder;
use PlayWrightClient\Js\Constructions;
use PlayWrightClient\Js\Functions;
use PlayWrightClient\Js\Script;
use PlayWrightClient\Js\Vars;

class Page extends Builder
{
    private $pageVarName;

    public function __construct(string $pageVarName, string &$customJsStore = '')
    {
        $this->pageVarName = $pageVarName;
        parent::__construct($customJsStore);
    }

    public function getPageVarName(): string
    {
        return $this->pageVarName;
    }

    /**
     * On runtime can fail if element not founded. Use try catch
     * a.k.a. selectOne
     *
     * @param string $selector
     * @return ElementHandle
     */
    public function query(string $selector): ElementHandle
    {
        $customVarName = 'element' . Vars::generateRandomVarName();

        $builder = Functions::callAwaitSafe("$this->pageVarName.$", $selector);
        $builder->toVar($customVarName);
        $this->merge($builder);

        return new ElementHandle($customVarName, $this->jsString);
    }

//    /**
//     * @param string $selector
//     * @param string $varName
//     */
//    public function queryAllToVar(string $selector, string $varName): void
//    {
//        //todo rework array stuff
//
//        $builder = Functions::callAwaitSafe("$this->pageVarName.$$", $selector);
//        $builder->toVar($varName);
//        $this->merge($builder);
//    }

    /**
     * @param string $selector
     * @param string $button left|right|middle
     * @param int $clickCount
     * @param int $delay btw clicks in milliseconds
     * @param array $modifiers ["Alt"|"Control"|"Meta"|"Shift"] or empty
     * @param bool $force Whether to bypass the actionability checks
     * @param int $timeout
     */
    public function click(string $selector, string $button = 'left', int $clickCount = 1, int $delay = 0, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {
        $options = [
            'button' => $button,
            'clickCount' => $clickCount,
            'delay' => $delay,
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.click", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $key F1 - F12, Digit0- Digit9, KeyA- KeyZ, Backquote, Minus, Equal, Backslash, Backspace, Tab, Delete, Escape, ArrowDown, End, Enter, Home, Insert, PageDown, PageUp, ArrowRight, ArrowUp, etc.
     * @param int $timeout
     */
    public function press(string $selector, string $key, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.press", $selector, $key, $options);
        $this->merge($builder);
    }

    public function close(): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.close");
        $this->merge($builder);
    }

    public function contentToVar(string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.content");
        $builder->toVar($varName);
        $this->merge($builder);
    }

    /**
     * Double click
     *
     * @param string $selector
     * @param string $button left|right|middle
     * @param int $delay btw clicks in milliseconds
     * @param array $modifiers ["Alt"|"Control"|"Meta"|"Shift"] or empty
     * @param bool $force Whether to bypass the actionability checks
     * @param int $timeout
     */
    public function dblclick(string $selector, string $button = 'left', int $delay = 0, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {
        $options = [
            'button' => $button,
            'delay' => $delay,
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.dblclick", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string|null $media null|"screen"|"print"
     * @param string|null $colorScheme null|"light"|"dark"|"no-preference"
     */
    public function emulateMedia(?string $media = 'screen', ?string $colorScheme = 'screen'): void
    {

        $options = [
            'media' => $media,
            'colorScheme' => $colorScheme,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.dblclick", $options);
        $this->merge($builder);
    }

    /**
     * exec script in page context
     * @param Script $script
     */
    public function evaluate(Script $script): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.evaluate", 'function () {' . $script->getJs() . '}');

        $this->merge($builder);
    }

    /**
     *
     * exec script in page context and return data to var
     * script should contain return
     *
     * @param Script $script
     * @param string $varName
     */
    public function evaluateToVar(Script $script, string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.evaluate", 'function () {' . $script->getJs() . '}');
        $builder->toVar($varName);

        $this->merge($builder);
    }

    public function fill(string $selector, string $value, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.fill", $selector, $value, $options);
        $this->merge($builder);
    }

    public function focus(string $selector, int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.focus", $selector, $options);
        $this->merge($builder);
    }

    /**
     * Should be at least one argument.
     *
     * @param string|null $name
     * @param string|null $url
     * @return Frame
     * @throws Exception
     */
    public function frame(string $name = null, string $url = null): Frame
    {
        if ($name === null && $url === null) {
            throw new Exception('Should be at least one argument.');
        }

        $args = $name;

        if ($url !== null) {
            $args = [
                'url' => $url,
            ];
        }

        if ($name !== null) {
            $args['name'] = $name;
        }

        $frameVar = 'frame' . Vars::generateRandomVarName();

        $builder = Functions::call("$this->pageVarName.frame", $args);
        $builder->toVar($frameVar);
        $this->merge($builder);

        return new Frame($frameVar, $this->jsString);
    }

    //todo add "frames"

    /**
     * @param string $selector
     * @param string $name
     * @param string $varName
     */
    public function getAttributeToVar(string $selector, string $name, string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.getAttribute", $selector, $name);
        $builder->toVar($varName);

        $this->merge($builder);
    }

    /**
     * @param string $waitUntil "load"|"domcontentloaded"|"networkidle"
     * @param int $timeout
     */
    public function goBack(string $waitUntil = 'load', int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
            'waitUntil' => $waitUntil,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.goBack", $options);
        $this->merge($builder);
    }

    /**
     * @param string $waitUntil "load"|"domcontentloaded"|"networkidle"
     * @param int $timeout
     */
    public function goForward(string $waitUntil = 'load', int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
            'waitUntil' => $waitUntil,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.goForward", $options);
        $this->merge($builder);
    }

    /**
     * @param string $url
     * @param string|null $referer
     * @param string $waitUntil "load"|"domcontentloaded"|"networkidle"
     * @param int $timeout
     */
    public function goto(string $url, string $referer = null, string $waitUntil = 'load', int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
            'waitUntil' => $waitUntil,
        ];

        if ($referer !== null) {
            $options['referer'] = $referer;
        }

        $builder = Functions::callAwaitSafe("$this->pageVarName.goto", $url, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string[] $modifiers <Array<"Alt"|"Control"|"Meta"|"Shift">>
     * @param bool $force
     * @param int $timeout
     */
    public function hover(string $selector, array $modifiers = [], bool $force = false, int $timeout = 30000): void
    {

        $options = [
            'modifiers' => $modifiers,
            'force' => $force,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.hover", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $customVarName
     * @param int $timeout
     */
    public function innerHTMLToVar(string $selector, string $customVarName, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.innerHTML", $selector, $options);
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $customVarName
     * @param int $timeout
     */
    public function innerTextToVar(string $selector, string $customVarName, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.innerText", $selector, $options);
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

    public function isClosedToVar(string $customVarName): void
    {
        $builder = Functions::call("$this->pageVarName.isClosed");
        $builder->toVar($customVarName);
        $this->merge($builder);
    }

    public function opener(): Page
    {
        $customVarName = 'page' . Vars::generateRandomVarName();

        $builder = Functions::callAwaitSafe("$this->pageVarName.opener");
        $builder->toVar($customVarName);

        $this->merge($builder);

        return new Page($customVarName, $this->jsString);
    }

    /**
     * @param string $waitUntil "load"|"domcontentloaded"|"networkidle"
     * @param int $timeout
     */
    public function reload(string $waitUntil = 'load', int $timeout = 30000): void
    {
        $options = [
            'timeout' => $timeout,
            'waitUntil' => $waitUntil,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.reload", $options);
        $this->merge($builder);
    }

    /**
     * @param array|string[] $resourceTypes
     * @param array $allowedHosts
     * @param array $urlsToBlock
     */
    public function blockRequests(array $resourceTypes = ['image', 'stylesheet'], array $allowedHosts = [], array $urlsToBlock = []): void
    {
        $script = new Script();

        $resVarName = 'resourceTypes' . Vars::generateRandomVarName();
        $resTypes = new Builder();
        $resTypes->append(Constructions::build($resourceTypes), false, false);
        $resTypes->toVar($resVarName);
        $script->append($resTypes->getJs());

        $hostsVarName = 'allowedHosts' . Vars::generateRandomVarName();
        $hostsArr = new Builder();
        $hostsArr->append(Constructions::build($allowedHosts), false, false);
        $hostsArr->toVar($hostsVarName);
        $script->append($hostsArr->getJs(), true, false);

        $urlsToBlockVarName = 'urlsToBlock' . Vars::generateRandomVarName();
        $urlsToBlockObj = new Builder();
        $urlsToBlockObj->append(Constructions::build($urlsToBlock), false, false);
        $urlsToBlockObj->toVar($urlsToBlockVarName);
        $script->append($urlsToBlockObj->getJs(), true, false);

        $pageVarName = $this->pageVarName;

        $script->append(<<<JS
    $pageVarName.route('**', route => {
        let url = route.request().url();
        let hostname = modules.URL.parse(url).hostname;
        let doctype = route.request().resourceType();
        
        let needAbort = false;
        
        if ($resVarName.includes(doctype)) {
            needAbort = true;
        }
        
        if (!needAbort && $hostsVarName.length && !$hostsVarName.includes(hostname)) {
            needAbort = true;
        } 
        
        if (!needAbort && $urlsToBlockVarName.includes(url)) {
            needAbort = true;
        }
        
        if (needAbort) {
            route.abort('aborted');
        } else {
            route.continue();
        }
    });
    JS
        );

        $this->merge($script);
    }

    /**
     * @param string $selector
     * @param SelectOption $value
     */
    public function selectOption(string $selector, SelectOption $value): void
    {
        $this->selectOptions($selector, [$value]);
    }

    /**
     * @param string $selector
     * @param SelectOption[] $values
     */
    public function selectOptions(string $selector, array $values): void
    {

        $valuesSerialized = [];

        foreach ($values as $value) {
            $valuesSerialized[] = $value->toArray();
        }

        $builder = Functions::callAwaitSafe("$this->pageVarName.selectOption", $selector, ...$valuesSerialized);
        $this->merge($builder);
    }

    /**
     * @param Header[] $headers
     */
    public function setExtraHTTPHeaders(array $headers): void
    {

        $headersSerialized = [];

        foreach ($headers as $header) {
            $headersSerialized[] = $header->toArray();
        }

        $builder = Functions::callAwaitSafe("$this->pageVarName.setExtraHTTPHeaders", $headersSerialized);
        $this->merge($builder);
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function setViewportSize(int $width, int $height): void
    {

        $options = [
            'width' => $width,
            'height' => $height,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.setViewportSize", $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $varName
     * @param int $timeout
     */
    public function textContentToVar(string $selector, string $varName, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.textContent", $selector, $options);
        $builder->toVar($varName);
        $this->merge($builder);
    }

    /**
     * @param string $varName
     */
    public function titleToVar(string $varName): void
    {
        $builder = Functions::callAwaitSafe("$this->pageVarName.title");
        $builder->toVar($varName);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $text
     * @param int $delay
     * @param int $timeout
     */
    public function type(string $selector, string $text, int $delay = 0, int $timeout = 30000): void
    {

        $options = [
            'delay' => $delay,
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.type", $selector, $text, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param int $timeout
     */
    public function uncheck(string $selector, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.uncheck", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param int $timeout
     */
    public function check(string $selector, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.check", $selector, $options);
        $this->merge($builder);
    }

    /**
     * @param string $state <"load"|"domcontentloaded"|"networkidle">
     * @param int $timeout
     */
    public function waitForLoadState(string $state, int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.waitForLoadState", $state, $options);
        $this->merge($builder);
    }

    /**
     * @param string $waitUntil <"load"|"domcontentloaded"|"networkidle">
     * @param int $timeout
     */
    public function waitForNavigation(string $waitUntil = 'load', int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
            'waitUntil' => $waitUntil,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.waitForNavigation", $options);
        $this->merge($builder);
    }

    /**
     * @param string $selector
     * @param string $state <"attached"|"detached"|"visible"|"hidden">
     * @param int $timeout
     */
    public function waitForSelector(string $selector, string $state = 'visible', int $timeout = 30000): void
    {

        $options = [
            'timeout' => $timeout,
            'state' => $state,
        ];

        $builder = Functions::callAwaitSafe("$this->pageVarName.waitForSelector", $selector, $options);
        $this->merge($builder);
    }


}
