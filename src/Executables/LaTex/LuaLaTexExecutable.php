<?php

namespace CornyPhoenix\Tex\Executables\LaTex;

class LuaLaTexExecutable extends PdfLaTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'lualatex';
    }

    /**
     * @return string
     */
    public function getOptionPrefix()
    {
        return '--';
    }
}
