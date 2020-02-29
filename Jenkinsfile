pipeline {
    options { disableConcurrentBuilds() }
    agent any
    environment {
        TEST = "TEST"
    }
    stages {
        stage('cleanup') {
            steps {
                sh "sudo docker stop \$(sudo docker ps -a -q)"
            }
        }
        stage('Build') {
            steps {
                script {
                    myapp = sudo docker.build("kranthik123/flask_app:${env.BUILD_ID}")
                }
            }
        }
        stage('run_container') {
            steps {
                sh "sudo docker run -d -p 5000:5000 kranthik123/flask_app:latest"
            }
        }
        stage('build-test') {
            steps {
                withPythonEnv('python3') {
                    sh "cd \$WORKSPACE/app && pip install -r requirements.txt && nose2 -v --with-coverage"
                }
            }
        }
        stage('BDD-test') {
            steps {
                withCredentials([[$class: 'UsernamePasswordMultiBinding', credentialsId: 'DockerHubCreds', usernameVariable: 'USERNAME', passwordVariable: 'PASSWORD']])
                        {
                            sh "sudo docker login -u '${USERNAME}' -p '${PASSWORD}'"
                            sh "sudo docker run -d '${USERNAME}'/bdd_py3_test_suite:v01"
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
//                withCredentials([[$class: 'UsernamePasswordMultiBinding', credentialsId: 'DockerHubCreds', usernameVariable: 'USERNAME', passwordVariable: 'PASSWORD']])
//                {
//                    sh "sudo docker login -u '${USERNAME}' -p '${PASSWORD}'"
//                    sh "sudo docker push '${USERNAME}'/flask_app:latest"
//                }
            }
        }
        stage('Deploy-Dev') { steps { sh "echo Deploy-Dev" } }
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
//
//stage("Push image") {
//    steps {
//        script {
//            docker.withRegistry('https://registry.hub.docker.com', 'dockerhub') {
//                myapp.push("latest")
//                myapp.push("${env.BUILD_ID}")
//            }
//        }
//    }
//}
//
//stage('Deploy to GKE') {
//    steps{
//        sh "sed -i 's/hello:latest/hello:${env.BUILD_ID}/g' deployment.yaml"
//        step([$class: 'KubernetesEngineBuilder', projectId: env.PROJECT_ID, clusterName: env.CLUSTER_NAME, location: env.LOCATION, manifestPattern: 'deployment.yaml', credentialsId: env.CREDENTIALS_ID, verifyDeployments: true])
//    }
//}