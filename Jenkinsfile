pipeline {
    options { disableConcurrentBuilds() }
    agent any
    stages {
        stage('cleanup'){steps{sh "sudo docker stop \$(sudo docker ps -a -q)"}}
        stage('Build'){steps{sh "sudo docker build . -t flask_app:latest"}}
        stage('run_container') {steps{sh "sudo docker run -d -p 5000:5000 flask_app:latest"}}
        stage('build-test'){ steps { withPythonEnv('python3') {sh "cd \$WORKSPACE/app && pip install -r requirements.txt && nose2 -v --with-coverage"}}}
        stage('push-image'){steps{withCredentials([[$class: 'UsernamePasswordMultiBinding', credentialsId: 'DockerHubCreds', usernameVariable: 'USERNAME', passwordVariable: 'PASSWORD']]) {println(env.USERNAME)}}}
        stage('Deploy-Dev'){steps{sh "echo Deploy-Dev"}}
        stage('Test-Dev'){steps{sh "echo Test-Dev"}}
        stage('Deploy-stage'){steps{sh "echo Deploy-stage"}}
        stage('Test-stage'){steps{sh "echo Test-stage"}}
        stage('Code-Coverage'){steps{sh "echo Code-Coverage"}}
        stage('Approval-to-prod'){steps{sh "echo Approval-to-prod"}}
        stage('Deploy-prod'){steps{sh "echo Deploy-prod"}}
        }
}
