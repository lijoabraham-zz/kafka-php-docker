FROM bitnami/kafka:2.3.0
USER root
RUN apt-get update
RUN apt-get install -y less nano vim
COPY server-1.properties /opt/bitnami/kafka/config/server-1.properties
COPY server-2.properties /opt/bitnami/kafka/config/server-2.properties
COPY server-3.properties /opt/bitnami/kafka/config/server-3.properties
USER 1001

