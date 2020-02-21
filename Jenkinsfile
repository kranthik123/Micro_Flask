pipeline {
    options { disableConcurrentBuilds() }
    agent any
    stages {
        stage('cleanup'){steps{sh "sudo docker stop $(sudo docker ps -a -q)"}}
        stage('Build'){steps{sh "sudo docker build . -t flask_app:latest"}}
        stage('run_container') {steps{sh "sudo docker run -d -p 5000:5000 flask_app:latest"}}
        stage('test'){ steps {sh "echo test stage"}}
        stage('push-image'){steps{sh "echo push-image"}}
        }
}
