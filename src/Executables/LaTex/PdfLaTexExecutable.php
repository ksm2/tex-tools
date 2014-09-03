<?php

namespace CornyPhoenix\Tex\Executables\LaTex;

use CornyPhoenix\Tex\Executables\Tex\PdfTexExecutable;

class PdfLaTexExecutable extends PdfTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'pdflatex';
    }
}
