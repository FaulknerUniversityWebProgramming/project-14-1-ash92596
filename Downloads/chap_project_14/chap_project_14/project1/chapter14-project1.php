<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chapter 14</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-orange.min.css">

    <link rel="stylesheet" href="css/styles.css">
    
    <script   src="https://code.jquery.com/jquery-1.7.2.min.js" ></script>
    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
</head>

<body>
    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
            
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">
            <div class="mdl-grid">
              <!-- mdl-cell + mdl-card -->
              <div class="mdl-cell mdl-cell--3-col card-lesson mdl-card  mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Employees</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <ul class="demo-list-item mdl-list">

                         <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "ashleigh1";
                            $dbname = "book";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            } 

                            $sql = "SELECT EmployeeID, FirstName, LastName FROM Employees ORDER BY LastName ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                              echo "<ul style='list-style: none;'>";
                                while($row = $result->fetch_assoc()) {
                                  echo "<li><a href='?employee=" . $row["EmployeeID"] ."'><p>" . $row["FirstName"] . " " . $row["LastName"] . "</p></a></li>";
                                  }
                              echo "</ul>";
                            } else {
                                echo "0 results";
                            }
                      
                             $conn->close();   
                         ?>            
                    </ul>
                </div>
              </div>  <!-- / mdl-cell + mdl-card -->
              
              <!-- mdl-cell + mdl-card -->
              <div class="mdl-cell mdl-cell--9-col card-lesson mdl-card  mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Employee Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <div class="mdl-tabs mdl-js-tabs mdl-js-ripple-effect">
                          <div class="mdl-tabs__tab-bar">
                              <a href="#address-panel" class="mdl-tabs__tab is-active">Address</a>
                              <a href="#todo-panel" class="mdl-tabs__tab">To Do</a>
                          </div>
                          <div class="mdl-tabs__panel is-active" id="address-panel">
                              
                     <?php
                           $link = mysqli_connect("localhost", "root", "ashleigh1", "book"); 
                                 if($link === false){ 
                                     die("ERROR: Could not connect. " 
                                         . mysqli_connect_error()); 
                                 } 
                                  
                                  $sql = "SELECT Employees.FirstName, Employees.LastName, Employees.Address, Employees.City, Employees.Region, Employees.Country, Employees.Postal, Employees.Email, Employees.EmployeeID
                                          FROM Employees 
                                          INNER JOIN EmployeeToDo ON Employees.EmployeeID=EmployeeToDo.EmployeeID WHERE Employees.EmployeeID=". $_GET['employee'] . " GROUP BY Employees.EmployeeID"; 

                                        if($res = mysqli_query($link, $sql)){ 
                                            if(mysqli_num_rows($res) > 0){ 
                                                while($row = mysqli_fetch_array($res)){ 
                                                    echo "<p>" . $row["FirstName"] . 
                                                      " " . $row["LastName"] . "<br>" . $row["Address"] . 
                                                      "<br>" . $row["City"] . ", " . $row["Region"] . 
                                                      "<br>" . $row["Country"] . ", " . $row["Postal"] . 
                                                      "<br>" . $row["Email"] . "</p>";
                                                 }
                                              
                                                mysqli_free_result($res); 
                                             
                                            } else{ 
                                                  echo "No Matching records are found."; 
                                             }
                                          } else{ 
                                              echo "ERROR: Could not able to execute $sql. "  
                                                    . mysqli_error($link); 
                                            }
                                          mysqli_close($link); 
                                      ?> 
                           
         
                          </div>
                          
                          <div class="mdl-tabs__panel" id="todo-panel">  
                                  <tbody>
                                    
                                    <?php
                                          $link = mysqli_connect("localhost", "root", "ashleigh1", "book"); 

                                          if($link === false){ 
                                              die("ERROR: Could not connect. " 
                                                    . mysqli_connect_error()); 
                                          } 

                                          $sql = "SELECT * FROM EmployeeToDo WHERE EmployeeID=". $_GET['employee']; 
                                          if($res = mysqli_query($link, $sql)){ 
                                              if(mysqli_num_rows($res) > 0){ 
                                                  echo "<table class='mdl-data-table  mdl-shadow--2dp'>"; 
                                                      echo "<tr>"; 
                                                          echo "<th class='mdl-data-table__cell--non-numeric'>Date</th>"; 
                                                          echo "<th class='mdl-data-table__cell--non-numeric'>Status</th>"; 
                                                          echo "<th class='mdl-data-table__cell--non-numeric'>Priority</th>"; 
                                                          echo "<th class='mdl-data-table__cell--non-numeric'>Content</th>";
                                                      echo "</tr>"; 
                                                  while($row = mysqli_fetch_array($res)){ 
                                                      echo "<tr>"; 
                                                          echo "<td>" . $row['DateBy'] . "</td>"; 
                                                          echo "<td>" . $row['Status'] . "</td>"; 
                                                          echo "<td>" . $row['Priority'] . "</td>";
                                                          echo "<td>" . $row['Description'] . "</td>";
                                                      echo "</tr>"; 
                                                  } 
                                                  echo "</table>"; 
                                                  mysqli_free_result($res); 
                                              } else{ 
                                                  echo "No Matching records are found."; 
                                                } 
                                          } else{ 
                                              echo "ERROR: Could not able to execute $sql. "  
                                                    . mysqli_error($link); 
                                            } 

                                          mysqli_close($link); 
                                      ?> 
                                    
                </div>
              </div>                         
            </div>
          </div>  <!-- / mdl-cell + mdl-card -->   
        </div>  <!-- / mdl-grid -->    
      </section>
    </main>    
  </div>    <!-- / mdl-layout --> 
  
</body>
</html>
