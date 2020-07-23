<?php

/**
 * Class Migrate
 */
class Migrate
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $migration;

    /**
     * @var PDO
     */
    private $conn;

    /**
     * Migration version file
     */
    const MIGRATE_VERSION_FILE = '.version';

    /**
     * Migration file prefix
     */
    const MIGRATE_FILE_PREFIX_VESSY = 'vessy-';
    const MIGRATE_FILE_PREFIX_CECO = 'ceco-';

    /**
     * Migration file postfix
     */
    const MIGRATE_FILE_POSTFIX = '.sql';

    /**
     * Migrate constructor.
     *
     * @param $migration string
     */
    public function __construct($migration)
    {
        $this->migration = $migration;
        $this->config    = include_once 'config.php';

        $this->connect();
    }

    /**
     * Connect to database
     */
    public function connect()
    {
        $host     = $this->config['host'];
        $username = $this->config['username'];
        $password = $this->config['password'];
        $port     = $this->config['port'];
        $database = $this->config['database'];

        $this->conn = @(new mysqli($host, $username, $password, $database, $port));

        if (!empty($this->conn->connect_error)) {
            echo "Failed to connect to the database." . PHP_EOL;
            exit(1);
        }
    }

    /**
     * Make migration
     */
    public function make()
    {
        $migrationDir = $this->getMigrationDirectory();
        $version      = $this->getCurrentVersion();

        echo "Current database version is: $version\n";

        $new_version = $version;
        // Check the new version against existing migrations.
        $files     = $this->getMigrations();
        $last_file = end($files);
        if ($last_file !== false) {
            $file_version = $this->getVersionFromFile($last_file);
            if ($file_version > $new_version)
                $new_version = $file_version;
        }
        // Create migration file path.
        $new_version++;

        if (!file_exists($migrationDir)) {
            mkdir('migration/', 0777);
        }

        $path = $migrationDir . static::MIGRATE_FILE_PREFIX . sprintf('%04d', $new_version);
        $path .= '-' . str_replace(' ', '-', $this->migration);
        $path .= static::MIGRATE_FILE_POSTFIX;

        echo "Adding a new migration script: $path" . PHP_EOL;
        $f = @fopen($path, 'w');
        if ($f) {
            fputs($f, "## WRITE YOU QUERY HERE...");
            fclose($f);
            echo "Done." . PHP_EOL;
        } else {
            echo "Failed." . PHP_EOL;
        }
    }

    /**
     * Run migrations
     */
// Here's a startsWith function
    function startsWith($haystack, $needle){
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    function run_sql_file($location){
        //load file
        $commands = file_get_contents($location);

        //delete comments
        $lines = explode("\n",$commands);
        $commands = '';
        foreach($lines as $line){
            $line = trim($line);
            if( $line && !$this->startsWith($line,'--') ){
                $commands .= $line . "\n";
            }
        }

        //convert to array
        $commands = explode(";", $commands);

        //run commands
        $total = $success = 0;


        foreach($commands as $command){
            if(trim($command)){
                $success += ($this->conn->query($command) ? 0 : 1);
                $total += 1;
            }
        }

        //return number of successful queries and total number of queries found
        return array(
            "success" => $success,
            "total" => $total
        );
    }

    public function run()
    {
        $files        = $this->getMigrations();
        $this->CretateVersionTables();

        $migrationDir = $this->getMigrationDirectory();

        $found_new=false;
        foreach ($files as $file) {
            $file_version = $this->getVersionFromFile($file);

            if(!$file_version){
                echo "Running: $file" . PHP_EOL;

               $result= $this->run_sql_file($migrationDir . $file);
            //    $query = file_get_contents($migrationDir . $file);

              //  echo $query;
              //  $this->conn->query($query);
             //  $this->query($query);

                $this->UpdateVersionFromFile($file,$result);
                echo "Done." . PHP_EOL;

                 $found_new = true;
            }


        }



        if ($found_new) {
            echo "Migration complete." . PHP_EOL;
        } else {
            echo "Your database is up-to-date." . PHP_EOL;
        }
    }

    /**
     * Return current migration number
     *
     * @return int
     *
     */
    private function CretateVersionTables()
    {



        $result = $this->conn->query("SELECT count(*)
        FROM information_schema.TABLES
        WHERE (TABLE_SCHEMA = 'kosher') AND (TABLE_NAME = 'versions')
        ");


        if(!$result->current_field){

            $this->query("CREATE TABLE `versions` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) NOT NULL DEFAULT '',
  `result` varchar(5000) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`fid`,`file`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1");

        }


    }

    /**
     * Query Database
     *
     * @param $query
     *
     * @return bool
     */
    private function query($query)
    {


        $result = $this->conn->query($query);
        print_r($result);
        if (false) {
            echo "Migration failed: " . $this->conn->errorInfo() . "\n";
            echo "Aborting.\n";
            $this->conn->rollBack();
            exit;
        }

        return true;
    }

    /**
     * Find all the migration files in the directory and return the sorted.
     *
     * @return array
     */
    private function getMigrations()
    {
        $files = [];
        $dir   = @opendir($this->getMigrationDirectory());
        while ($file = @readdir($dir)) {
            if (substr($file, 0, strlen(static::MIGRATE_FILE_PREFIX_VESSY)) == static::MIGRATE_FILE_PREFIX_VESSY) {
                $files[] = $file;
            }
            if (substr($file, 0, strlen(static::MIGRATE_FILE_PREFIX_CECO)) == static::MIGRATE_FILE_PREFIX_CECO) {
                $files[] = $file;
            }
        }
        asort($files);

        return $files;
    }

    /**
     * Return version from file
     *
     * @param $file
     *
     * @return int
     */

    private function UpdateVersionFromFile($file,$result)
    {


      $this->conn->query("INSERT INTO `versions` (`file`, `result`, `date`) VALUES ('".$file."', '".print_r($result,true)."', NOW())" );

    }
    private function getVersionFromFile($file)
    {


        $result = $this->conn->query("SELECT * FROM `versions` WHERE `file`='".$file."';");

        return $result->num_rows;
    }

    /**
     * Return migration directory
     *
     * @return string
     */
    private function getMigrationDirectory()
    {
        return $this->config['migrations_dir'];
    }
}

$command   = !empty($argv[1]) ? strtolower($argv[1]) : 'invalid';
$migration = !empty($argv[2]) ? strtolower($argv[2]) : '';

if (count($argv) <= 1 ||
    !in_array($command, ['make', 'run']) ||
    ($command == 'make' && empty($migration))
) {
    echo "Usage:
     To add new migration:
         php php-mysql-migrate/migrate.php make <name-without-spaces>
     To migrate your database:
         php php-mysql-migrate/migrate.php migrate
     " . PHP_EOL;
    exit;
}

$migration = new Migrate($migration);
$migration->$command();