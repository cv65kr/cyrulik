FROM openjdk:10-jre-slim

EXPOSE 5001

ADD subscription-1.0.0.jar app.jar
ENTRYPOINT ["java","-Djava.security.egd=file:/dev/./urandom","-jar","/app.jar"]