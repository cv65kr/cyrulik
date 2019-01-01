FROM openjdk:10-jre-slim

RUN apt update && apt-get install -y curl

EXPOSE 8882

HEALTHCHECK --interval=30s --timeout=10s --retries=3 CMD curl -f http://127.0.0.1:8882/actuator/health

ADD monitoring-1.0.0.jar app.jar
ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]