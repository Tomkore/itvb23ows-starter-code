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
                sh 'docker-compose down'
                sh 'docker-compose up -d'
            }
        }

//         stage('SonarQube Analysis') {
//             steps {
//                 script {
//                     def sonarScannerHome = tool 'SQ'
//                     withSonarQubeEnv('SQ') {
//                         sh "${sonarScannerHome}/bin/sonar-scanner"
//                     }
//                 }
//             }
//         }

        // Je kunt meer stages toevoegen voor testen, linting, etc.
    }

    post {
        always {
            // Stappen die uitgevoerd moeten worden na de pipeline, ongeacht of deze slaagt of faalt.
            echo 'De pipeline is afgerond.'
        }
    }
}
