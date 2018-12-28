# WIP Cyrulik

Skeleton for modern SASS (Software as a Service) aplication. Based on Spring, uses microservices architecture.

## Stack

Spring, Docker, Ribbon, Zuul, Turbine, Eureka, Zipkin, Kafka, Redis, Hystrix, Cassandra, Zookeeper,

## Infrastructure services

### Endpoints

Eureka - http://127.0.0.1:8761/

Gateway - http://127.0.0.1:5002/

Turbine - http://127.0.0.1:8881/

Hystrix - http://127.0.0.1:8882/

Zipkin - http://127.0.0.1:9411/

### Running

First of all prepare all necessary jar files.

```
mvn clean package -DskipTests
```

Run compontents:

```
docker-compose up -d --force
```

For now I run app by Intellij IDEA `run dashboard`. In the near future I will try add first point from TODO section.


### Tools

In folder tools, You will find useful tools to testing app, or her deployment.

## Todo (Random order)

- [ ] Docker for services - https://github.com/spotify/docker-maven-plugin
- [ ] Frontend sample app with admin control panel - https://bulma.io/
- [ ] Online demo - https://kubernetes.io/
- [ ] TDD
- [ ] CI
- [ ] Kafka consumer (eg. notifications sent)
- [ ] Register using social media
- [ ] Security things
- [ ] Fallbacks
- [ ] Consul instead of Eureka (??)
- [ ] Sample mobile apps (Android/IOS) Maybe https://flutter.io/
- [ ] ELK stack

Any ideas? Create PR.
