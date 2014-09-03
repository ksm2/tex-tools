TeX Tools for PHP
=================

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

## Usage

Create a basic PdfLaTeX job and run it:

```php
use CornyPhoenix\Tex\Jobs\LaTexJob;

$job = new LaTexJob('/path/to/my/file.tex');
$job->runPdfLaTex();
$job->hasErrors(); // False if everything went fine
```

You can also chain LaTeX calls:

```php
use CornyPhoenix\Tex\Jobs\LaTexJob;

$job = new LaTexJob('/path/to/my/file.tex');
$job->runPdfLaTex()
    ->runBibTex()
    ->runMakeIndex()
    ->runPdfLaTex()
    ->runPdfLaTex();
$job->hasErrors(); // False if everything went fine
```

Also, there is a safe `clean` method which will clean up your working directory without deleting the input file or any files not known to TeX: 

```php
use CornyPhoenix\Tex\Jobs\TexJob;

touch('/path/to/my/file.unknown.to.tex');
$job = new TexJob('/path/to/my/file.tex');
$job->clean();
assert(file_exists('/path/to/my/file.unknown.to.tex')); // True
```
