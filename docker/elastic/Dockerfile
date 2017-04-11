FROM docker.elastic.co/elasticsearch/elasticsearch:5.3.0

ENV xpack.security.enabled false
ENV xpack.monitoring.enabled false

RUN bin/elasticsearch-plugin install ingest-user-agent
