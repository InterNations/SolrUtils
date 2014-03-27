# SolrUtils [![Build Status](https://travis-ci.org/InterNations/SolrUtils.svg)](https://travis-ci.org/InterNations/SolrUtils)

`SolrUtils` help with recurring tasks when working with Solr like escaping and sanitizing user input.

```php
use InterNations\Component\Solr\Expression\Expression\Util;

// Quote a string to be used in a query
Util::quote('(term)'); // "\(term\)"

// Escape a string but not quote it
Util::escape('(term)'); // \(term\)

// Sanitize a string to be used safely in a query
Util::sanitize('term'); // term
```
