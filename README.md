# Boatrace Scraper

[![Build Status](https://github.com/BoatraceVentureProject/BoatraceScraper/workflows/Tests/badge.svg)](https://github.com/BoatraceVentureProject/BoatraceScraper/actions?query=workflow%3Atests)
[![codecov](https://codecov.io/gh/BoatraceVentureProject/BoatraceScraper/graph/badge.svg?token=Tt8DGtX4fc)](https://codecov.io/gh/BoatraceVentureProject/BoatraceScraper)
[![Latest Stable Version](https://poser.pugx.org/bvp/boatrace-scraper/v/stable)](https://packagist.org/packages/bvp/boatrace-scraper)
[![Latest Unstable Version](https://poser.pugx.org/bvp/boatrace-scraper/v/unstable)](https://packagist.org/packages/bvp/boatrace-scraper)
[![License](https://poser.pugx.org/bvp/boatrace-scraper/license)](https://packagist.org/packages/bvp/boatrace-scraper)

## Installation
```bash
composer require bvp/boatrace-scraper
```

## Usage
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use BVP\BoatraceScraper\Scraper;

var_dump(Scraper::programs('2017-03-31'));        // 2017年03月31日の出走表
var_dump(Scraper::programs('2017-03-31', 24));    // 2017年03月31日 大村の出走表
var_dump(Scraper::programs('2017-03-31', 24, 1)); // 2017年03月31日 大村 1Rの出走表

var_dump(Scraper::previews('2017-03-31'));        // 2017年03月31日の直前情報
var_dump(Scraper::previews('2017-03-31', 24));    // 2017年03月31日 大村の直前情報
var_dump(Scraper::previews('2017-03-31', 24, 1)); // 2017年03月31日 大村 1Rの直前情報

var_dump(Scraper::results('2017-03-31'));         // 2017年03月31日の結果
var_dump(Scraper::results('2017-03-31', 24));     // 2017年03月31日 大村の結果
var_dump(Scraper::results('2017-03-31', 24, 1));  // 2017年03月31日 大村 1Rの結果

var_dump(Scraper::oddses('2017-03-31'));          // 2017年03月31日のオッズ
var_dump(Scraper::oddses('2017-03-31', 24));      // 2017年03月31日 大村のオッズ
var_dump(Scraper::oddses('2017-03-31', 24, 1));   // 2017年03月31日 大村 1Rのオッズ

var_dump(Scraper::stadiums('2017-03-31'));        // 2017年03月31日の開催場
var_dump(Scraper::stadiumIds('2017-03-31'));      // 2017年03月31日の開催場
var_dump(Scraper::stadiumNames('2017-03-31'));    // 2017年03月31日の開催場
```

## License
The BVP Boatrace Scraper package is open source software licensed under the [MIT license](LICENSE).
