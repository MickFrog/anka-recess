<?php

/* Connect to a MySQL database using driver invocation */
$dsn = 'mysql:dbname=anka;host=127.0.0.1';
$user = 'root';
$password = '';
 
try {
    $conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: '.$e->getMessage();
}
 
//create an object oriented interface for the file
$file1= new SplFileObject('E:\AnkaJava\Participants.txt');
//using exception handling to ensure the code keeps running even though some constraints have not been met
try{
    //to perform the actions while the file hasnt yet reached its end
    while(!$file1->eof())
    {
        //get line by line in the text file and stores in the $line variable
        $line1=$file1->fgets();
        /*separate the text content in each line using ; as a separator 
        and storing into the defined variables*/
        list($name,$password,$product,$DOB,$points)=explode(';',$line1);
        //inserting the values from the text file into their respective columns in the database
        $sth1 = $conn->prepare('INSERT INTO participants values(NULL,?,?,?,?,?,NULL,NULL)');
        $sth1->bindValue(1,$name,PDO::PARAM_STR);
        $sth1->bindValue(2,$password,PDO::PARAM_STR);
        $sth1->bindValue(3,$product,PDO::PARAM_STR);
        $sth1->bindValue(4,$DOB,PDO::PARAM_STR);
        $sth1->bindValue(5,$points,PDO::PARAM_INT);
        $sth1->execute();  
        //clearing the contents of the text file after they have been added to the database to avoid repetition
        file_put_contents("E:\AnkaJava\Participants.txt",""); 
    }
}
//exception incase there is no data in the text file to be read
catch(PDOException $e1){
    echo 'Participants file is empty: '.$e1->getMessage;
}

//same code as above but for the products text file
try{
    $file2= new SplFileObject('E:\AnkaJava\Products.txt');
    while(!$file2->eof())
    {
        $line2=$file2->fgets();
        list($name,$quantity,$rate,$description,$participant_id)=explode(';',$line2);
        $sth2 = $conn->prepare('INSERT INTO products values(NULL,?,?,?,?,?,NULL,NULL)');
        $sth2->bindValue(1,$name,PDO::PARAM_STR);
        $sth2->bindValue(2,$quantity,PDO::PARAM_INT);
        $sth2->bindValue(3,$rate,PDO::PARAM_INT);
        $sth2->bindValue(4,$description,PDO::PARAM_STR);
        $sth2->bindValue(5,$participant_id,PDO::PARAM_INT);
        $sth2->execute();   
        file_put_contents("E:\AnkaJava\Products.txt","");
    }
}
catch(PDOException $e2){
    echo 'Products file is empty: '.$e2->getMessage;
}


try{
    //opening the performance requests file which reads the participantID to get their respective performance stats
    $participantid = 0;
    $participantid = fopen('E:\AnkaJava\PerformanceRequests.txt',"r") or die("Request not taken.");
    $content = fread($participantid, filesize("E:\AnkaJava\PerformanceRequests.txt"));
    //empty file contents after reading to make space for more requests
    file_put_contents("E:\AnkaJava\PerformanceRequests.txt","");


    //should return rank, points, products left(quantity)
    $sql1 = "SELECT points from participants where id='$content'";
    $sql2 = "SELECT quantity from products where participant_id='$content'";
    $sql3 = "WITH ranked AS(
        SELECT id, points, ROW_NUMBER() OVER(ORDER BY points desc) RowNumber 
        FROM participants
    ) SELECT * FROM ranked WHERE id='$content'";

    $result1 = $conn->query($sql1);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);

    while ($row1 = $result1->fetch()) {
        //echo $row1['points']."<br>";
        $points = $row1['points'];
    }

    while ($row2 = $result2->fetch()) {
        //echo $row1['points']."<br>";
        $quantity = $row2['quantity'];
    }

    while ($row3 = $result3->fetch()) {
        //echo $row1['points']."<br>";
        $rank = $row3['RowNumber'];
    }


    $handle = fopen("E:\AnkaJava\Performance.txt", "w") or die("File does not exist.");
    if(fwrite($handle,$content.";"."Points: ".$points." "."Products Left: ".$quantity." "."Rank: ".$rank) == false ){
        echo "Error Writing.";
}
}
catch(PDOException $e3){
    echo 'Performance request not sent: '.$e3->getMessage;
}




?>