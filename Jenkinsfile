pipeline {
    agent any
    stages {
        stage('Build'){
            steps{
                sh "sudo docker build . -t flask_app:latest"
                 }
            }
        stage('run_container') {
            sh "sudo docker run -d -p 5000:5000 flask_app:latest"
        }
        stage('test'){ sh "echo test stage"}
        stage('push-image'){sh "echo push-image"}
        }
}
