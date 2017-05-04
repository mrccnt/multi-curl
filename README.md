# PHP Curl Multi Interface

Example of how to use the multi interface feature of [curl](https://curl.haxx.se/).

# Usage

This will build a stack of 15 curl resources and will execute them via the multi interface. As a result you will get the
called url and the returned status code. As those requests are async, they return in order of the incoming responses.

    $ composer install
    $ php multicurl.php
      
    https://example.com/?testvar=7 => 200
    https://example.com/?testvar=11 => 200
    https://example.com/?testvar=9 => 200
    https://example.com/?testvar=10 => 200
    https://example.com/?testvar=12 => 200
    https://example.com/?testvar=14 => 200
    https://example.com/?testvar=13 => 200
    https://example.com/?testvar=0 => 200
    https://example.com/?testvar=1 => 200
    https://example.com/?testvar=2 => 200
    https://example.com/?testvar=3 => 200
    https://example.com/?testvar=6 => 200
    https://example.com/?testvar=4 => 200
    https://example.com/?testvar=5 => 200
    https://example.com/?testvar=8 => 200
    
    Execution Time: 1.24075603 sec
