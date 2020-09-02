<?php


class TaskResponse
{
    private $response;

    public function __construct(object $response)
    {
        $this->response = $response;
    }

    public function isSuccess(): bool
    {
        return $this->response->status === 'DONE';
    }

    public function getData(): ?object
    {
        return $this->response->data ?? null;
    }

    public function getCreatedAt(): ?int
    {
        if (!isset($this->response->metadata->created_at)) {
            return null;
        }

        return (int)($this->response->metadata->created_at / 1000);
    }

    public function getRunedAt(): ?int
    {
        if (!isset($this->response->metadata->runed_at)) {
            return null;
        }

        return (int)($this->response->metadata->runed_at / 1000);
    }

    public function getDoneAt(): ?int
    {
        if (!isset($this->response->metadata->done_at)) {
            return null;
        }
        return (int)($this->response->metadata->done_at / 1000);
    }


}
