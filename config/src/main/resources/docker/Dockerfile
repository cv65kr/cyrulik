FROM openjdk:10-jre-slim

EXPOSE 8880

ADD config-1.0.0.jar app.jar
ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]