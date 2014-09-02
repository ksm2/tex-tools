<?php

namespace CornyPhoenix\Tex\Results;

use CornyPhoenix\Tex\FileFormat;

class ErrorResult implements ResultInterface
{

    /**
     * @return string
     */
    public function getResultFormat()
    {
        return FileFormat::LOG;
    }
}
