<?php


use Curl\Curl;
use PlayWrightClient\Exception\ConnectionError;
use PlayWrightClient\Js\Script;

class TaskServer
{
    /**
     * @var ConnectionConfig
     */
    private $connectionConfig;

    /**
     * @var ContextConfig
     */
    private $contextConfig;

    public function __construct(ConnectionConfig $connectionConfig, ?ContextConfig $contextConfig = null)
    {
        $this->connectionConfig = $connectionConfig;

        if ($contextConfig === null) {
            $contextConfig = new ContextConfig();
        }

        $this->connectionConfig = $contextConfig;
    }

    /**
     * @return Curl
     */
    private function getCurl(): Curl
    {
        $curl = new Curl();
        if ($this->connectionConfig->inAuthNeeded()) {
            $curl->setHeader('Authorization', $this->connectionConfig->getAuthKey());
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
        $curl->post('http://' . $this->connectionConfig->getConnectionAddress() . '/task', [
            'options' => $this->contextConfig->toArray(),
            'script' => $script->getJs()
        ]);

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
        $curl->get('http://' . $this->connectionConfig->getConnectionAddress() . '/stats');

        if ($curl->error) {
            throw new ConnectionError('cant connect to server');
        }

        return $curl->response;
    }


}
