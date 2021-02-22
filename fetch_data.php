<style>
	
	#imgc {
  width: 100%;
	}
#imgc:hover {
  transition: 0.5s;
  transform: scale(0.95);
	}
</style>
<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM house WHERE house_status = '1'
	";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		 AND house_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["sqft_minimum"], $_POST["sqft_maximum"]) && !empty($_POST["sqft_minimum"]) && !empty($_POST["sqft_maximum"]))
	{
		$query .= "
		 AND house_squareft BETWEEN '".$_POST["sqft_minimum"]."' AND '".$_POST["sqft_maximum"]."'
		";
	}
	
	if(isset($_POST["location"]))
	{
		$location_filter = implode("','", $_POST["location"]);
		$query .= "
		 AND house_location IN('".$location_filter."')
		";
	}
	if(isset($_POST["bhk"]))
	{
		$bhk_filter = implode("','", $_POST["bhk"]);
		$query .= "
		 AND house_bhk IN('".$bhk_filter."')
		";
	}
	if(isset($_POST["balcony"]))
	{
		$balcony_filter = implode("','", $_POST["balcony"]);
		$query .= "
		 AND house_balcony IN('".$balcony_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
                    <div style="border:3px solid #ccc; border-radius:10px; padding:5px; margin-bottom:16px; height:auto;">
                      <div style="width=100%;">
                      <img src="image/'. $row['house_image'] .'" alt="not found" class="img-fluid"  style="text-align:center;max-width:100%;border-radius:10px;height:auto;">
                      </div>
                      <label style="color:black;">Location :</label>  '. $row['house_location'] .' <br />
											<label style="color:black;">Price :</label> '. $row['house_price'] .' <br />
											<label style="color:black;">Squareft :</label> '. $row['house_squareft'] .' <br />
                      <label style="color:black;">BHK :</label> '. $row['house_bhk'] .' BHK<br />
                      <label style="color:black;">Balcony :</label>  '. $row['house_balcony'] .'  </p>
                      <label style="color:black;">City :</label>  '. $row['house_location'] .' <br/>
                      <label style="color:black;">Mobile_no :</label>  '. $row['mobile_no'] .' <br />
					  <label style="color:black;">Address :</label>  '. $row['house_address'] .' </p>
					  <p><a href="contact.php" class= "btn btn-danger">Contact Builder</a></p>
                    </div>
            
                  </div>
            
								</div>






			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>