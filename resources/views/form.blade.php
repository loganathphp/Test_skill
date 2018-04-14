@extends('header')
@section('content')

<div class="container">
	<h1>Add Stock</h1>
	<div class="alert alert-success" style="display: none;">
	  <strong>Success!</strong> <div id="success_msg"> Indicates a successful or positive action.</div>
	</div>

	<div class="alert alert-info" style="display: none;">
	  <strong>Unsuccess!</strong> <div id="info_msg"> Something Error.</div>
	</div>

	<div class="alert alert-danger" style="display: none;">
	  <strong>Unsuccess!</strong> <div id="danger_msg">  Something Error.</div>
	</div>

	<form id="stock_from">
		
		<div class="form-group">
		  <label for="usr">Product name:</label>
		  <input type="text" name="product_name" class="form-control" id="product_name">
		</div>
		<div class="form-group">
		  <label for="pwd">Quantity :</label>
		  <input type="number" name="quantity" class="form-control" id="quantity">
		</div>
		<div class="form-group">
		  <label for="pwd">Stock :</label>
		  <input type="number" name="stock" class="form-control" id="stock">
		</div>
		<div class="form-group">
		  <label for="pwd">Price Per Item:</label>
		  <input type="number" name="price_per_unit" class="form-control" id="price_per_unit">
		  <input type="hidden" name="date" class="form-control" id="date" value="<?php echo date("d-m-Y h:i") ?>" >
		  <input type="hidden" name="total" class="form-control" id="total" >
		</div>
		<button type="submit" id="stock_submit">Submit</button>
	</form>
</div>


<div class="container">
	<h1>Stocks List</h1>
	<table class="table">
    <thead>
      <tr>
        <th>Product name</th>
        <th>Quantity</th>
        <th>Stock</th>
        <th>Price Per Item</th>
        <th>Date</th>
        <th>Total value number</th>
      </tr>
    </thead>
    <tbody>
      @if(!empty($data))
      @foreach($data as $d)
      <tr class="data">
        <td>{{$d['product_name']}}</td>
        <td>{{$d['quantity']}}</td>
        <td>{{$d['stock']}}</td>
        <td>{{$d['price_per_unit']}}</td>
        <td>{{$d['date']}}</td>
        <td class="sub_total">{{$d['total']}}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="4"></td>
        <td><h4>Total</td>
        <td id="grand_total"></td></h4>
      </tr>
      @endif
    </tbody>
  </table>
</div>

<script type="text/javascript">


var grand_total= 0;
$(".table tbody .data").each(function(i,v){
	var val =$(this).find('.sub_total').text();
	grand_total += parseInt(val);  
	console.log(val);

});	
$("#grand_total").text(grand_total);

$("#stock_submit").click(function(e){
    e.preventDefault();
    if(!$("#stock_from").valid()){return;}
    var total = parseInt($("#stock").val())*parseInt($("#price_per_unit").val());
    $("#total").val(total);	
    var form = $('#stock_from')[0]; 
    var formData = new FormData(form);
   	$.ajax({
	  type: "POST",
      url: "{{route('store')}}",
      data: formData,
      contentType: false, 
      processData: false, 
    })
    .done(function(success){
     console.log(success);
      if(success=="1"){
       $(".alert-success").show();	
       $(".alert-success #success_msg").html("Stock Added Successfully");
       form.reset();
	   location.reload();
      }
      else
      {
      	$(".alert-danger").show();
      	$(".alert-success #success_msg").html("Stock Not Added");
       	form.reset();
	   	location.reload();
      }

    })
    .fail(function(fail){
	  $(".alert-danger").show();
      $(".alert-success #success_msg").html("Something went wrong");
       form.reset();
	   location.reload();
    });
});


$("#stock_from").validate({
      rules: {
        product_name: {required: true},
        quantity: {required: true,number:true},
        stock: {required: true,number:true},
        price_per_unit: {required: true,number:true},
	   },
    
});


</script>
@endsection