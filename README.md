TeX Tools for PHP
=================

PHP library for (La)TeX abstraction

## Installation

Add following to your `composer.json`:

```js
"require": {
    "corny-phoenix/tex-tools": "dev-master"
}
```


## Usage

Create a basic PdfLaTeX job and run it:

```php
use CornyPhoenix\Tex\LaTexJob;

$job = new LaTexJob('/path/to/my/file.tex');
$job->runPdfLaTex();
$job->hasErrors(); // False if everything went fine
```

You can also chain LaTeX calls:

```php
use CornyPhoenix\Tex\LaTexJob;

$job = new LaTexJob('/path/to/my/file.tex');
$job->runPdfLaTex()
    ->runBibTex()
    ->runMakeIndex()
    ->runPdfLaTex()
    ->runPdfLaTex();
$job->hasErrors(); // False if everything went fine
```
