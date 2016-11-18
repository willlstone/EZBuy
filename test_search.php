<?php
 header('Access-Control-Allow-Origin: *');
 if (isset($_POST["data"]) && !empty($_POST["data"])) {
   $data = json_decode($_POST['data']); 
   foreach($data as $d){
      echo $d[0] . "<br>";
	 }
  }
?>


<!Doctype html>
<html>
<head>
	<style>
	body{
		background: green;
	}
	#wrapper {
		background: red;
		width: 75%;
		margin: 0 auto;
	}
	</style>
</head>
<body>
	<div id="wrapper">
		<div class="container">
			<div class="form-group">
                <input type="text" value="" name="search" id="search" class="form-control">
                <input type="submit" onclick="get_results()" name="submit" value="Submit" class="btn btn-primary" />
            </div>
			<div id="Results">
				<div class="results">
				</div>
			</div>
		</div>
	</div>
</body>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script>
    function get_results(){
      $(document).ready(function(){
        var keywords = $("input[name='search']").val();
        var arr = keywords.split(" ");

        $.when(
          $.get("https://api.bestbuy.com/v1/products((search=MacBook&search=Pro)&(categoryPath.id=abcat0502000))?apiKey=RYHclylDU0CfO272Hgyi4AKY&sort=regularPrice.asc&show=name,thumbnailImage,regularPrice,url,customerReviewAverage&pageSize=15&format=xml"),
          // $.get("http://api.walmartlabs.com/v1/search?query=ipod&format=xml&categoryId=3944&apiKey=axf4sj97cjkfvk3hdh9jvvy3")
          $.ajax({type: "GET", url: "http://api.walmartlabs.com/v1/search?query=ipod&format=json&categoryId=3944&apiKey=axf4sj97cjkfvk3hdh9jvvy3",dataType: "jsonp",jsonp: "callback"})
        ).done(function (result1, result2) {
          
          var master_array = [];
          //Handles BestBuy API
          function addToListBestBuy() {
            master_array.push([
              $(this).find('name').text(),
              $(this).find('regularPrice').text(),
              $(this).find('customerReviewAverage').text(),
              $(this).find('url').text(), 
              $(this).find('thumbnailImage').text()
            ]);
            $('<ul></ul>').html("<li>" + $(this).find('name').text() + "</li><li>" + $(this).find('regularPrice').text() + "</li><li><img src='" + $(this).find('thumbnailImage').text() + "'></li>").appendTo(".results");
          }

          //Handles Walmart API
          function addToListWalmart(jsonp) {
            var obj = $.parseJSON(JSON.stringify(jsonp));
            var items = obj.items;
            for(i = 0; i < 10; i++){
              var customerReviewAverage = items[i].customerRating;
              var regularPrice = items[i].msrp;
              var name = items[i].name;
              var url = items[i].productUrl;
              var thumbnailImage = items[i].thumbnailImage;
              $('<ul></ul>').html("<li>" + name + "</li><li>" + regularPrice + "</li><li><img src='" + thumbnailImage + "' style='height:90px;width:90px' alt='img'></li>").appendTo(".results");
              master_array.push([name, regularPrice, customerReviewAverage, url, thumbnailImage]);
            }
          }

          //Amazon API
          
          

          $(result1).find('product').each(addToListBestBuy);
          addToListWalmart(result2[0]);

          var st = JSON.stringify(master_array);
          $.post('test_search.php',{data:st},function(data){
            alert(data);
          });
          // or work with master_array
        });
      });
    }
    </script>
</html>