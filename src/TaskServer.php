<?php


use Curl\Curl;
use PlayWrightClient\Exception\ConnectionError;
use PlayWrightClient\Js\Script;

class TaskServer
{
    /**
     * @var ConnectionConfig
     */
    private $config;

    public function __construct(ConnectionConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return Curl
     */
    private function getCurl(): Curl
    {
        $curl = new Curl();
        if ($this->config->inAuthNeeded()) {
            $curl->setHeader('Authorization', $this->config->getAuthKey());
        }

        return $curl;
    }

    /**
     * @param Script $script
     * @return TaskResponse
     * @throws ConnectionError
     */
    public function runTask(Script $script): TaskResponse
    {
        $curl = $this->getCurl();
        $curl->setTimeout($script->getTimeout());
        $curl->setHeader('Content-Type', 'application/x-www-form-urlencoded');
        $curl->post('http://' . $this->config->getConnectionAddress() . '/task', ['script' => $script->getJs()]);

        if ($curl->error) {
            throw new ConnectionError('cant connect to server');
        }

        return new TaskResponse($curl->response);
    }

    //todo implement stats object
    /**
     * Array of some stats
     * @return array
     * @throws ConnectionError
     */
    public function getStats(): array
    {
        $curl = $this->getCurl();
        $curl->get('http://' . $this->config->getConnectionAddress() . '/stats');

        if ($curl->error) {
            throw new ConnectionError('cant connect to server');
        }

        return $curl->response;
    }


}
