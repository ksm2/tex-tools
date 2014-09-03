<?php

namespace CornyPhoenix\Tex\Executables\LaTex;

class XeLaTexExecutable extends PdfLaTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'xelatex';
    }
}
