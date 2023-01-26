# Optimizing Drupal to load faster (Server, MySQL, caching, theming, HTML)

## Caching

- Internal Page Cache 
- Internal Dynamic Page Caching
- Memcache / Redis Implementation
- Effective Drupal Custom caching implementation using Cache API
- We should know when to clear cache and which cache bin should be cleared?

## APM (Application Performance Monitoring)

- There should be some way to measure the performance of a drupal application.
- One of the most comprehensive and easy to use tools is Google’s PageSpeed Insights tool. This tool can very quickly and clearly highlight potential performance improvements that apply for your site.
- Some tools like - New Relic, BlackFire can be really helpful in analysing and working on the fixes required for performance improvement.

### Backend Analysis

- Code flow
- Listing pages
- Node loads
- Custom queries to fetch data.
- Uncached custom implementations

### Frontend Analysis

- CSS/JS aggregation
- No processing / compression done on images
- Attaching heavy assets on to the page

## Drupal Coding Standards 

- Drupal PHP Coding Standards
- Drupal CSS/JS Coding Standards

## CDN

- What is it? Why should you use it?
- What if we don't use any CDN?

## Code Security Should be taken care of!

## Other Important Performance Improvement Metrics

- API associated data - When to fetch fresh data, how to store the data & how to maintain the data?
- Contributed Modules used on the website.
- Drupal Version & PHP version to be updated, similarly all third party libraries used on the website.
- Database Table Indexing.