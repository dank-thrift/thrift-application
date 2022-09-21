// var product_total_amt=document.getElementById('product_total_amt');
// var product_total_amt_side=document.getElementById('product_total_amt_side');
// var shipping_charge=$('#ship_standred').val();
// var total_cart_amt=document.getElementById('total_cart_amt');

/* ----------------------------- decrease Number start---------------------------- */

// const decreaseNumber=(incdec,itemprice,product_price_indi,ship,ship1,textbox,itemquanity)=>{
//     var itemval=document.getElementById(incdec);
//     var itemprice=document.getElementById(itemprice);
//     var product_price_indi=document.getElementById(product_price_indi);
//     var textbox_each=document.getElementById(textbox);
//     var itemquanity=document.getElementById(itemquanity);
//     if(itemval.value <= 1){
//         itemval.value=1;
//     }
//     else{
//         itemval.style.background='#fff';
//         itemval.style.color='#000';
//         itemval.value=parseInt(itemval.value)-1;
//         itemprice.innerHTML=parseInt(itemprice.innerHTML)-parseInt(product_price_indi.innerHTML);
//         product_total_amt.innerHTML=parseInt(product_total_amt.innerHTML)-parseInt(product_price_indi.innerHTML);
//         (product_total_amt_side.innerHTML)=parseInt(product_total_amt.innerHTML);
//         shipping(ship,ship1);
//         textboxcheck(textbox_each.id,itemquanity);
//     }
// }
/* ----------------------------- decrease Number end---------------------------- */

/* ----------------------------- increase number start---------------------------- */
// const increaseNumber=(incdec,itemprice,product_price_indi,ship,ship1,textbox,itemquanity)=>{
//     var itemval=document.getElementById(incdec);
//     // var itemprice=document.getElementById(itemprice);
//     // var textbox_each=document.getElementById(textbox);
//     // var product_price_indi=document.getElementById(product_price_indi);
//     // var itemquanity=document.getElementById(itemquanity);
//     // console.log(itemval.value);
//     if(itemval.value >= 50){
//         itemval.value=50;
//         alert('max 50 allowed');
//         itemval.style.background='red';
//         itemval.style.color='#fff';
//     }
//     else{
//         itemval.value=parseInt(itemval.value)+1;              
//         // shipping(ship,ship1);
//         // console.log(textbox_each.id);
//         // textboxcheck(textbox_each.id,itemquanity);
//     }
// }
/* ----------------------------- increase number end---------------------------- */
/* -------------------------- shipping charge start ------------------------- */


/* -------------------------- shipping charge  end------------------------- */

/* ------------------------ remove product from cart start------------------------ */
// const removeItems=(items,itemtotalvalue,ship,ship1,items2)=>{
// var itemsId=document.getElementById(items);
// var itemsId2=document.getElementById(items2);
// var itemtotalprice=document.getElementById(itemtotalvalue);
// product_total_amt.innerHTML=parseInt(product_total_amt.innerHTML)-parseInt(itemtotalprice.innerHTML);
// product_total_amt_side.innerHTML=parseInt(product_total_amt.innerHTML);
// shipping(ship,ship1);
// $(itemsId).remove();
// $(itemsId2).remove();
// checkempty();
// }
// const checkempty=()=>{
//     if(parseInt(product_total_amt.innerHTML)==0){
//         $('.cart-main-area').css('display','none');
//         $('.empty-cart-area').css('display','block');
//     }
// }
/* ------------------------ remove product from cart end------------------------ */

// const textboxcheck=(textnumber,itemquanity)=>{
//     var textbox_number=document.getElementById(textnumber);
//     itemquanity.innerHTML=textbox_number.value;
//     // console.log(textbox_number.value);
// }

/* --------------------------- discount code start ----------------- --------- */
// const discount_code=()=>{
// let totalamtcurr=parseInt(total_cart_amt.innerHTML);
// let error_trw=document.getElementById('error_trw');
// if(discountCode.value === 'chandan'){
//     let newtotalamt=totalamtcurr-totalamtcurr*15/100;
//     total_cart_amt.innerHTML=newtotalamt;
//     error_trw.innerHTML="Hurray!!! you get 15% off";
// }else{
// error_trw.innerHTML="Try again";
// }
// }
/* --------------------------- discount code end ----------------- --------- */

