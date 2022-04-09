<?php
/**
 * DB connection and actions.
 */

class DB{
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    // CONNECTION TO THE DATABASE - Start  
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), 
            Config::get('mysql/username'), 
            Config::get('mysql/password'));

            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            // echo 'Connected';
        }catch(PDOException $e){
            die($e->getMessage());
        }
    }

    // With this method we are making only one connection to the DB even if we call this method several times in the index.php. That way we store only 1 connection (link to our database).
    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    // CONNECTION TO THE DATABASE - End

    // CREATING SHORTENED QUERY HELPER FUNCTION - Start
    public function query($sql, $params = array()){
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)){
            $x = 1; // Creating a simple counter so that we can let the function know which parameter we are queriing.
            if(count($params)){
                foreach($params as $param){
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            // Now we will execute the query regadles if there are any parameters.
            if($this->_query->execute()){
                // echo 'Success';
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }else{
                $this->_error = true;
            }
        }

        return $this;
    }
    // CREATING SHORTENED QUERY HELPER FUNCTION - End

    // CREATING SHORTENED DB ACTION HELPER FUNCTION - Start
    public function action($action, $table, $where = array()){
        if(count($where) === 3){
            $operators = array('=', '>', '<', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if(in_array($operator, $operators)){ // Standard PHP function to see if operator is inside the operators array.
                // $sql = "SELECT * FROM users WHERE username = 'Alex'"; // This is how it is ususally looks like, but it is pointles since we have created a special function for it.
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                
                if(!$this->query($sql, array($value))->error()){ // [1] remove '->error()'
                    return $this;
                }
            }

            // return $this; // [1] uncomment this
        }

        return false; // [1] comment this
    }

    // This is a shortcut of the previous function / method. We may simply still do everything with the previous method only.
    public function get($table, $where){
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where){
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array()){    
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach($fields as $field){
            $values .= '?'; // Same as $values = $values . '?' - basically, this is short version of concatination.
            if($x < count($fields)){
                $values .= ', ';
            }
            $x++;
        }

        // die($values);

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

        // echo $sql;

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields = array()){        
        $set = '';
        $x = 1;

        foreach($fields as $name => $value){
            $set .= "`{$name}` = ?";
            if($x < count($fields)){
                $set .= ', ';
            }
            $x++;
        }

        // die($set);

        $sql = "UPDATE `{$table}` SET {$set} WHERE `id` = {$id}";

        // echo $sql;

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function error(){
        return $this->_error;
    }

    public function count(){
        return $this->_count;
    }
}