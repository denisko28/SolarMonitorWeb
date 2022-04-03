<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/journalStyle.css" type="text/css">
    </head>
    <body>
        <?php
            require 'Connection.php';
            
            // Create connection
            $conn = MysqlConnect();
            
            $sql = "SELECT * FROM `Journal` ORDER BY Date DESC, Time DESC";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                // output data of each row
                echo "<table>
                <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Data</th>
                <th>Rev. value</th>
                </tr>";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>".$row["Date"]."</td>
                    <td>".$row["Time"]."</td>
                    <td>".$row["Data"]."</td>
                    <td>".$row["RevisionVal"]."</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
            
            $conn->close();
        ?>
    </body>
</html>