<?php

namespace CornyPhoenix\Tex\Results;

use CornyPhoenix\Tex\FileFormat;

class ErrorResult extends AbstractResult
{

    /**
     * @return string
     */
    public function getResultFormat()
    {
        return FileFormat::LOG;
    }

    /**
     * Returns true, if this result has errors.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return true;
    }
}
