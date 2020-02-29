pipeline {
    options { disableConcurrentBuilds() }
    agent any
    environment {
        PROJECT_ID = 'reliable-brace-268207'
        CLUSTER_NAME = 'ibc-gke-dev'
        CREDENTIALS_ID = 'reliable-brace-gcr-credentials'
    }
    stages {
        stage('cleanup') {
            steps {
                script{
                    echo "Stopping any old container to release ports needs for the new builds"
                    sleep 5
                    sh "docker stop \$(docker ps -q)"
                    sleep 5
                }
            }
        }
        stage('Build') {
            steps {
                script {
                    echo "Building Docoker image"
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
                script{
                    sh "cd \$WORKSPACE/manifests && pwd && ls -l && sed -i 's/kranthik123:latest/kranthik123:${env.BUILD_ID}/g' dev_deployment.yaml"
                    sh "cat dev_deployment.yaml"
                    echo "Deploying to Dev Kubernetes namespace"
                }
            }
        }
        stage('Test-Dev') { steps { sh "echo Test-Dev" } }
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
//stage('Deploy to GKE') {
//    steps{
//        sh "sed -i 's/hello:latest/hello:${env.BUILD_ID}/g' deployment.yaml"
//        step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: 'deployment.yaml', credentialsId: env.CREDENTIALS_ID, verifyDeployments: true])
//    }
//}