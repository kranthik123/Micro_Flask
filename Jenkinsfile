pipeline {
    options { disableConcurrentBuilds() }
    agent any
    environment {
        PROJECT_ID = 'reliable-brace-268207'
        CLUSTER_NAME = 'ibc-gke-dev'
        CREDENTIALS_ID = 'reliable-brace-gcr-credentials'
        LOCATION = 'us-central1-a'
    }
    stages {
        stage('cleanup') {
            steps {
                script{
                    echo "Stopping any old container to release ports needs for the new builds"
                    sleep 5
                    sh "docker stop \$(docker ps -q) 2>/dev/null || true"
                    sleep 5
                }
            }
        }
        stage('Build') {
            steps {
                script {
                    echo "Building Docker image"
                    sleep 5
                    myapp = docker.build("kranthik123/flask_app:${env.BUILD_ID}")
                    sleep 5
                }
            }
        }
        stage('run_container') {
            steps {
                script{
                    echo "Starting Docker Container locally for testing the build"
                    sleep 5
                    sh "docker run -d -p 5000:5000 kranthik123/flask_app:${env.BUILD_ID}"
                    sleep 5
                }
            }
        }
        stage('SonarQube Scanner'){
            steps{
                script{
                    withSonarQubeEnv('SonarQube_Server') {
                        sh "pwd & ls -l"
                        sh "/opt/SonarScanner/sonar-scanner/bin/sonar-scanner -X -Dproject.settings=sonar-project.properties"
                    }
                    timeout(time: 10, unit: 'MINUTES') {
                        waitForQualityGate(webhookSecretId: 'Micro_Flask_Webhook_Secret') abortPipeline: true
                    }
                }
            }
        }
        stage('Dynamic Vulnerability Scanner') {
            steps{
                echo "Dynamic Vulnerability Scanner"
            }
        }
        stage('build-test') {
            steps {
                withPythonEnv('python3') {
                    echo "Testing the new build to validate code and provide test coverage"
                    sh "cd \$WORKSPACE/app && pip install -r requirements.txt && nose2 -v --with-coverage"
                }
            }
        }
        stage('BDD-test') {
            steps {
                script {
                    sh "docker run -d kranthik123/bdd_py3_test_suite:v01"
                    sh "docker logs --follow \$(docker ps -l -q)"
                }
            }
        }
        stage('push-image') {
            steps {
                script {
                    docker.withRegistry('https://registry.hub.docker.com', 'DockerHubCreds') {
                        myapp.push("latest")
                        myapp.push("${env.BUILD_ID}")
                    }
                }
            }
        }
        stage('Deploy-To-Dev') {
            steps {
              sh "cd \$WORKSPACE/manifests && pwd && ls -l && cat dev_deployment.yaml && sed -i 's/flask_app:latest/flask_app:${env.BUILD_ID}/g' \$WORKSPACE/manifests/dev_deployment.yaml"
              sh "cat \$WORKSPACE/manifests/dev_deployment.yaml"
              echo "Deploying to Dev Kubernetes namespace"
              step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: "manifests/dev_deployment.yaml", credentialsId: env.CREDENTIALS_ID, verifyDeployments: false])
            }
        }
        stage('Test-Dev') { steps { sh "echo Test-Dev" } }
        stage('promote-to-stage') {
            steps{
                // Input Step
                timeout(time: 1, unit: "MINUTES") {
                    input message: 'Do you want to approve the deploy in Stage?', ok: 'Yes'
                }
            }
        }
        stage('Deploy-stage') { steps { sh "echo Deploy-stage" } }
        stage('Test-stage') { steps { sh "echo Test-stage" } }
        stage('Code-Coverage') { steps { sh "echo Code-Coverage" } }
        stage('Static-Code-Analysis') { steps { sh "echo Static-Code-Analysis" } }
        stage('Approval-to-prod') { steps { sh "echo Approval-to-prod" } }
        stage('Deploy-prod') { steps { sh "echo Deploy-prod" } }
    }
      post {
        always {echo 'This will always run'}
        success {echo 'This will run only if successful'}
        failure {echo 'This will run only if failed'}
        unstable {echo 'This will run only if the run was marked as unstable'}
        changed {
            echo 'This will run only if the state of the Pipeline has changed'
            echo 'For example, if the Pipeline was previously failing but is now successful example'
            }
            }
  }

//===================================
//stage('SonarQube analysis') {
//    def scannerHome = tool 'SonarScanner 4.0';
//    withSonarQubeEnv('SonarQube_Server') { // If you have configured more than one global server connection, you can specify its name
//        sh "${sonarqube-scanner}/bin/sonar-scanner"
//    }
//}

//stage('Sonarqube') {
//    environment {
//        scannerHome = tool 'SonarQubeScanner'
//    }
//    steps {
//        withSonarQubeEnv('sonarqube') {
//            sh "${scannerHome}/bin/sonar-scanner"
//        }
//        timeout(time: 10, unit: 'MINUTES') {
//            waitForQualityGate abortPipeline: true
//        }
//    }
//}