<?php

namespace CornyPhoenix\Tex\Executables\LaTex;

use CornyPhoenix\Tex\Executables\Tex\TexExecutable;

class LaTexExecutable extends TexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'latex';
    }
}
