<?php 
session_start();
if(!isset($_SESSION["email"])){
  header("location:../index.php");
}

include("navbar.php");
include("engine.php");

 ?>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>

 <div class="container-fluid">
  <ul class="nav nav-pills nav-justified">
    <li class="active" style="background-color: #FFF8DC"><a data-toggle="pill" href="#home">Profile</a></li>
    <li style="background-color: #FAC0E6"><a data-toggle="pill" href="#menu4">Messages</a></li>
    <li style="background-color: #FAF0E6"><a data-toggle="pill" href="#menu1">Add Property</a></li>
    <li style="background-color: #FFFACD"><a data-toggle="pill" href="#menu2">View Property</a></li>
    <li style="background-color: #FFFAF0"><a data-toggle="pill" href="#menu3">Update Property</a></li>
    <li style="background-color: #FAFAF0"><a data-toggle="pill" href="#menu6">Booked Property</a></li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <center><h3>Owner Profile</h3></center>
      <div class="container">
      <?php 
        include("../config/config.php");
        $u_email= $_SESSION["email"];

        $sql="SELECT * from owner where email='$u_email'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          
       ?>
        <div class="card">
  <img src="../images/avatar.png" alt="John" style="height:200px; width: 100%">
  <h1><?php echo $rows['full_name']; ?></h1>
  <p class="title"><?php echo $rows['email']; ?></p>
  <p><b>Phone No.: </b><?php echo $rows['phone_no']; ?></p>
  <p><b>Address: </b><?php echo $rows['address']; ?></p>
  <p><b>Id Type: </b><?php echo $rows['id_type']; ?></p>
  <p><img src="../<?php echo $rows['id_photo']; ?>" height="100px"></p>

  <!-- Trigger the modal with a button -->
  <p><button type="button" class="btn btn-lg" data-toggle="modal" data-target="#myModal">Update Profile</button></p>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Profile</h4>
        </div>
        <div class="modal-body">

            <form method="POST">
                <div class="form-group">
                  <label for="full_name">Full Name:</label>
                  <input type="hidden" value="<?php echo $rows['owner_id']; ?>" name="owner_id">
                  <input type="text" class="form-control" id="full_name" value="<?php echo $rows['full_name']; ?>" name="full_name">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" value="<?php echo $rows['email']; ?>" name="email" readonly>
                </div>
                <div class="form-group">
                  <label for="phone_no">Phone No.:</label>
                  <input type="text" class="form-control" id="phone_no" value="<?php echo $rows['phone_no']; ?>" name="phone_no">
                </div>
                <div class="form-group">
                  <label for="address">Address:</label>
                  <input type="text" class="form-control" id="address" value="<?php echo $rows['address']; ?>" name="address">
                </div>
                <div class="form-group">
      <label for="id_type">Type of ID:</label>
      <input type="text" class="form-control" value="<?php echo $rows['id_type']; ?>" name="id_type" readonly>
    </div>
    <div class="form-group">
      <label>Your Id:</label><br>
      <img src="../<?php echo $rows['id_photo']; ?>" id="output_image"/ height="100px" readonly>
    </div>
                <hr>
                <center><button id="submit" name="owner_update" class="btn btn-primary btn-block">Update</button></center><br>
                
              </form>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
</div>
    </div>
    </div>






    <div id="menu4" class="tab-pane fade">
      <div class="container">
      <center><h3>See Messages</h3></center>
            <?php 
      $owner_id=$rows['owner_id']; 
      $sql1="SELECT * FROM chat where owner_id='$owner_id' ";

    $query1 = mysqli_query($db,$sql1);

  if(mysqli_num_rows($query1)>0)
  {
    while($row= mysqli_fetch_assoc($query1)){

      $tenant_id=$row['tenant_id'];
      $sql2="SELECT * FROM tenant where tenant_id='$tenant_id' ";

    $query2 = mysqli_query($db,$sql2);

  if(mysqli_num_rows($query2)>0)
  {
    while ($rows= mysqli_fetch_assoc($query2)){
    
?>

   
<link rel="stylesheet" type="text/css" href="message-style.css">

<div class="tab">   
  <button class="tablinks" id="defaultOpen" onmouseover="openCity(event, '<?php echo $rows["full_name"]; ?>')"><?php echo $rows["full_name"]; ?></button>
</div>

<div id="<?php echo $rows["full_name"]; ?>" class="tabcontent">
  <?php
   $sql3="SELECT * FROM chat where tenant_id='$tenant_id' AND owner_id='$owner_id' ";

    $query3 = mysqli_query($db,$sql3);

  if(mysqli_num_rows($query3)>0)
  {
    while($ro= mysqli_fetch_assoc($query3)){
      echo $ro["message"]."<br>";
    }}
  ?>
</div>

<div class="clearfix"></div>


<?php
        //echo '<a href="send-message.php?owner_id='.$owner_id.'&tenant_id='.$tenant_id.'">'.$rows["full_name"].'</a>';
    }
  }}}}}?>
    </div>
    </div>







    <div id="menu1" class="tab-pane fade">
      <center><h3>Add Property</h3></center>
      <div class="container">

      
