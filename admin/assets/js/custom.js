// JavaScript Document
function delete_func(x)
{
	if (confirm("Are you sure you want to delete this item?"))
	{
		$("#delete_id").val(x);
		$("#delete_form").submit();
	}
}

function delete_func_2(x, y, z)
{
	if (confirm("Are you sure you want to delete this item?"))
	{
		$("#type_id").val(x);
		$("#item_id").val(y);
		$("#main_id").val(z);
		$("#delete_form").submit();
	}
}

function updatePriceGST(x)
{
	//alert(x);
	var price_raw 		= parseFloat($("#price_raw").val());
	var gst_percentage 	= parseFloat($("#gst_percentage").val());
	var gst_price 		= parseFloat($("#gst_price").val());
	var price 			= parseFloat($("#price").val());

	//alert(price_raw+' '+gst_percentage+' '+gst_price+' '+price);

	if(x == 1)
	{
		gst_price = (( price_raw * gst_percentage) / 100);
		price = (price_raw + gst_price);
		//price = price.toFixed(2);
		$("#price").val(price.toFixed(2));
		$("#gst_price").val(gst_price.toFixed(2));
		$("#gst_price_2").val(gst_price.toFixed(2));
	}
	if(x == 2)
	{
		gst_price = ((price_raw * gst_percentage) / 100);
		price = (price_raw + gst_price);
		$("#price").val(price.toFixed(2));
		$("#gst_price").val(gst_price.toFixed(2));
		$("#gst_price_2").val(gst_price.toFixed(2));
	}
	if(x == 4)
	{
		gst_price = ((price * gst_percentage) / 100);
		price_raw = (price - gst_price);
		$("#price_raw").val(price_raw.toFixed(2));
		$("#gst_price").val(gst_price.toFixed(2));
		$("#gst_price_2").val(gst_price.toFixed(2));
	}
}

function setDiscountOfferType(val)
{
	if(val == '1')
	{
		$('#discount3').show();
		$('#categorylist3').hide();
		$('#subcategorylist3').hide();
		$('#product_list3').hide();
		$('#variant-list3').hide();
	}
	if(val == '2')
	{
		$('#discount3').hide();
		$('#categorylist3').show();
		$('#subcategorylist3').show();
		$('#product_list3').show();
		$('#variant-list3').show();
	}
}

function loadSubcategory(x)
{
	$.ajax({
		url: 'ajax-general.php',
		data: 'type=2&main_cat='+x,
		type: 'POST',
		success: function(d){
			if(d == "1")
			{
				$("#subcategory_id").prop('disable', 'true');
			}
			else
			{
				$("#subcategory_id").prop('disable', 'false');
				$("#subcategory_id").html(d);
			}
		},
		error: function(){
			$("#subcategory_id").html('Something went wrong in selecting category');
		}	
	});
}

function getProducts(x)
{
	$.ajax({
		type: "POST",
		url: "ajax-general.php",
		data: 'type=3&sub_cat='+x,
		success: function(data){
			$("#product-list").html(data);
			$("#variant-list").html('<option value="">Select Variant ...</option>');
		}
	});
}

function getVariants(x)
{
	$.ajax({
		type: "POST",
		url: "ajax-general.php",
		data: 'type=4&product_id='+x,
		success: function(data){
			$("#variant-list").html(data);
		}
	});
}

function getStatesList(x)
{
	$.ajax({
		type: "POST",
		url: "ajax-general.php",
		data: 'type=6&country_id='+x,
		success: function(data){
			$("#states-list").html(data);
			$("#cities-list").html('<option value="">Select City ...</option>');
		}
	});
}

function getCitiesList(x)
{
	$.ajax({
		type: "POST",
		url: "ajax-general.php",
		data: 'type=7&state_id='+x,
		success: function(data){
			$("#cities-list").html(data);
		}
	});
}