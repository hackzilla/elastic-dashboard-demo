FROM docker.elastic.co/elasticsearch/elasticsearch:5.3.1

ENV xpack.security.enabled false
ENV xpack.monitoring.enabled false

RUN bin/elasticsearch-plugin install ingest-user-agent
#RUN sysctl -w vm.max_map_count=262144
