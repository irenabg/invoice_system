pipeline {
  agent any
  stages {
    stage('Build') {
      steps {
        echo 'This is the Build Stage'
        sh '''cd /var/lib/jenkins/workspace/kosherkaddy_master
set +x
sudo git clean -fdx
set -x
sudo docker-compose -f docker-compose-production.yml up --build -d
sudo docker exec kosherkaddy_master_php_1 bash -c "service cron start"
mkdir web/http/templates_c
chmod -R 777  web/http/templates_c
sudo docker exec -i $(sudo docker-compose ps -q php) bash -c "php /usr/local/www/kosherkaddy.com/mysql-migrates/migrate.php run"'''
        emailext(subject: '$BUILD_STATUS! - $PROJECT_NAME - Build # $BUILD_NUMBER ', body: '$PROJECT_NAME - Build # $BUILD_NUMBER - $BUILD_STATUS:  Check console output at $BUILD_URL to view the results.', attachLog: true, from: 'jenkins@vie-corp.com', replyTo: 'jenkins@vie-corp.com', saveOutput: true, to: 'system@vie-corp.com')
      }
    }

    stage('Test') {
      steps {
        echo 'This is the Testing Stage'
      }
    }

    stage('Deploy') {
      steps {
        echo 'This is the Deploy Stage'
      }
    }

  }
  post {
    aborted {
      deleteDir()
    }

  }
}