<div id="map_canvas"></div>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
              <label for="country">Country:</label>
              <select class="form-control" name="country" required="required">
                                <option value="">--Select Country--</option>
                                <option value="Algeria">Algeria</option>
              </select>
            </div>
            <div class="form-group">
              <label for="province">Province/State:</label>
              <select class="form-control" name="province" required="required">
                                <option value="">--Select Province/State--</option>
                                <option value="Adrar">Adrar</option>
                                <option value="Chlef">Chlef</option>
                                <option value="Laghouat">Laghouat</option>
                                <option value="Oum El Bouaghi">Oum El Bouaghi</option>
                                <option value="Batna">Batna</option>
                                <option value="Béjaïa">Béjaïa</option>
                                <option value="Biskra">Biskra</option>
                                <option value="Béchar">Béchar</option>
                                <option value="Blida">Blida</option>
                                <option value="Bouira">Bouira</option>
                                <option value="Tamanrasset">Tamanrasset</option>
                                <option value="Tébessa">Tébessa</option>
                                <option value="Tlemcen">Tlemcen</option>
                                <option value="Tiaret">Tiaret</option>
                                <option value="Tizi Ouzou">Tizi Ouzou</option>
                                <option value="Alger">Alger</option>
                                <option value="Djelfa">Djelfa</option>
                                <option value="Jijel">Jijel</option>
                                <option value="Sétif">Sétif</option>
                                <option value="Saïda">Saïda</option>
                                <option value="Skikda">Skikda</option>
                                <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
                                <option value="Annaba">Annaba</option>
                                <option value="Guelma">Guelma</option>
                                <option value="Constantine">Constantine</option>
                                <option value="Médéa">Médéa</option>
                                <option value="Mostaganem">Mostaganem</option>
                                <option value="M'Sila">M'Sila</option>
                                <option value="Mascara">Mascara</option>
                                <option value="Ouargla">Ouargla</option>
                                <option value="Oran">Oran</option>
                                <option value="El Bayadh">El Bayadh</option>
                                <option value="Illizi">Illizi</option>
                                <option value="Bordj Bou Arréridj">Bordj Bou Arréridj</option>
                                <option value="Boumerdès">Boumerdès</option>
                                <option value="El Tarf">El Tarf</option>
                                <option value="Tindouf">Tindouf</option>
                                <option value="Tissemsilt">Tissemsilt</option>
                                <option value="El Oued">El Oued</option>
                                <option value="Khenchela">Khenchela</option>
                                <option value="Souk Ahras">Souk Ahras</option>
                                <option value="Tipaza">Tipaza</option>
                                <option value="Mila">Mila</option>
                                <option value="Aïn Defla">Aïn Defla</option>
                                <option value="Naâma">Naâma</option>
                                <option value="Aïn Témouchent">Aïn Témouchent</option>
                                <option value="Ghardaïa">Ghardaïa</option>
                                <option value="Relizane">Relizane</option>
              </select>
            </div>
            
           
            <div class="form-group">
              <label for="city">City:</label>
              <input type="text" class="form-control" id="city" placeholder="Enter City" name="city">
            </div>
            
            
            <div class="form-group">
              <label for="contact_no">Contact No.:</label>
              <input type="text" class="form-control" id="contact_no" placeholder="Enter Contact No." name="contact_no">
            </div>
            <div class="form-group">
               <label for="property_type">Property Type:</label>
                <select class="form-control" name="property_type">
                      <option value="">--Select Property Type--</option>
                      <option value="Full House Rent">Full House Rent</option>
                      <option value="Flat Rent">Flat Rent</option>
                      <option value="Room Rent">Room Rent</option>
                </select>
            </div>                      
            <div class="form-group">
                <label for="estimated_price">Estimated Price:</label>
                <input type="estimated_price" class="form-control" id="estimated_price" placeholder="Enter Estimated Price" name="estimated_price">
            </div>
        </div>

        <div class="col-sm-6">
                  <div class="form-group">
                    <label for="total_rooms">Total No. of Rooms:</label>
                    <input type="number" class="form-control" id="total_rooms" placeholder="Enter Total No. of Rooms" name="total_rooms">
                  </div>
                  <div class="form-group">
                    <label for="bedroom">No. of Bedroom:</label>
                    <input type="number" class="form-control" id="bedroom" placeholder="Enter No. of Bedroom" name="bedroom">
                  </div>
                  <div class="form-group">
                    <label for="living_room">No. of Living Room:</label>
                    <input type="number" class="form-control" id="living_room" placeholder="Enter No. of Living Room" name="living_room">
                  </div>
                  <div class="form-group">
                    <label for="kitchen">No. of Kitchen:</label>
                    <input type="number" class="form-control" id="kitchen" placeholder="Enter No. of Kitchen" name="kitchen">
                  </div>
                  <div class="form-group">
                    <label for="bathroom">No. of Bathroom/Washroom:</label>
                    <input type="number" class="form-control" id="bathroom" placeholder="Enter No. of Bathroom/Washroom" name="bathroom">
                  </div>
                  <div class="form-group">
                    <label for="description">Full Description:</label>
                    <textarea type="comment" class="form-control" id="description" placeholder="Enter Property Description" name="description"></textarea>
                  </div>
                  
                  <table class="table" id="dynamic_field">  
                  <tr> 
                    <div class="form-group"> 
                    <label><b>Photos:</b></label>                    
                    <td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td> 
                    <td><button type="button" id="add" name="add" class="btn btn-success col-lg-12">Add More</button></td>  
                  </div>
                  </tr>  
                </table>
                <input name="lat" type="text" id="lat" hidden>
                <input name="lng" type="text" id="lng" hidden>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg col-lg-12" value="Add Property" name="add_property">
                  </div>
                </div>
              </div>
              </form>
              <br><br>

    </div>
    </div>


    <div id="menu2" class="tab-pane fade">
      <center><h3>View Property</h3></center>
      <div class="container-fluid">
      <input type="text" id="myInput" onkeyup="viewProperty()" placeholder="Search..." title="Type in a name">
            <div style="overflow-x:auto;">
              <table id="myTable">
                <tr class="header">
                  <th>Id.</th>
                  <th>Country</th>
                  <th>Province/State</th>
                  <th>City</th>
                  <th>Contact No.</th>
                  <th>Property Type</th>
                  <th>Estmated Price</th>
                  <th>Total Rooms</th>
                  <th>Bedroom</th>
                  <th>Living Room</th>
                  <th>Kitchen</th>
                  <th>Bathroom</th>
                  <th>Description</th>
                  <th>Photos</th>
                </tr>
                <?php 
                $u_email=$_SESSION['email'];
        $sql1="SELECT * from owner where email='$u_email'";
        $result1=mysqli_query($db,$sql1);

        if(mysqli_num_rows($result1)>0)
      {
          while($rowss=mysqli_fetch_assoc($result1)){
            $owner_id=$rowss['owner_id'];

        $sql="SELECT * from add_property where owner_id='$owner_id'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          $property_id=$rows['property_id'];
       ?>
                <tr>
                  <td><?php echo $rows['property_id'] ?></td>
                  <td><?php echo $rows['country'] ?></td>
                  <td><?php echo $rows['province'] ?></td>
                  <td><?php echo $rows['city'] ?></td>
                  <td><?php echo $rows['contact_no'] ?></td>
                  <td><?php echo $rows['property_type'] ?></td>
                  <td>Rs.<?php echo $rows['estimated_price'] ?></td>
                  <td><?php echo $rows['total_rooms'] ?></td>
                  <td><?php echo $rows['bedroom'] ?></td>
                  <td><?php echo $rows['living_room'] ?></td>
                  <td><?php echo $rows['kitchen'] ?></td>
                  <td><?php echo $rows['bathroom'] ?></td>
                  <td><?php echo $rows['description'] ?></td><td>
<?php $sql2="SELECT * from property_photo where property_id='$property_id'";
        $query=mysqli_query($db,$sql2);

        if(mysqli_num_rows($query)>0)
      {
          while($row=mysqli_fetch_assoc($query)){ ?>
                  <img src="<?php echo $row['p_photo'] ?>" width="50px">
                <?php }}}}}} ?>
                </td>
                </tr>
              </table> 
            </div>
    </div>
    </div>

    <div id="menu3" class="tab-pane fade">
      <center><h3>Update Property</h3></center>
      <div class="container-fluid">
      <input type="text" id="myInput" onkeyup="updateProperty()" placeholder="Search..." title="Type in a name">
            <div style="overflow-x:auto;">
              <table id="myTable">
                <tr class="header">
                  <th>Id.</th>
                  <th>Country</th>
                  <th>Province/State</th>
                  <th>City</th>
                  <th>Contact No.</th>
                  <th>Property Type</th>
                  <th>Estmated Price</th>
                  <th>Total Rooms</th>
                  <th>Bedroom</th>
                  <th>Living Room</th>
                  <th>Kitchen</th>
                  <th>Bathroom</th>
                  <th>Description</th>
                  <th>Photos</th>
                  <th>Edit/Delete</th>
                </tr>
                <?php 

        $sql="SELECT * from add_property where owner_id='$owner_id'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          $property_id=$rows['property_id'];
       ?>
                <tr>
                  <td><?php echo $rows['property_id'] ?></td>
                  <td><?php echo $rows['country'] ?></td>
                  <td><?php echo $rows['province'] ?></td>
                  <td><?php echo $rows['city'] ?></td>
                  <td><?php echo $rows['contact_no'] ?></td>
                  <td><?php echo $rows['property_type'] ?></td>
                  <td>Rs.<?php echo $rows['estimated_price'] ?></td>
                  <td><?php echo $rows['total_rooms'] ?></td>
                  <td><?php echo $rows['bedroom'] ?></td>
                  <td><?php echo $rows['living_room'] ?></td>
                  <td><?php echo $rows['kitchen'] ?></td>
                  <td><?php echo $rows['bathroom'] ?></td>
                  <td><?php echo $rows['description'] ?></td><td>
