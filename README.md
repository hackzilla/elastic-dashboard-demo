
# Clone repository

```bash
git clone git@github.com:hackzilla/elastic-demo.git
```

# Build

composer install -o
docker-compose build


# Start

docker-compose up -d


# Links

## App

### Dashboard
http://127.0.0.1:8888/app.php/dashboard

### Fake site
http://127.0.0.1:8888/app.php/html/

### Fake APIs
http://127.0.0.1:8888/app.php/api/

### PHP Info
http://127.0.0.1:8888/app_dev.php/_profiler/phpinfo

## Elastic

### Mapping

http://127.0.0.1:9200/tracking/_mapping?pretty

### Pipeline

http://127.0.0.1:9200/_ingest/pipeline/user_agent?pretty

### Document

http://127.0.0.1:9200/tracking/impression/1?pretty

# Finish

docker-compose down



# Ways to extend.

* Use web sockets, instead of polling.
* One request to update all widgets


# Demo

You will need to modify your docker enviroment to increase `vm.max_map_count` otherwise Elastic will refuse to start.
https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html

```bash
composer install --no-interaction --working-dir=./code;
docker-compose build;
docker-compose up -d;
./code/bin/console app:generate:impressions
```
