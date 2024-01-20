pipeline {
    agent any

    stages {
         stage('Checkout') {
            steps {
                // Haalt code op uit je Git repository
                git url: 'https://github.com/Tomkore/itvb23ows-starter-code.git', branch: 'Jenkins-sonarqube-containers'
            }
        }

        stage('docker compose') {
            steps {
                sh chmod +x /var/jenkins_home/docker-compose
                sh  "curl -L https://github.com/docker/compose/releases/download/1.25.3/run.sh -o /usr/local/bin/docker-compose"
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
