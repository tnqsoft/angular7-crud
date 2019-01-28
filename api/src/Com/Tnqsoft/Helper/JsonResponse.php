<?php

namespace Com\Tnqsoft\Helper;

class JsonResponse extends Response
{
    public function response()
    {
        $this->setContentType('application/json');
        $this->setContent(json_encode($this->getContent()));

        parent::response();
    }

    public function __toString()
    {
        $this->setContentType('application/json');
        $this->setContent(json_encode($this->getContent()));

        return parent::__toString();
    }
}
