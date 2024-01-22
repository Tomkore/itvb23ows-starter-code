pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Haalt code op uit je Git repository
                git url: 'https://github.com/Tomkore/itvb23ows-starter-code.git', branch: 'Jenkins-sonarqube-containers'
            }
        }



        stage('Build') {
            steps {
                // Voer een script of build commando uit
                sh 'docker-compose up -d'
            }
        }

        stage('SonarQube Analysis') {
            steps {
                script {
                    scannerHome = tool 'SonarQube-Scanner-Mohamed'
                        withSonarQubeEnv('SonarQube-Server-Mohamed') {
                            sh "${scannerHome}/bin/sonar-scanner -Dsonar.projectKey=Mohamed -Dsonar.login=squ_2d93c700f7e12f75f4d3aa87f7ab13ea1d5cdf7d"
                    }
                }
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