<?php $sql2="SELECT * from property_photo where property_id='$property_id'";
        $query=mysqli_query($db,$sql2);

        if(mysqli_num_rows($query)>0)
      {
          while($row=mysqli_fetch_assoc($query)){ ?>
                  <img src="<?php echo $row['p_photo'] ?>" width="50px">
                <?php }}  ?>
                </td>
                <form method="POST">
                <td>
                  <input type="hidden" name="property_id" value="<?php echo $rows['property_id']; ?>">
                  <a data-toggle="pill" class="btn btn-success" name="edit_property" onclick="<?php $property_id = $rows['property_id'] ?>" href="#menu5">Edit</a><input type="submit" class="btn btn-danger" name="delete_property" value="Delete">
                  </td>
                </tr>
                </form>
                <?php }} ?>
              </table> 
            </div>
    </div>
    </div>




    <div id="menu5" class="tab-pane fade">
      <center><h3>Edit Property Details</h3></center>
      <div class="container">

      
<div id="map_canvas"></div>
        <form method="POST" enctype="multipart/form-data">
          <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
              <label for="country">Country:</label>
              <select class="form-control" name="country" required="required">
                                <option value="">--Select Country--</option>
                                <option value="Algeria">Algeria</option>
              </select>
            </div>
            <div class="form-group">
              <label for="province">Province/State:</label>
              <select class="form-control" name="province" required="required">
                                <option value="">--Select Province/State--</option>
                                <option value="Adrar">Adrar</option>
                                <option value="Chlef">Chlef</option>
                                <option value="Laghouat">Laghouat</option>
                                <option value="Oum El Bouaghi">Oum El Bouaghi</option>
                                <option value="Batna">Batna</option>
                                <option value="Béjaïa">Béjaïa</option>
                                <option value="Biskra">Biskra</option>
                                <option value="Béchar">Béchar</option>
                                <option value="Blida">Blida</option>
                                <option value="Bouira">Bouira</option>
                                <option value="Tamanrasset">Tamanrasset</option>
                                <option value="Tébessa">Tébessa</option>
                                <option value="Tlemcen">Tlemcen</option>
                                <option value="Tiaret">Tiaret</option>
                                <option value="Tizi Ouzou">Tizi Ouzou</option>
                                <option value="Alger">Alger</option>
                                <option value="Djelfa">Djelfa</option>
                                <option value="Jijel">Jijel</option>
                                <option value="Sétif">Sétif</option>
                                <option value="Saïda">Saïda</option>
                                <option value="Skikda">Skikda</option>
                                <option value="Sidi Bel Abbès">Sidi Bel Abbès</option>
                                <option value="Annaba">Annaba</option>
                                <option value="Guelma">Guelma</option>
                                <option value="Constantine">Constantine</option>
                                <option value="Médéa">Médéa</option>
                                <option value="Mostaganem">Mostaganem</option>
                                <option value="M'Sila">M'Sila</option>
                                <option value="Mascara">Mascara</option>
                                <option value="Ouargla">Ouargla</option>
                                <option value="Oran">Oran</option>
                                <option value="El Bayadh">El Bayadh</option>
                                <option value="Illizi">Illizi</option>
                                <option value="Bordj Bou Arréridj">Bordj Bou Arréridj</option>
                                <option value="Boumerdès">Boumerdès</option>
                                <option value="El Tarf">El Tarf</option>
                                <option value="Tindouf">Tindouf</option>
                                <option value="Tissemsilt">Tissemsilt</option>
                                <option value="El Oued">El Oued</option>
                                <option value="Khenchela">Khenchela</option>
                                <option value="Souk Ahras">Souk Ahras</option>
                                <option value="Tipaza">Tipaza</option>
                                <option value="Mila">Mila</option>
                                <option value="Aïn Defla">Aïn Defla</option>
                                <option value="Naâma">Naâma</option>
                                <option value="Aïn Témouchent">Aïn Témouchent</option>
                                <option value="Ghardaïa">Ghardaïa</option>
                                <option value="Relizane">Relizane</option>
              </select>
            </div>
            
            <div class="form-group">
              <label for="city">City:</label>
              <input type="text" class="form-control" id="city" placeholder="Enter City" name="city">
            </div>
            
            
            <div class="form-group">
              <label for="contact_no">Contact No.:</label>
              <input type="text" class="form-control" id="contact_no" placeholder="Enter Contact No." name="contact_no">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
               <label for="property_type">Property Type:</label>
                <select class="form-control" name="property_type">
                      <option value="">--Select Property Type--</option>
                      <option value="Full House Rent">Full House Rent</option>
                      <option value="Flat Rent">Flat Rent</option>
                      <option value="Room Rent">Room Rent</option>
                </select>
            </div>                      
            <div class="form-group">
                <label for="estimated_price">Estimated Price:</label>
                <input type="estimated_price" class="form-control" id="estimated_price" placeholder="Enter Estimated Price" name="estimated_price">
            </div>
                  <div class="form-group">
                    <label for="total_rooms">Total No. of Rooms:</label>
                    <input type="number" class="form-control" id="total_rooms" placeholder="Enter Total No. of Rooms" name="total_rooms">
                  </div>
                  <div class="form-group">
                    <label for="bedroom">No. of Bedroom:</label>
                    <input type="number" class="form-control" id="bedroom" placeholder="Enter No. of Bedroom" name="bedroom">
                  </div>
                  <div class="form-group">
                    <label for="living_room">No. of Living Room:</label>
                    <input type="number" class="form-control" id="living_room" placeholder="Enter No. of Living Room" name="living_room">
                  </div>
                  <div class="form-group">
                    <label for="kitchen">No. of Kitchen:</label>
                    <input type="number" class="form-control" id="kitchen" placeholder="Enter No. of Kitchen" name="kitchen">
                  </div>
                  <div class="form-group">
                    <label for="bathroom">No. of Bathroom/Washroom:</label>
                    <input type="number" class="form-control" id="bathroom" placeholder="Enter No. of Bathroom/Washroom" name="bathroom">
                  </div>
                  <div class="form-group">
                    <label for="description">Full Description:</label>
                    <textarea type="comment" class="form-control" id="description" placeholder="Enter Property Description" name="description"></textarea>
                  </div>
                  <hr>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg col-lg-12" value="Update Property" name="add_property">
                  </div>
                </div>
              </div>
              </form>
              <br><br>

    </div>
    </div>

