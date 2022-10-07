<?php

/* MYDB version 1.0 */

class MYDB{
    private $dbusername;
    private $dbpassword;
    private $dbhost;
    private $dbname;
    private $dbtype;
    private $dbconnect;
    private $error = array();
    private $message;
    private $dataresult;
    private $countresult;

    public function __construct($value){

        $dbparam = json_decode($value);

        if(isset($dbparam->DBUsername) && !empty($dbparam->DBUsername)){
            $this->dbusername = $dbparam->DBUsername;
        }else{
            $dberr = "Database Username Not Set";
            array_push($this->error, $dberr);
            $this->dbusername = "unset";
        }

        if(isset($dbparam->DBPassword) && !empty($dbparam->DBPassword)){
            $this->dbpassword = $dbparam->DBPassword;
        }else{
            
            $this->dbpassword = "";
        }

        
        if(isset($dbparam->DBHost) && !empty($dbparam->DBHost)){
            $this->dbhost = $dbparam->DBHost;
        }else{
            $dberr = "Database Host Not Set";
            array_push($this->error, $dberr);
            $this->dbhost = "unset";
        }


        if(isset($dbparam->DBType) && !empty($dbparam->DBType)){
            $this->dbtype = $dbparam->DBType;
        }else{
            $dberr = "Database Type Not Set";
            array_push($this->error, $dberr);
            $this->dbtype = "unset";
        }

        if(isset($dbparam->DBName) && !empty($dbparam->DBName)){
            $this->dbname = $dbparam->DBName;
        }else{
            $dberr = "Database Name Not Set";
            array_push($this->error, $dberr);
            $this->dbname = "unset";
        }
    }

