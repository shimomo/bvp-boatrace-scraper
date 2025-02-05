# Crawler

[![Build Status](https://github.com/BoatraceVentureProject/Crawler/workflows/Tests/badge.svg)](https://github.com/BoatraceVentureProject/Crawler/actions?query=workflow%3Atests)
[![codecov](https://codecov.io/gh/BoatraceVentureProject/Crawler/graph/badge.svg?token=ASXRLEJBDV)](https://codecov.io/gh/BoatraceVentureProject/Crawler)
[![Latest Stable Version](https://poser.pugx.org/bvp/crawler/v/stable)](https://packagist.org/packages/bvp/crawler)
[![Latest Unstable Version](https://poser.pugx.org/bvp/crawler/v/unstable)](https://packagist.org/packages/bvp/crawler)
[![License](https://poser.pugx.org/bvp/crawler/license)](https://packagist.org/packages/bvp/crawler)

## Installation
```bash
composer require bvp/crawler
```

## Usage
```php
<?php

require __DIR__ . '/vendor/autoload.php';

use Boatrace\Venture\Project\Crawler;

var_dump(Crawler::programs('2017-03-31'));        // 2017年03月31日の出走表
var_dump(Crawler::programs('2017-03-31', 24));    // 2017年03月31日 大村の出走表
var_dump(Crawler::programs('2017-03-31', 24, 1)); // 2017年03月31日 大村 1Rの出走表

var_dump(Crawler::previews('2017-03-31'));        // 2017年03月31日の直前情報
var_dump(Crawler::previews('2017-03-31', 24));    // 2017年03月31日 大村の直前情報
var_dump(Crawler::previews('2017-03-31', 24, 1)); // 2017年03月31日 大村 1Rの直前情報

var_dump(Crawler::results('2017-03-31'));         // 2017年03月31日の結果
var_dump(Crawler::results('2017-03-31', 24));     // 2017年03月31日 大村の結果
var_dump(Crawler::results('2017-03-31', 24, 1));  // 2017年03月31日 大村 1Rの結果

var_dump(Crawler::oddses('2017-03-31'));          // 2017年03月31日のオッズ
var_dump(Crawler::oddses('2017-03-31', 24));      // 2017年03月31日 大村のオッズ
var_dump(Crawler::oddses('2017-03-31', 24, 1));   // 2017年03月31日 大村 1Rのオッズ

var_dump(Crawler::stadiums('2017-03-31'));        // 2017年03月31日の開催場
var_dump(Crawler::stadiumIds('2017-03-31'));      // 2017年03月31日の開催場
var_dump(Crawler::stadiumNames('2017-03-31'));    // 2017年03月31日の開催場
```

## License
The Crawler is open source software licensed under the [MIT license](LICENSE).
