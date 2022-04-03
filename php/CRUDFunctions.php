<?php
    function sqlInsertUpdate($quer, $conn)
    {
        if ($conn->query($quer) === TRUE) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $quer . "<br>" . $conn->error;
        }
    }

    function sqlSelectOne($quer, $conn)
    {
        $result = $conn->query($quer);
        return $result->fetch_row()[0];
    }
?>