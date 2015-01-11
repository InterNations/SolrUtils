# SolrUtils

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/InterNations/SolrUtils?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://travis-ci.org/InterNations/SolrUtils.svg)](https://travis-ci.org/InterNations/SolrUtils) [![Dependency Status](https://www.versioneye.com/user/projects/5347af3ffe0d072109000231/badge.png)](https://www.versioneye.com/user/projects/5347af3ffe0d072109000231) [![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/InterNations/SolrUtils.svg)](http://isitmaintained.com/project/InterNations/SolrUtils "Average time to resolve an issue") [![Percentage of issues still open](http://isitmaintained.com/badge/open/InterNations/SolrUtils.svg)](http://isitmaintained.com/project/InterNations/SolrUtils "Percentage of issues still open")

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
