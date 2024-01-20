pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Haalt code op uit je Git repository
                git url: 'https://github.com/Tomkore/itvb23ows-starter-code.git', branch: 'Jenkins-sonarqube-containers'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withCredentials([string(credentialsId: 'sonarqube-token', variable: 'SONAR_TOKEN')]) {
                    sh 'sonar-scanner -Dsonar.projectKey=my_project_key -Dsonar.sources=. -Dsonar.host.url=http://mysonarqube.example.com -Dsonar.login=$SONAR_TOKEN'
                }
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
