pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Haalt code op uit je Git repository
                git url: 'https://github.com/Tomkore/itvb23ows-starter-code.git', branch: 'Jenkins-sonarqube-containers'
            }
        }

        stage('docker') {
                    steps {
                        // Voer een script of build commando uit
                        sh 'FROM jenkins/jenkins:lts
                            USER root
                            RUN apt-get update && \
                                apt-get -y install apt-transport-https \
                                                   ca-certificates \
                                                   curl \
                                                   gnupg2 \
                                                   software-properties-common && \
                                curl -fsSL https://download.docker.com/linux/debian/gpg | apt-key add - && \
                                add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/debian $(lsb_release -cs) stable" && \
                                apt-get update && \
                                apt-get -y install docker-ce docker-ce-cli containerd.io && \
                                curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
                                chmod +x /usr/local/bin/docker-compose
                            USER jenkins'
                    }
                }

        stage('Build') {
            steps {
                // Voer een script of build commando uit
                sh 'docker-compose up -d'
            }
        }

        // Je kunt meer stages toevoegen voor testen, linting, etc.
    }

    post {
        always {
            // Stappen die uitgevoerd moeten worden na de pipeline, ongeacht of deze slaagt of faalt.
            echo 'De pipeline is afgerond.'
        }
    }
}