/* ---------------------- jquery for update the product --------------------- */


// $(document).ready(function () {   
    // $(".itemQty").on("change", function () {
    //   var el = $(this).closest("tr");
    //   var pid = el.find("#pid").val();
    //   var pprice = el.find("#pprice").text();
    //   var pricenew = parseFloat(document.getElementById("price").innerHTML);
    //   qty = Math.round((el.find(".itemQty").val()));
    //   console.log(qty);
    //   if(qty<1){
    //     qty=1;
    //   }
    //   var price2 = qty * pricenew;
    //   //    include tax
    //   var total = price2 + 0;
    //   var pp = el.find(".price").val(price2);
    //   var total = el.find(".total").val(total);
    //   var total1 = 0;
    //   $(".total").each(function () {
    //     total1 += parseFloat($(this).val());
    //   });
    //   $("#grandtotal").val(total1);
    //   var gtot = $("#grandtotal").val();
    //   // console.log(pid);
    //   console.log(pricenew);
    //   console.log(total.val());
    //   $.ajax({
    //     url: "php/total.php",
    //     method: "POST",
    //     data: {
    //       pid: pid,
    //       price: pricenew,
    //       // pp: pp.val(),
    //       pqty: qty,
    //       total: total.val(),
    //       // gtot: gtot,
    //     },
    //     success: function (result) {
    //       console.log(result);
    //       window.location.reload();
    //     },
    //   });
    // });
  // $('.qtybutton_plus').click(function () {    
  //   var el = $(this).closest("tr");
  //   var pid = el.find("#pid").val();
  //   var pprice = el.find("#pprice").text();
  //   var pricenew = parseFloat(document.getElementById("price").innerHTML);
  //   qty = Math.round((el.find(".itemQty").val()));
  //   if(qty<1){
  //     qty=1;
  //   }
  //   qty=qty+1;
  //   var price2 = qty * pricenew;
  //   //    include tax
  //   var total = price2 + 0;
  //   var pp = el.find(".price").val(price2);
  //   var total = el.find(".total").val(total);
  //   var total1 = 0;
  //   $(".total").each(function () {
  //     total1 += parseFloat($(this).val());
  //   });
  //   $("#grandtotal").val(total1);
  //   var gtot = $("#grandtotal").val();
  //   // console.log(pid);
  //   console.log(pricenew);
  //   console.log(total.val());
  //   $.ajax({
  //     url: "php/total.php",
  //     method: "POST",
  //     data: {
  //       pid: pid,
  //       price: pricenew,
  //       // pp: pp.val(),
  //       pqty: qty,
  //       total: total.val(),
  //       // gtot: gtot,
  //     },
  //     success: function (result) {
  //       console.log(result);
  //       window.location.reload();
  //     },
  //   });
  // });
  // $('.qtybutton_minus').click(function () {    
  //   var el = $(this).closest("tr");
  //   var pid = el.find("#pid").val();
  //   var pprice = el.find("#pprice").text();
  //   var pricenew = parseFloat(document.getElementById("price").innerHTML);
  //   qty = Math.round((el.find(".itemQty").val()));
  //   qty=qty-1;
  //   if(qty<1){
  //     qty=1;
  //   }
  //   var price2 = qty * pricenew;
  //   //    include tax
  //   var total = price2 + 0;
  //   var pp = el.find(".price").val(price2);
  //   var total = el.find(".total").val(total);
  //   // console.log(total.val());
  //   var total1 = 0;
  //   $(".total").each(function () {
  //     total1 += parseFloat($(this).val());
  //   });
  //   console.log(total1);
  //   $("#grandtotal").val(total1);
  //   var gtot = $("#grandtotal").val();
  //   console.log(gtot);
  //   // console.log(pricenew);
  //   // console.log(total.val());
  //   $.ajax({
  //     url: "php/total.php",
  //     method: "POST",
  //     data: {
  //       pid: pid,
  //       price: pricenew,
  //       // pp: pp.val(),
  //       pqty: qty,
  //       total: total.val(),
  //       // gtot: gtot,
  //     },
  //     success: function (result) {
  //       console.log(result);
  //       window.location.reload();
  //     },
  //   });
  // });
  
/* -------------------------------- wishlist -------------------------------- */
