<?php
/**
 * this class is under framework/database, it is to encapsulate database
 * connection and some basic SQL query methods.
 */


/**
 *================================================================
 *framework/database/Mysql.class.php
 *Database operation class
 *================================================================
 */
class Mysql
{

    protected $conn = false;  //DB connection resources

    protected $sql;           //sql statement
    protected $mysqli;


    /**
     * Constructor, to connect to database, select database and set charset
     * @param $config string configuration array
     */

    public function __construct($config = array())
    {

        $host = isset($config['host']) ? $config['host'] : 'localhost';

        $user = isset($config['user']) ? $config['user'] : 'root';

        $password = isset($config['password']) ? $config['password'] : '';

        $dbname = isset($config['dbname']) ? $config['dbname'] : '';

        $port = isset($config['port']) ? $config['port'] : '3306';

        $charset = isset($config['charset']) ? $config['charset'] : 'utf8';

        $mysqli = new mysqli($host, $user, $password, $dbname);
              // Oh no! A connect_errno exists so the connection attempt failed!
              if ($mysqli->connect_errno) {
                // The connection failed. What do you want to do? 
                // You could contact yourself (email?), log the error, show a nice page, etc.
                // You do not want to reveal sensitive information
    
                // Let's try this:
                echo "Sorry, this website is experiencing problems.";
    
                // Something you should not do on a public site, but this example will show you
                // anyways, is print out MySQL error related information -- you might log this
                echo "Error: Failed to make a MySQL connection, here is why: \n";
                echo "Errno: " . $mysqli->connect_errno . "\n";
                echo "Error: " . $mysqli->connect_error . "\n";
                
                // You might want to show them something nice, but we will simply exit
                exit;
            }

        $this->conn = $mysqli;

        $this->setChar($charset);

    }

    /**
     * Set charset
     * @access private
     * @param $charset string charset
     */

    private function setChar($charest)
    {

        $sql = 'set names ' . $charest;

        $this->query($sql);

    }

    /**
     * Execute SQL statement
     * @access public
     * @param $sql string SQL query statement
     * @return $result，if succeed, return resrouces; if fail return error message and exit
     */

    public function query($sql)
    {

        $this->sql = $sql;

        // Write SQL statement into log

        $str = $sql . "  [" . date("Y-m-d H:i:s") . "]" . PHP_EOL;

        file_put_contents("log.txt", $str, FILE_APPEND);

        if (!$result = $this->conn->query($sql)) {
            // Oh no! The query failed. 
            echo "Sorry, the website is experiencing problems.";
        
            // Again, do not do this on a public site, but we'll show you how
            // to get the error information
            echo "Error: Our query failed to execute and here is why: \n";
            echo "Query: " . $sql . "\n";
            echo "Errno: " . $mysqli->errno . "\n";
            echo "Error: " . $mysqli->error . "\n";
            exit;
        }
        
        // Phew, we made it. We know our MySQL connection and query 
        // succeeded, but do we have a result?
        if(isset($result->num_rows)){
            if ($result->num_rows === 0) {
                // Oh, no rows! Sometimes that's expected and okay, sometimes
                // it is not. You decide. In this case, maybe actor_id was too
                // large? 
                echo "We could not find a match for ID $aid, sorry about that. Please try again.";
                exit;
            }
            return $result;
        }
    }

    /**
     * Get the first column of the first record
     * @access public
     * @param $sql string SQL query statement
     * @return return the value of this column
     */

    public function getOne($sql)
    {

        $result = $this->query($sql);

        $row = mysql_fetch_row($result);

        if ($row) {

            return $row[0];

        } else {

            return false;

        }

    }

    /**
     * Get one record
     * @access public
     * @param $sql SQL query statement
     * @return array associative array
     */

    public function getRow($sql)
    {

        if ($result = $this->query($sql)) {

            $row = mysql_fetch_assoc($result);

            return $row;

        } else {

            return false;

        }

    }

    /**
     * Get all records
     * @access public
     * @param $sql SQL query statement
     * @return $list an 2D array containing all result records
     */

    public function getAll($sql)
    {

        $result = $this->query($sql);

        $list = array();

        while ($row = $result->fetch_assoc()) {

            $list[] = $row;

        }

        return $list;

    }

    /**
     * Get the value of a column
     * @access public
     * @param $sql string SQL query statement
     * @return $list array an array of the value of this column
     */

    public function getCol($sql)
    {

        $result = $this->query($sql);

        $list = array();

        while ($row = mysql_fetch_row($result)) {

            $list[] = $row[0];

        }

        return $list;

    }


    /**
     * Get last insert id
     */

    public function getInsertId()
    {

        return mysql_insert_id($this->conn);

    }

    /**
     * Get error number
     * @access private
     * @return error number
     */

    public function errno()
    {

        return mysql_errno($this->conn);

    }

    /**
     * Get error message
     * @access private
     * @return error message
     */

    public function error()
    {

        return mysql_error($this->conn);

    }

}