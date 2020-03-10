pipeline {
    options { disableConcurrentBuilds() }
    agent any
    environment {
        PROJECT_ID = 'reliable-brace-268207'
        CLUSTER_NAME = 'ibc-gke-dev'
        CREDENTIALS_ID = 'reliable-brace-gcr-credentials'
        LOCATION = 'us-central1-a'
        ANCHORE_CLI_URL='http://localhost:8228/v1'
        ANCHORE_CLI_USER='admin'
        ANCHORE_CLI_PASS='foobar'

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
                        sh "/opt/SonarScanner/sonar-scanner/bin/sonar-scanner -X -Dproject.settings=sonar-project.properties -Dsonar.projectVersion=${env.BUILD_ID}"
                    }
//                    timeout(time: 10, unit: 'MINUTES') {
//                        waitForQualityGate(webhookSecretId: 'Micro_Flask_Webhook_Secret') abortPipeline: true
//                    }
                }
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
              echo "Deploying to Dev Kubernetes namespace completed successfully."
            }
        }
        stage('Trivy - Container Security Scanner') {
            steps{
                sh "/usr/local/bin/trivy kranthik123/flask_app:${env.BUILD_ID}"
                }
            }
//        stage('Anchore - Container Vulnerability Scanner') {
//            steps {
//                sh 'set'
//                script {
//                    echo "Starting Anchore containers"
//                    sh "cd /aevolume && sudo docker-compose up -d"
//                    sleep 60
////                    export PATH=/usr/local/bin:$PATH
//                    echo "checking connection to Anchore"
//                    sh "anchore-cli --url http://localhost:8228/v1 --u admin --p foobar system status"
//                    echo "Starting Anchore container vulnerability scanner"
//                    sh "anchore-cli image add kranthik123/flask_app:${env.BUILD_ID}"
//                    sh "anchore-cli image wait kranthik123/flask_app:${env.BUILD_ID}"
//                    sleep 10
//                    sh "anchore-cli image vuln kranthik123/flask_app:${env.BUILD_ID} os"
//                    sh "anchore-cli evaluate check kranthik123/flask_app:${env.BUILD_ID} --detail"
//                }
//            }
//        }
        stage('promote-to-stage') {
            steps{
                timeout(time: 10, unit: "MINUTES") {
                    input message: 'Do you want to approve the deploy in Stage?', ok: 'Yes'
                }
            }
        }
        stage('Deploy-To-stage') {
            steps {
                sh "cd \$WORKSPACE/manifests && pwd && ls -l && cat stage_deployment.yaml && sed -i 's/flask_app:latest/flask_app:${env.BUILD_ID}/g' \$WORKSPACE/manifests/stage_deployment.yaml"
                sh "cat \$WORKSPACE/manifests/stage_deployment.yaml"
                echo "Deploying to Stage Kubernetes namespace."
                step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: "manifests/stage_deployment.yaml", credentialsId: env.CREDENTIALS_ID, verifyDeployments: false])
                echo "Deploying to Stage Kubernetes namespace completed successfully."
            }
        }
        stage('promote-to-prod') {
            steps{
                // Input Step
                timeout(time: 10, unit: "MINUTES") {
                    input message: 'Do you want to approve the deployment to production?', ok: 'Yes'
                }
            }
        }
        stage('Deploy-To-prod') {
            steps {
                sh "cd \$WORKSPACE/manifests && pwd && ls -l && cat prod_deployment.yaml && sed -i 's/flask_app:latest/flask_app:${env.BUILD_ID}/g' \$WORKSPACE/manifests/prod_deployment.yaml"
                sh "cat \$WORKSPACE/manifests/prod_deployment.yaml"
                echo "Deploying to Prod Kubernetes namespace."
                step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: "manifests/prod_deployment.yaml", credentialsId: env.CREDENTIALS_ID, verifyDeployments: false])
                echo "Deploying to Prod Kubernetes namespace completed successfully."
            }
        }
    }
      post {
        always {echo 'The job completed running.'}
        success {echo 'The job run was successful.'}
        failure {echo 'The job run was unsuccessful.'}
        unstable {echo 'The Job run but marked as unstable'}
            }
  }
//===================================