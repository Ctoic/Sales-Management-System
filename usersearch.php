<?php 

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    // Check if the query is 'shop'
    if (strtolower($query) === '$username') {
        header("Location: output.php");
        exit();
    } else {
        // Handle other search queries here if needed
        echo "No results found.";
    }
} else {
    echo "No search query provided.";
}




    ?>