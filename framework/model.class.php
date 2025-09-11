<?php

class JLModel
{
    protected array $_params;
    protected array $_data;
    protected array $_lists;
    protected array $_messages;

    public function __construct()
    {
        $this->_params   = [];
        $this->_data     = [];
        $this->_lists    = [];
        $this->_messages = [];
    }
}
