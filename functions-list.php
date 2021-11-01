<?php

function getAdminRole($val){
	if($val == 1) {
		return 'Super Admin';	// 1 = Super Admin - WE
	} else if($val == 2) {
		return 'Admin';			// 2 = Admin - Client
	} else if($val == 3) {
		return 'Store Admin'; 	// 3 = Store Admin - Managed by Clients
	} else if($val == 4) {
		return 'Vendor';		// 4 = Vendor
	} else if($val == 5) {
		return 'Delivery User/Admin'; 	// 5 = Delivery User/Admin
	} else {
		return "-";
	}
}

function getCustGender($val){
	if($val == 1) {
		return 'Male';
	} else if($val == 2) {
		return 'Female';
	} else if($val == 3) {
		return 'Other';
	} else {
		return "-";
	}
}

function setCustGender(){
	return [ 
		0 => '-', 
		1 => 'Male', 
		2 => 'Female', 
		3 => 'Other'
	];
}

function getActInactStatus( $val ) {
	if ( $val == 1 ) {
		return "Active";
	} else if ( $val == 0 ) {
		return "Deactive";
	}
}

function getSubscriptionStatus($val)
{
	if($val == 1) {
		return "Active";
	} else if($val == 2) {
		return "Blocked";
	} else {
		return "Inactive";
	}
}

function getUserStatus($value)
{
	if($value == 1) {
		return "Active";
	} else if($value == 2) {
		return "Blocked";
	} else {
		return "Inactive";
	}
}

// Payment Mode : 0 - Online Payment, 1 = Cash on delivery
function listPaymentMode()
{
	return [
		0 => "Online Payment",
		1 => "Cash on delivery",
	];
}

function getPaymentMode($value)
{
	if($value == 1) {
		return "Cash on delivery";
	} else {
		return "Online Payment";
	}
}

//Payment Sub : Cash on delivery : 0 - By Cash, 1 = By Paytm, 2 = By Card swipe
function listPaymentSub()
{
	return [
		0 => "By Cash",
		1 => "By Paytm",
		2 => "By Card swipe",
	];
}

function getPaymentSub($value)
{
	if($value == 1) {
		return "By Paytm";
	} else if($value == 2) {
		return "By Card swipe";
	} else {
		return "By Cash";
	}
}

// Payment Status : 0 = Pending, 1 = Paid, 2 = Cancelled
function listPaymentStatus()
{
	return [
		0 => "Online Payment",
		1 => "Cash on delivery",
	];
}

function getPaymentStatus($value)
{
	if($value == 1) {
		return "Cash on delivery";
	} else {
		return "Online Payment";
	}
}

//Order Status : Cash on delivery : 0 - Pending, 1 = Completed, 2 = Cancelled
function getOrderStatus($value)
{
	if($value == 1) {
		return "Completed";
	} else if($value == 2) {
		return "Cancelled";
	} else {
		return "Pending";
	}
}

function listOrderStatus()
{
	return [
		0 => "Pending",
		1 => "Completed",
		2 => "Cancelled",
	];
}

//Order Offer ON which type (i.e offer on product , offer on variant ) - MAIN TYPE
function getProductOfferON($value)
{
	if($value == 1) {
		return "Varinat";
	} else {
		return "-";
	}
}

//Order Offer Type - SUB TYPE
function getProductOfferType($value)
{
	if($value == 1) {
		return "Percentage";
	} else if($value == 2) {
		return "Free Product";
	} else {
		return "-";
	}
}

// Registered Device Type: 1. iOs, 2. Android
function getDeviceType( $value ) {
	if ( $value == 1 ) {
		return "iOs";
	} else if ( $value == 2 ) {
		return "Android";
	}
}

function getClientSubscriptionState($val){
	if($val == 1) {
		return 'Active';	// 1 = Active
	} else if($val == 2) {
		return 'Inactive';			// 2 = Inactive
	} else if($val == 3) {
		return 'Cancelled from our side'; 	// 3 = Cancelled from our side
	} else if($val == 4) {
		return 'Cancelled from client side'; 	// 4 = Cancelled from client side
	} else {
		return "-";
	}
}

function setClientSubscriptionState(){
	return [ 
		1 => 'Active', 
		2 => 'Inactive', 
		3 => 'Cancelled from our side', 
		4 => 'Cancelled from client side'
	];
}

function getDeliveryStatus($value){
    if($value == 0){
		return "Pending";
    }
    else if($value == 1){
		return "Delivered";
    }
    else if($value == 2){
		return "Cancelled";
    }
}

function listDashboardType(){
	return [ 
		1 => '1/2 Products', 
		2 => 'Featured Products with Banner', 
		3 => '4x4 Trending Offers', 
		4 => 'Promotional Offers'
	];
}

function getDashboardType($value)
{
    if($value == 1) {
		return "1/2 Products";
    }
    else if($value == 2) {
		return "Featured Products with Banner";
    }
    else if($value == 3) {
		return "4x4 Trending Offers";
    }
    else if($value == 4) {
		return "Promotional Offers";
    }
}