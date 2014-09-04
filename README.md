# TeX Tools for PHP 

[![Build Status](https://travis-ci.org/CornyPhoenix/tex-tools.svg?branch=master)](https://travis-ci.org/CornyPhoenix/tex-tools) [![Code Climate](https://codeclimate.com/github/CornyPhoenix/tex-tools/badges/gpa.svg)](https://codeclimate.com/github/CornyPhoenix/tex-tools)

> PHP library for (La)TeX abstraction

* [Installation](#installation)
* [Supported TeX Commands](#supported-tex-commands)
* [Usage](#usage)

## Installation

Add following to your `composer.json`:

```js
"require": {
    "corny-phoenix/tex-tools": "dev-master"
}
```

## Supported TeX Commands

The following TeX commands are supported:

| Command | Required format | Provided formats |
| ------- |:---------------:|:----------------:|
| TeX | `.tex` | `.dvi`, `.log`, `.aux` |
| PdfTeX | `.tex` | `.pdf`, `.log`, `.aux` |
| LaTeX | `.tex` | `.dvi`, `.log`, `.aux` |
| PdfLaTeX | `.tex` | `.pdf`, `.log`, `.aux` |
| XeLaTeX | `.tex` | `.pdf`, `.log`, `.aux` |
| LuaLaTeX | `.tex` | `.pdf`, `.log`, `.aux` |
| BibTeX | `.aux` | `.bbl`, `.blg` |
| BibTeX8 | `.aux` | `.bbl`, `.blg` |
| MakeIndex | `.idx` | `.ind`, `.ilg` |
| DviPs | `.dvi` | `.ps` |

## Usage

Create a basic PdfLaTeX job and run it:

```php
use CornyPhoenix\Tex\Repositories\TemporaryRepository;

$job = new TemporaryRepository()->createJob( /* TeX source */ );
$job->runPdfLaTex();
$job->hasErrors(); // False if everything went fine
```

You can also chain LaTeX calls:

```php
use CornyPhoenix\Tex\Repositories\TemporaryRepository;
use CornyPhoenix\Tex\Exceptions\CompilationException;

$job = new TemporaryRepository()->createJob( /* TeX source */ );
$job->runPdfLaTex()
    ->runBibTex()
    ->runMakeIndex()
    ->runPdfLaTex()
    ->runPdfLaTex();
```

There is a lovely interface for handling errors:

```php
use CornyPhoenix\Tex\Repositories\TemporaryRepository;
use CornyPhoenix\Tex\Exceptions\CompilationException;

$job = new TemporaryRepository()->createJob( /* TeX source */ );
try {
    $job->runPdfLaTex()
        ->runBibTex()
        ->runMakeIndex()
        ->runPdfLaTex()
        ->runPdfLaTex();
} catch (CompilationException $e) {
    $format = 'Error in %s, line %d: %s';
    $log = $job->getLog();
    
    foreach ($log->getErrors() as $error) {
        echo sprintf(
            $format, 
            $error->getFilename(),
            $error->getLine(),
            $error->getMessage()
        );
        // handle error ...
    }
}
```

Also, there is a safe `clean` method which will clean up your working directory without deleting the input file or any files unknown to TeX: 

```php
use CornyPhoenix\Tex\Repositories\TemporaryRepository;

$repo = new TemporaryRepository();
touch($repo->getDirectory() . '/file.unknown.to.tex');
$repo->clean();
assert(file_exists($repo->getDirectory() . '/file.unknown.to.tex')); // True
```