    private function connectDb(){

        $dberror = $this->error;

        if(count($dberror) > 0){
            
            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }
        }else{

            $databaseusername = $this->dbusername;
            $databasepass = $this->dbpassword;
            $databasehost = $this->dbhost;
            $databasename = $this->dbname;
            $databasetype = $this->dbtype;

            if($databasetype === "mysql"){
                $this->dbconnect = new PDO("mysql:host=$databasehost;dbname=$databasename", $databaseusername, $databasepass);
            }

        }
    }

    public function getDbDetails(){
        $dbdetails = array();

        array_push(
            $dbdetails, "DBUsername : " . $this->dbusername,
            "DBPassword : " . $this->dbpassword,
            "DBName : " . $this->dbname,
            "DBHost : " . $this->dbhost,
            "DBType : " . $this->dbtype
        );
        echo "<h3>Your Database Details Are: </h3>";

        for($i = 0; $i < count($dbdetails); $i++){
            echo $i + 1 . " ) " . $dbdetails[$i] . "<br/>";
        }
    }

    public function updateTableRowData($value){
        $sentvalues = json_decode($value);


        if(isset($sentvalues->tableName) && !empty($sentvalues->tableName)){

            $tablename  = $sentvalues->tableName;

        }else{
            
            $dberr = "Table Name Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($sentvalues->tableParams) && !empty($sentvalues->tableParams)){

            $tableparam  = explode("|", $sentvalues->tableParams);

        }else{
            
            $dberr = "Table Parameters Not Set";
            array_push($this->error, $dberr);
        }


        if(isset($sentvalues->paramValues) && !empty($sentvalues->paramValues)){

            $paramvalues  = explode("|", $sentvalues->paramValues);

        }else{
            
            $dberr = "Update Values Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($sentvalues->identityParams) && !empty($sentvalues->identityParams)){

            $identparam  = explode("|", $sentvalues->identityParams);

        }else{
            
            $dberr = "Identity Parameter Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($sentvalues->identityParamsValues) && !empty($sentvalues->identityParamsValues)){

            $identparamvalue  = explode("|", $sentvalues->identityParamsValues);

        }else{
            
            $dberr = "Identity Parameter Value Not Set";
            array_push($this->error, $dberr);
        }
        
        if(isset($sentvalues->paramValues) && !empty($sentvalues->paramValues) && isset($sentvalues->tableParams) && !empty($sentvalues->tableParams)){

            if(count($tableparam) !== count($paramvalues)){
                
                $dberr = "The Number Of Parameters and Number Of Values Isn't The Same";
                array_push($this->error, $dberr);
            }
        }

        if(isset($sentvalues->identityParams) && !empty($sentvalues->identityParams) && isset($sentvalues->identityParamsValues) && !empty($sentvalues->identityParamsValues)){

            if(count($identparam) !== count($identparamvalue)){
                
                $dberr = "The Number Of Identity Parameters and Number Of Identity Parameters Values Isn't The Same";
                array_push($this->error, $dberr);
            }

        }


        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();
    
            $conn = $this->dbconnect;

            $updatevalue = "";
            $updateparam = "";

            for($i = 0; $i < count($tableparam); $i++){
                $val = ":val" . $i;
                
                if($i === (count($tableparam) - 1)){

                    
                    $updatevalue .= $tableparam[$i] . "= ". $val ;
                    
                }else{

                    $updatevalue .= $tableparam[$i] . "= ". $val . ", ";
                }
            }

            for($v = 0; $v < count($identparam); $v++){

                $finalIdentityparamvalue = "'".trim($identparamvalue[$v])."'";

                if($v === (count($identparam) - 1)){

                    $updateparam .= $identparam[$v] . "=" .$finalIdentityparamvalue;

                }else{

                    $updateparam .= $identparam[$v] . "=" . $finalIdentityparamvalue . " AND ";

                }
            }

            $checkCountsql = "SELECT * FROM " . $tablename . " WHERE " . $updateparam;
            $count = $conn->query($checkCountsql)->rowcount();

            if($count > 0){


                $updatesql = "UPDATE " . $tablename . " SET " . $updatevalue . " WHERE " . $updateparam;
    
                $stmt = $conn->prepare($updatesql);
    
                for($t = 0; $t < count($tableparam); $t++){
                    $val = ":val" . $t;
                    $stmt->bindValue($val, $paramvalues[$t]);
                }
                $completedact = $stmt->execute();
    
                if($completedact){
                    return true;
                }else{
                    return false;
                }

            }else{

                return false;

            }

            
        }

        

        
    }

    public function insertTableRowData($value){

        $sentvalues = json_decode($value);


        if(isset($sentvalues->tableName) && !empty($sentvalues->tableName)){

            $tablename  = $sentvalues->tableName;

        }else{
            
            $dberr = "Table Name Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($sentvalues->tableParams) && !empty($sentvalues->tableParams)){

            $tableparam  = explode("|", $sentvalues->tableParams);

        }else{
            
            $dberr = "Table Parameters Not Set";
            array_push($this->error, $dberr);
        }


        if(isset($sentvalues->paramValues) && !empty($sentvalues->paramValues)){

            $paramvalues  = explode("|", $sentvalues->paramValues);

        }else{
            
            $dberr = "Parameter Values Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($sentvalues->paramValues) && !empty($sentvalues->paramValues) && isset($sentvalues->tableParams) && !empty($sentvalues->tableParams)){

            if(count($tableparam) !== count($paramvalues)){
                
                $dberr = "The Number Of Parameters and Number Of Values Isn't The Same";
                array_push($this->error, $dberr);
            }
        }


        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();
    
            $conn = $this->dbconnect;

            $insertvalue = "";
            $insertparam = "";

            for($i = 0; $i < count($tableparam); $i++){
                
                if($i === (count($tableparam) - 1)){

                    
                    $insertparam .= $tableparam[$i] ;
                    
                }else{

                    $insertparam .= $tableparam[$i] . ", ";
                }
            }

            for($i = 0; $i < count($tableparam); $i++){
                $val = ":val" . $i;
                
                if($i === (count($paramvalues) - 1)){

                    
                    $insertvalue .= $val ;
                    
                }else{

                    $insertvalue .= $val . ", ";
                }
            }

            $insertsql = "INSERT INTO " . $tablename . "(" . $insertparam . ") VALUES (" . $insertvalue . ")";
            $insertstmt = $conn->prepare($insertsql);

            for($i = 0; $i < count($paramvalues); $i++){

                $val = ":val" . $i;

                $insertstmt->bindValue($val, $paramvalues[$i]);
            }

            $insertexcecuted = $insertstmt->execute();

            if($insertexcecuted){

                return true;

            }else{

                return false;

            }


            
        }

        
    }

    public function getTableData($value){

        $getvalues = json_decode($value);

        if(isset($getvalues->tableName) && !empty($getvalues->tableName)){
            $tablename = $getvalues->tableName;
        }else{
            $dberr = "Table Name Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($getvalues->columns) && !empty($getvalues->columns)){
            $tablecolumns = explode("|", $getvalues->columns);
        }else{
            $tablecolumns = "all";
            
        }

        if(isset($getvalues->identityParams) && !empty($getvalues->identityParams)){
            $identityparams = explode("|", $getvalues->identityParams);
        }else{
            $identityparams = "unset";
            
        }

        
        if(isset($getvalues->identityValues) && !empty($getvalues->identityValues)){
            $identityvalues = explode("|", $getvalues->identityValues);

        }else{
            $identityvalues = "unset";
            
        }

        if(isset($getvalues->order) && !empty($getvalues->order)){
            $order = $getvalues->order;
        }

        if(isset($getvalues->orderType) && !empty($getvalues->orderType)){

            if($getvalues->orderType !== "ASC" && $getvalues->orderType !== "DESC"){
                $ordertype = "ASC";
            }else{

                $ordertype = $getvalues->orderType;
            }
        }

        if(isset($getvalues->limit) && !empty($getvalues->limit)){
            $limit = $getvalues->limit;
        }

        if(isset($getvalues->offset) && !empty($getvalues->offset)){
            $offset = $getvalues->offset;
        }

        if($identityparams !== "unset"){

            if(is_array($identityvalues)){

                if(count($identityparams) !== count($identityvalues)){
    
                    $dberr = "Identity Parameter Doesn't Correspond With The Identity Value";
                    array_push($this->error, $dberr);
    
    
                }
            }else{

                
                $dberr = "Identity Values Not Set";
                array_push($this->error, $dberr);

            }

            

        }

        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();

            $conn = $this->dbconnect;

            $fetchcolumns = array();

            if($tablecolumns === "all"){
                $getcolumns = "*";

                $getcolumnssql = "SHOW COLUMNS FROM " . $tablename;
                $getcolumnsstmt = $conn->query($getcolumnssql);
                $getcolumnsfetch = $getcolumnsstmt->fetchAll();

                // echo "<pre>";

                // print_r($getcolumnsfetch);
                
                // echo "</pre>";
                // echo count($getcolumnsfetch);
                for($i = 0; $i < count($getcolumnsfetch); $i++){
                    array_push($fetchcolumns, $getcolumnsfetch[$i]["Field"]);
                }

            }else{

                $getcolumns = "";

                for($i = 0; $i < count($tablecolumns); $i++){

                    array_push($fetchcolumns, $tablecolumns[$i]);

                    if($i === (count($tablecolumns) - 1)){

                        $getcolumns .= $tablecolumns[$i];
                    }else{

                        $getcolumns .= $tablecolumns[$i] . ", ";
                    }

                }

            }


            if($identityparams === "unset"){

                //execute this code if the identity parameters to identify the data isn't set

                
                if(isset($order) && !empty($order) && !isset($limit) && empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " ORDER BY " . $order . " " . $ordertype;
                }

                if(!isset($order) && empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                if(isset($order) && !empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }

                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " ORDER BY " . $order . " " . $ordertype . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                if(!isset($order) && empty($order) && !isset($limit) && empty($limit)){

                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename;

                }

                $getstmt = $conn->query($getsql);
                
            }else{

                // else if identity parameter is set, execute this code

                $getidentity = "";

                for($i = 0; $i < count($identityparams); $i++){
                    $val = ":val" . $i;

                    if($i === (count($identityparams) - 1) ){

                        $getidentity .= $identityparams[$i] . "=" . $val;

                    }else{
                        
                        $getidentity .= $identityparams[$i] . "=" . $val . " AND ";
                    }

                }


                if(isset($order) && !empty($order) && !isset($limit) && empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity . " ORDER BY " . $order . " " . $ordertype;
                }

                if(!isset($order) && empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename. " WHERE " . $getidentity . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                if(isset($order) && !empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }

                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity . " ORDER BY " . $order . " " . $ordertype . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                

                if(!isset($order) && empty($order) && !isset($limit) && empty($limit)){
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity;


                }


                $getstmt = $conn->prepare($getsql);

                for($i = 0; $i < count($identityparams); $i++){
                    $val = ":val" . $i;

                    $getstmt->bindValue($val, $identityvalues[$i]);


                    
                }

                $getstmt->execute();

            }
            

            // echo $getsql;
            $getrowcount = $getstmt->rowcount();

            if($getrowcount < 1){
                return false;
            }else{
                $getfetch = $getstmt->fetchAll();

                $details = array();
                $combinedetails = array();

                for($i = 0; $i < count($getfetch); $i++){

                    $getvalue = "";
                    for($v = 0; $v < count($fetchcolumns); $v++){

                        if($v === (count($fetchcolumns) - 1)){

                            $getvalue .= $getfetch[$i][$fetchcolumns[$v]];
                        }else{

                            $getvalue .= $getfetch[$i][$fetchcolumns[$v]] . "|MEMSconcate|";
                        }

                    }

                    $newgetarray = explode("|MEMSconcate|", $getvalue);
                    array_push($details, $newgetarray);
                    // print_r($newgetarray);


                }

                for($t = 0; $t < count($details); $t++){
                    $c = array_combine($fetchcolumns, $details[$t]);

                    array_push($combinedetails, $c);
                }

               
                $this->dataresult = $combinedetails;

                
                return $this->dataresult;
                


               
            }
        }
    }

    public function showData(){

        return $this->dataresult;
    }

    public function deleteRow($value){
        $deletrowvalue = json_decode($value);

        if(isset($deletrowvalue->tableName) && !empty($deletrowvalue->tableName)){
            $deletetablename = $deletrowvalue->tableName;
        }else{
            $dberr = "Table Name Not Set For Delete";
            array_push($this->error, $dberr);
        }

        if(isset($deletrowvalue->identityParams) && !empty($deletrowvalue->identityParams)){
            $deletetableparams = explode("|", $deletrowvalue->identityParams);
        }else{
            $dberr = "Identity Parameters Not Set For Delete";
            array_push($this->error, $dberr);
        }

        if(isset($deletrowvalue->identityValues) && !empty($deletrowvalue->identityValues)){
            $deletetablevalues = explode("|", $deletrowvalue->identityValues);
        }else{
            $dberr = "Identity Parameters Values Not Set For Delete";
            array_push($this->error, $dberr);
        }

        if(isset($deletrowvalue->identityParams) && !empty($deletrowvalue->identityParams) && isset($deletrowvalue->identityValues) && !empty($deletrowvalue->identityValues)){


            if(count($deletetableparams) !== count($deletetablevalues)){
                $dberr = "The Number Of Delete Identity Parameters And Values Are Not The Same";
                array_push($this->error, $dberr);
            }
        }

        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();

            $conn = $this->dbconnect;


            $deletesqlvalue = "";
            $deleteselectsqlval = "";

            for($i = 0; $i < count($deletetableparams); $i++){

                $deletetableval = ":val" . $i;

                if($i === (count($deletetableparams) - 1)){
                    $deletesqlvalue .= $deletetableparams[$i] . " = " . $deletetableval;

                    $deleteselectsqlval .= $deletetableparams[$i] . " = " . $deletetableval;
                }else{
                    $deletesqlvalue .= $deletetableparams[$i] . " = " . $deletetableval . " AND ";
                    
                    $deleteselectsqlval .= $deletetableparams[$i] . " = " . $deletetableval . " AND ";;

                }
            }
            
            $checkdeletesql = "SELECT * FROM " . $deletetablename . " WHERE " . $deleteselectsqlval;

            $checkdeletestmt = $conn->prepare($checkdeletesql);

            for($t = 0; $t < count($deletetableparams); $t++){
                
                $deletetableval = ":val" . $t;

                $checkdeletestmt->bindValue($deletetableval, $deletetablevalues[$t]);


            }

            $checkdeletestmt->execute();

            $checkdeleterowcount = $checkdeletestmt->rowcount();

            if($checkdeleterowcount < 1){
                return false;
            }else{

                $deleterowsql = "DELETE FROM " . $deletetablename . " WHERE " . $deletesqlvalue;

                $deleterowstmt = $conn->prepare($deleterowsql);

                for($m = 0; $m < count($deletetableparams); $m++){
                    
                    $deletetableval = ":val" . $m;

                    
                    $deleterowstmt->bindValue($deletetableval, $deletetablevalues[$m]);

                }

                $deleterowexec = 
                $deleterowstmt->execute();

                if($deleterowexec){
                    return true;
                }else{
                    return false;
                }
                
            }

        }
    }

    

    public function deleteTable($value){

        if(isset($value) && !empty($value)){
            $deletetable = explode("|", $value);

        }else{
            $dberr = "Teble Name Not Set For Delete";
            array_push($this->error, $dberr);
        }

        
        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();

            $conn = $this->dbconnect;

            $checktable = array();

            for($y = 0; $y < count($deletetable); $y++){

                $checktablesql = "SHOW TABLES LIKE '" . $deletetable[$y] . "'";

                $checktablestmt = $conn->query($checktablesql);

                $checktablecount = $checktablestmt->rowcount();

                if($checktablecount < 1){
                    $tableerr = "Table With The Name (" . $deletetable[$y] . ") Not Found";

                    array_push($checktable, $tableerr);
                }

            }

            if(count($checktable) > 0){

                echo "<h2>The Following Errors Were Found</h2>";
    
                for($i = 0; $i < count($checktable); $i++){
                    echo $i + 1 . " => ". $checktable[$i] . "<br/>";
                }

            }else{

                $deletetablesql = "";
                for($r = 0; $r < count($deletetable); $r++){

                    if($r === (count($deletetable) - 1)){

                        $deletetablesql .= "DROP TABLE " . $deletetable[$r];
                    }else{

                        $deletetablesql .= "DROP TABLE " . $deletetable[$r] . "; ";
                    }


                }
                $deletetablestmt = $conn->query($deletetablesql);

                if($deletetablestmt){

                    if(count($deletetable) > 1){
                        return "Tables Deleted";
                    }else{
                        return "Table Deleted";
                    }
                }
            }

        }

        
    }

    public function deleteDB($value){

        $deletedbvalue = json_decode($value);

        if(isset($deletedbvalue->DBUsername) && !empty($deletedbvalue->DBUsername)){
            $dbusername = $deletedbvalue->DBUsername;
        }else{
            $dberr = "Username Not Set For DeleteDB";
            array_push($this->error, $dberr);
        }

        if(isset($deletedbvalue->DBHost) && !empty($deletedbvalue->DBHost)){
            $dbhost = $deletedbvalue->DBHost;
        }else{
            $dberr = "Username Not Set For DeleteDB";
            array_push($this->error, $dberr);
        }

    }

    public function countRow($value){
    
        $countrowvalue = json_decode($value);

        if(isset($countrowvalue->tableName) && !empty($countrowvalue->tableName)){
            $counttablename = $countrowvalue->tableName;
        }else{
            $dberr = "Table Name Not Set For Count";
            array_push($this->error, $dberr);
        }

        if(isset($countrowvalue->identityParams) && !empty($countrowvalue->identityParams)){
            $counttableparams = explode("|", $countrowvalue->identityParams);
        }

        if(isset($countrowvalue->identityValues) && !empty($countrowvalue->identityValues)){

            $counttablevalues = explode("|", $countrowvalue->identityValues);
        }

        if(isset($countrowvalue->identityParams) && !empty($countrowvalue->identityParams) && isset($countrowvalue->identityValues) && !empty($countrowvalue->identityValues)){


            if(count($counttableparams) !== count($counttablevalues)){
                $dberr = "The Number Of Count Identity Parameters And Values Are Not The Same";
                array_push($this->error, $dberr);
            }
        }

        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();

            $conn = $this->dbconnect;


            $countsqlvalue = "";
            $countselectsqlval = "";

            

            if(isset($counttableparams) && !empty($counttableparams) && isset($counttablevalues) && !empty($counttablevalues)){

                for($i = 0; $i < count($counttableparams); $i++){

                    $counttableval = ":val" . $i;
    
                    if($i === (count($counttableparams) - 1)){
                        $countsqlvalue .= $counttableparams[$i] . " = " . $counttableval;
    
                        $countselectsqlval .= $counttableparams[$i] . " = " . $counttableval;
                    }else{
                        $countsqlvalue .= $counttableparams[$i] . " = " . $counttableval . " AND ";
                        
                        $countselectsqlval .= $counttableparams[$i] . " = " . $counttableval . " AND ";;
    
                    }
                }

                $checkcountsql = "SELECT * FROM " . $counttablename . " WHERE " . $countselectsqlval;
    
                $checkcountstmt = $conn->prepare($checkcountsql);
    
                for($t = 0; $t < count($counttableparams); $t++){
                    
                    $counttableval = ":val" . $t;
    
                    $checkcountstmt->bindValue($counttableval, $counttablevalues[$t]);
    
    
                }
    
                $checkcountstmt->execute();
            }else{

                $checkcountsql = "SELECT * FROM " . $counttablename;

                $checkcountstmt = $conn->query($checkcountsql);

            }
            

            $checkcountrowcount = $checkcountstmt->rowcount();

            if($checkcountrowcount < 1){

                return $checkcountrowcount;

            }else{

                return $checkcountrowcount;
                

            }

        }
    
    }

    public function searchTable($value){

        $getvalues = json_decode($value);

        if(isset($getvalues->tableName) && !empty($getvalues->tableName)){
            $tablename = $getvalues->tableName;
        }else{
            $dberr = "Table Name Not Set";
            array_push($this->error, $dberr);
        }

        if(isset($getvalues->columns) && !empty($getvalues->columns)){
            $tablecolumns = explode("|", $getvalues->columns);
        }else{
            $tablecolumns = "all";
            
        }

        if(isset($getvalues->identityParams) && !empty($getvalues->identityParams)){
            $identityparams = explode("|", $getvalues->identityParams);
        }else{
            
            $dberr = "Identity Parameter Not Set";
            array_push($this->error, $dberr);
            
        }

        
        if(isset($getvalues->identityValues) && !empty($getvalues->identityValues)){
            $identityvalues =  $getvalues->identityValues;

        }else{
            
            $dberr = "Identity Parameter Values Not Set";
            array_push($this->error, $dberr);
            
        }

        if(isset($getvalues->order) && !empty($getvalues->order)){
            $order = $getvalues->order;
        }

        if(isset($getvalues->orderType) && !empty($getvalues->orderType)){
            if($getvalues->orderType !== "ASC" && $getvalues->orderType !== "DESC"){
                $ordertype = "ASC";
            }else{

                $ordertype = $getvalues->orderType;
            }
        }

        if(isset($getvalues->limit) && !empty($getvalues->limit)){
            $limit = $getvalues->limit;
        }

        if(isset($getvalues->offset) && !empty($getvalues->offset)){
            $offset = $getvalues->offset;
        }

        if(isset($getvalues->comparismOperator) && !empty($getvalues->comparismOperator)){

            if($getvalues->comparismOperator !== "LIKE" && $getvalues->comparismOperator !== "=" && $getvalues->comparismOperator !== ">=" && $getvalues->comparismOperator !== ">" && $getvalues->comparismOperator !== "<" && $getvalues->comparismOperator !== "<=" && $getvalues->comparismOperator !== "!=" && $getvalues->comparismOperator !== "LIKE%" && $getvalues->comparismOperator !== "NOT LIKE" && $getvalues->comparismOperator !== "BETWEEN" && $getvalues->comparismOperator !== "NOT BETWEEN" && $getvalues->comparismOperator !== "IS NULL" && $getvalues->comparismOperator !== "IS NOT NULL"){
                
                $comparisimoperator = "LIKE";

                $comparisonend = "%";
            }else{

                if($getvalues->comparismOperator === "LIKE%"){

                    $comparisonend = "%";
                    
                    $comparisimoperator = "LIKE";
                }else{

                    $comparisonend = "";
                    
                    $comparisimoperator = $getvalues->comparismOperator;
                }

            }
        }else{

            $comparisonend = "";
            
            $comparisimoperator = "LIKE";
        }

        $dberror = $this->error;

        // print_r($tableparam);
        // echo "<br/>";
        // print_r($paramvalues);

        if(count($dberror) > 0){

            echo "<h2>The Following Errors Were Found</h2>";

            for($i = 0; $i < count($dberror); $i++){
                echo $i + 1 . " => ". $dberror[$i] . "<br/>";
            }

        }else{

            $this->connectDb();

            $conn = $this->dbconnect;

            $fetchcolumns = array();

            //getting the columns

            if($tablecolumns === "all"){
                $getcolumns = "*";

                $getcolumnssql = "SHOW COLUMNS FROM " . $tablename;
                $getcolumnsstmt = $conn->query($getcolumnssql);
                $getcolumnsfetch = $getcolumnsstmt->fetchAll();

                // echo "<pre>";

                // print_r($getcolumnsfetch);
                
                // echo "</pre>";
                // echo count($getcolumnsfetch);
                for($i = 0; $i < count($getcolumnsfetch); $i++){
                    array_push($fetchcolumns, $getcolumnsfetch[$i]["Field"]);
                }

            }else{

                $getcolumns = "";

                for($i = 0; $i < count($tablecolumns); $i++){

                    array_push($fetchcolumns, $tablecolumns[$i]);

                    if($i === (count($tablecolumns) - 1)){

                        $getcolumns .= $tablecolumns[$i];
                    }else{

                        $getcolumns .= $tablecolumns[$i] . ", ";
                    }

                }

            }


                $getidentity = "";

                for($i = 0; $i < count($identityparams); $i++){
                    $val = ":val" . $i;

                    if($i === (count($identityparams) - 1) ){

                        $getidentity .= $identityparams[$i] . " " . $comparisimoperator . " " . $val;

                    }else{
                        
                        $getidentity .= $identityparams[$i] . " " . $comparisimoperator . " " . $val . " OR ";
                    }

                }

                

                if(isset($order) && !empty($order) && !isset($limit) && empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity . " ORDER BY " . $order . " " . $ordertype;
                }

                if(!isset($order) && empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename. " WHERE " . $getidentity . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                if(isset($order) && !empty($order) && isset($limit) && !empty($limit)){
                    
                    if(!isset($ordertype) || empty($ordertype)){
                        $ordertype = "ASC";
                    }

                    if(!isset($offset) || empty($offset)){
                        $offset = 0;
                    }
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity . " ORDER BY " . $order . " " . $ordertype . " LIMIT " . $limit . " OFFSET " . $offset;
                }

                

                if(!isset($order) && empty($order) && !isset($limit) && empty($limit)){
                    
                    $getsql = "SELECT " . $getcolumns . " FROM " . $tablename . " WHERE " . $getidentity;


                }

                $getstmt = $conn->prepare($getsql);

                for($i = 0; $i < count($identityparams); $i++){
                    $val = ":val" . $i;

                    $searchdbvalue = $comparisonend.$identityvalues.$comparisonend;

                    $getstmt->bindValue($val, $searchdbvalue);


                    
                }

                $getstmt->execute();

                // echo $getsql;

                $getrowcount = $getstmt->rowcount();

            if($getrowcount < 1){
                return false;
            }else{
                $getfetch = $getstmt->fetchAll();

                $details = array();
                $combinedetails = array();

                for($i = 0; $i < count($getfetch); $i++){

                    $getvalue = "";
                    for($v = 0; $v < count($fetchcolumns); $v++){

                        if($v === (count($fetchcolumns) - 1)){

                            $getvalue .= $getfetch[$i][$fetchcolumns[$v]];
                        }else{

                            $getvalue .= $getfetch[$i][$fetchcolumns[$v]] . "|MEMSconcate|";
                        }

                    }

                    $newgetarray = explode("|MEMSconcate|", $getvalue);
                    array_push($details, $newgetarray);
                    // print_r($newgetarray);


                }

                for($t = 0; $t < count($details); $t++){
                    $c = array_combine($fetchcolumns, $details[$t]);

                    array_push($combinedetails, $c);
                }

               
                $this->dataresult = $combinedetails;

                
                return $this->dataresult;
                


               
            }
        }
    }
    
    public function getMessage(){

        return $this->message;

    }
}