<div id="menu6" class="tab-pane fade">
      <center><h3>Booked Property</h3></center>
      <div class="container">
        <input type="text" id="myInput" onkeyup="bookedProperty()" placeholder="Search..." title="Type in a name">

              <table id="myTable">
                <tr class="header">
                  <th>Booked By</th>
                  <th>Booker Address</th>
                  <th>Property Province</th>
                  
                </tr>

      <?php 
        include("../config/config.php");
            $u_email= $_SESSION["email"];

        $sql3="SELECT * from owner where email='$u_email'";
            $result3=mysqli_query($db,$sql3);

            if(mysqli_num_rows($result3)>0)
          {
              while($rowss=mysqli_fetch_assoc($result3)){
                $owner_id=$rowss['owner_id'];

                $sql2="SELECT * from add_property where owner_id='$owner_id'";
        $result2=mysqli_query($db,$sql2);

        if(mysqli_num_rows($result2)>0)
      {
          while($ro=mysqli_fetch_assoc($result2)){
            $property_id=$ro['property_id'];

        $sql="SELECT * from booking where property_id='$property_id'";
        $result=mysqli_query($db,$sql);

        if(mysqli_num_rows($result)>0)
      {
          while($rows=mysqli_fetch_assoc($result)){
          
       ?>
                <tr>
                  
        <?php 
        $tenant_id=$rows['tenant_id'];
        $property_id=$rows['property_id'];
        $sql1="SELECT * from tenant where tenant_id='$tenant_id'";
        $result1=mysqli_query($db,$sql1);

        if(mysqli_num_rows($result1)>0)
      {
          while($row=mysqli_fetch_assoc($result1)){
          
       ?>


        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['address']; ?></td>



                  <td><?php echo $ro['province']; ?></td>
              
                </tr>
              <?php }}}}}}}} ?>
              </table> 
    </div>
    </div>

  </div>
