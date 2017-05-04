# PHP Curl Multi Interface

Example of how to use the multi interface feature of [curl](https://curl.haxx.se/).

## Description

Curl allows us to fill up a "pool" of curl resources that we want to process in parallel. Curl by default will process
a 10 calls at once and then picks the next resources from the pool.