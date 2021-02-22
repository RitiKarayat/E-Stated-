<?php 

//index.php

include('database_connection.php');

?>
<?php 
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Properties</title>

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <br />
            <div class="col-10">
                <h2 style="text-align:center;color:#f69314;font-size: 4rem;" >Houses Available</h2>
            </div>
            <div class="col-2" style="margin-left:90%; margin-top: -5%">
                <a href="logout.php" class="btn btn-danger ml-auto">Logout</a>
            </div>
        	
        	<br />
            <div class="col-md-3">                				
				<div class="list-group">
					<h3 style="color:#f69314;">Price(Rs.)</h3>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="65000" />
                    <p id="price_show">10 - 5000</p>
                    <div id="price_range"></div>
                </div>
                <div class="list-group">
					<h3 style="color:#f69314;">Square-Foot</h3>
					<input type="hidden" id="hidden_sqft_minimum" value="0" />
                    <input type="hidden" id="hidden_sqft_maximum" value="65000" />
                    <p id="sqft_show">10 - 5000</p>
                    <div id="sqft_range"></div>
                </div>				
                <div class="list-group">
					<h3 style="color:#f69314;">Location</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT(house_location) FROM house WHERE house_status = '1' ORDER BY house_id DESC";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector location" value="<?php echo $row['house_location']; ?>"  > <?php echo $row['house_location']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div>
                </div>

				<div class="list-group">
					<h3 style="color:#f69314;">bhk</h3>
                    <?php

                    $query = "
                    SELECT DISTINCT(house_bhk) FROM house WHERE house_status = '1' ORDER BY house_bhk DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector bhk" value="<?php echo $row['house_bhk']; ?>" > <?php echo $row['house_bhk']; ?> BHK</label>
                    </div>
                    <?php    
                    }

                    ?>
                </div>
				
				<div class="list-group">
					<h3 style="color:#f69314;"> balcony</h3>
					<?php
                    $query = "
                    SELECT DISTINCT(house_balcony) FROM house WHERE house_status = '1' ORDER BY house_balcony DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector balcony" value="<?php echo $row['house_balcony']; ?>"  > <?php echo $row['house_balcony']; ?> </label>
                    </div>
                    <?php
                    }
                    ?>	
                </div>
            </div>

            <div class="col-md-9">
            	<br />
                <div class="row filter_data">

                </div>
            </div>
        </div>

    </div>
<style>
#loading
{
	text-align:center; 
	background: url('loader.gif') no-repeat center; 
	height: 150px;
}
</style>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var sqft_minimum = $('#hidden_sqft_minimum').val();
        var sqft_maximum = $('#hidden_sqft_maximum').val();

        var location = get_filter('location');
        var bhk = get_filter('bhk');
        var balcony = get_filter('balcony');
        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price,sqft_minimum:sqft_minimum, sqft_maximum:sqft_maximum, location:location, bhk:bhk, balcony:balcony},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider({
        range:true,
        min:10,
        max:5000,
        values:[10, 5000],
        
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });
    $('#sqft_range').slider({
        range:true,
        min:10,
        max:5000,
        values:[10, 5000],
        
        stop:function(event, ui)
        {
            $('#sqft_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_sqft_minimum').val(ui.values[0]);
            $('#hidden_sqft_maximum').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>

</body>

</html>
<?php 
}else{
     header("Location: index.html");
     exit();
}
 ?>