</div>
</body>




<script>
              function viewProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
              </script>
<script>
              function updateProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
              </script>
              <script>
              function bookedProperty() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                table = document.getElementById("myTable");
                tr = table.getElementsByTagName("tr");
                th = table.getElementsByTagName("th");
                for (i = 1; i < tr.length; i++) {
                  tr[i].style.display = "none";
                    for(var j=0; j<th.length; j++){
                      td = tr[i].getElementsByTagName("td")[j];      
                      if (td) {
                        if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1)
                        {
                          tr[i].style.display = "";
                          break;
                         }
                      }
                    }
                }
              }
              </script>
              <script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="file" name="p_photo[]" placeholder="Photos" class="form-control name_list" required accept="image/*" /></td></td> <td><button id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'); 
      });  

                 



      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
      $('#submit').click(function(){            
           $.ajax({  
                url:"name.php",  
                method:"POST",  
                data:$('#add_name').serialize(),  
                success:function(data)  
                {  
                     alert(data);  
                     $('#add_name')[0].reset();  
                }  
           });  
      });  
 });  
 </script>



 <script>
   if (status == google.maps.GeocoderStatus.OK) {
    map.setCenter(results[0].geometry.location);
    var marker = new google.maps.Marker;
    document.getElementById('lat').value = results[0].geometry.location.lat();
    document.getElementById('lng').value = results[0].geometry.location.lng();


   // add this
    var latt=results[0].geometry.location.lat();
    var lngg=results[0].geometry.location.lng();
    $.ajax({
        url: "your-php-code-url-to-save-in-database",
        dataType: 'json',
        type: 'POST',
        data:{ lat: lat, lng: lngg }
        success: function(data)
        {                
           //check here whether inserted or not 
        }
   });


 }
 </script>



<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>