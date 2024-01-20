# Gebruik de officiële Jenkins LTS image als basis
FROM jenkins/jenkins:lts

# Wissel naar de root-gebruiker om software te kunnen installeren
USER root

# Installeer Docker CLI en Docker Compose
RUN curl -fsSL https://get.docker.com -o get-docker.sh && sh get-docker.sh
RUN curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
RUN chmod +x /usr/local/bin/docker-compose

# Schakel terug naar de Jenkins-gebruiker
USER jenkins
