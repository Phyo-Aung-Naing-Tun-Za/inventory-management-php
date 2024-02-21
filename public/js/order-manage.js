$(document).ready(function () {
    let filterInvoices = [];
    $("#edit-container").hide();
    $("#dropdown").hide();
    let count = 0;
    let page = 1;
    let rowNumber = 1;


    //for searching invoice
    $("#name").on('keyup',function(){
      searchGenerator('customer_name','name');
    });
    $("#invoice").on('keyup',function(){
      searchGenerator('invoice_no','invoice');
    });
    $("#payment").on('change',function(){
      searchGenerator('payment_type','payment');
    });
    $("#search-date").on('change',function(){
      searchGenerator('order_date','search-date');
    });
    $("#reset-search-form").on('click',function(){
      rowNumber = (page * 10) - 9;
      $("#name").val('');
      $("#invoice").val('');
      $("#payment").val('');
      $("#search-date").val('');
      getOrders(page);
      createPagination(page);
    })
    $("#open-search-form").on('click',function(){
      $("#close-btn-container").hide();
      $("#search-container").addClass("d-flex justify-content-end");
      $("#search-container").show();
    })

    $("#search-container").removeClass("d-flex justify-content-end");
    $("#search-container").hide();
    $("#close-search-form").on("click",function(e){
      $("#close-btn-container").show();
      $("#search-container").removeClass("d-flex justify-content-end");
      $("#search-container").hide();
       
    })

    function searchGenerator($column_name,$input_name){
      rowNumber = (page * 10) - 9;
      if($(`#${$input_name}`).val() == ""){
        getOrders(page);
        createPagination(page);
      }else{
        $.ajax({
          url: `/order/invoices/search?by=${$column_name}`,
          method: "POST",
          data: {value : $(`#${$input_name}`).val()},
          success: function(data){
            let filterInvoices = JSON.parse(data);
            generatingTableRows(filterInvoices);
            $('.pagination').html(null);
          }
        })
      }   
    }

  
    function getOrders(page) {
      $.ajax({
        url: `/order/invoices`,
        method: "POST",
        data: {page: page},
        success:  function (data) {
         filterInvoices = JSON.parse(data);
          generatingTableRows(filterInvoices);
        },
      }); 
    }
    function generatingTableRows(invoices){
      $("#table-body").html(null);
      for (let i = 0; i < invoices.length; i++) {
        let tr = `
                      <tr>
                          <td style="font-size:14px">${rowNumber}</td>
                          <td style="font-size:14px">${invoices[i].order_date}</td>
                          <td style="font-size:14px">${invoices[i].invoice_no}</td>
                          <td style="font-size:14px">${invoices[i].customer_name}</td>
                          <td style="font-size:14px">${invoices[i].sub_total}</td>
                          <td style="font-size:14px">${invoices[i].tax}</td>
                          <td style="font-size:14px">${invoices[i].discount}</td>
                          <td style="font-size:14px">${invoices[i].due}</td>
                          <td style="font-size:14px">${invoices[i].paid}</td>
                          <td style="font-size:14px">${invoices[i].net_total}</td>
                          <td style="font-size:14px">${invoices[i].changes}</td>
                          <td style="font-size:14px">${invoices[i].payment_type}</td>
                          <td style="font-size:14px">
                              <button id='${
                                  invoices[i].invoice_no
                              }' class="btn btn-danger btn-sm delete-btn"><i id='${
                                invoices[i].invoice_no
                            }' class="fa-solid fa-trash"></i> </button>
                              <button id='${invoices[i].invoice_no}' class="btn btn-primary btn-sm edit-cat"><i id='${invoices[i].invoice_no}' class="fa-regular fa-eye"></i></button>
                          </td>
                      </tr>
                  `;            
        $("#table-body").append(tr);
        rowNumber++;   
        count = 1;   
      };
    }
    function createPagination(page){
      $.ajax({
          url:"/get_length?table=invoice",
          method:"POST",
          success:  function(data){
              $('.pagination').html(null);
              if(data){
                  generatingPaginations(page,data);
              }
          }
      })
    }
    function generatingPaginations(page,dataLength){
      let pages = Math.ceil(dataLength/10); 
      if(page > 1){
        $('.pagination').append(`
    <li class="page-item">
    <button id="prev-btn" class="page-link"  aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
    </button>
    </li>                
    `);
    } 
    for(let i = page - 4; i < page; i++){
        if(i > 0){
            $('.pagination').append(`
            <li class="page-item "><button id=${i} class="pagi-btn page-link" >${i}</button></li>
        `);
        }
    }
    $('.pagination').append(`
        <li class="page-item"><button id=${page} class="pagi-btn page-link active" >${page}</button></li>
    `);
    for (let j = page + 1; j <= pages ; j++) {
      $('.pagination').append(`
      <li class="page-item"><button id=${j} class="pagi-btn page-link " >${j}</button></li>
  `);
    }
    if(page < pages){
      $('.pagination').append(`
      <li class="page-item">
      <button id="next-btn"  class="page-link"  aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
      </button>
      </li>                
      `);
    }               
    };
  
  
    if(!count){
      getOrders(page);
      createPagination(page);
    }
  
    $("#edit-ctg-form").on('submit',function(e){
      e.preventDefault();
      if($("#name").val() == ""){
        $("#e_c_name").html("<span>Please enter a category name.</span>");
      }else{
        $.ajax({
          url: "/product/category/update",
          method: "POST",
          data : $("#edit-ctg-form").serialize(),
          success: function(data){
            if(data == "Successfully updated"){
              Swal.fire({
                title: "Done!",
                text: "Successfully updated!",
                icon: "success"
              });
              $("#e_c_name").empty();
              getOrders(page);
              createPagination(page);
              $("#edit-container").hide();
              $("#dropdown").hide();
            }else{
              Swal.fire({
                title: "Failed!",
                text: "Failed to update!",
                icon: "error"
              });
            }
    
          }
        })
      }
     
    });
    $(document).on('click','#d-active-btn', function(e){
      Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, suspend it!"
      }).then((result) => {
        if (result.isConfirmed) {
         let id = e.target.getAttribute("eid");
         $.ajax({
          url: "/product/category/update",
          method: "POST",
          data: {status: 0, id : id},
          success: function(data){
            console.log(data);
            if(data == "success"){
              getOrders(page);
              createPagination(page);
              Swal.fire({
                title: "Done!",
                text: "Suspended Successfully.",
                icon: "success"
              });
            }else{
              Swal.fire({
                title: "Failed!",
                icon: "error",
              });
            }
          }
         })    
        }
      });
    });
  
    $(document).on('click','#active-btn', function(e){
      Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, make active"
      }).then((result) => {
        if (result.isConfirmed) {
          let id = e.target.getAttribute("eid");
         $.ajax({
          url: "/product/category/update",
          method: "POST",
          data: {status: 1, id : id},
          success: function(data){
            if(data == "success"){
              getOrders(page);
              createPagination(page);
              Swal.fire({
                title: "Done!",
                text: "Active Successfully.",
                icon: "success"
              });
            }else{
              Swal.fire({
                title: "Failed!",
                icon: "error",
              });
            }
          }
         })   
        }
      });
    });
  
  
  $(document).on('click', `.delete-btn`, function(e) {
  
      let invoice_no = e.target.id;
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '/order/invoices/delete',
            method: "POST",
            data: {invoice_no: invoice_no},
            success: function(data){
              if(data == "success"){
                Swal.fire({
                  title: "Deleted!",
                  text: "Your file has been deleted.",
                  icon: "success"
                });
                getOrders(page);
                createPagination(page);
                rowNumber = (page * 10) - 9;
              }else{
                Swal.fire({
                  title: "Failed!",
                  text: "Failed to deleted.",
                  icon: "error"
                });
              }
            }
          });
          
        }
      });
        
    });
  $(document).on('click', `.pagi-btn`, function(e) {
      page =  parseInt(e.target.id)
  
      rowNumber = (page * 10) - 9;
      getOrders(page);
      createPagination(page);
      count = 1;
    });
    $(document).on('click', '#next-btn', function(){
      page += 1;
      if(page > 1){
        rowNumber = (page * 10) - 9;
      }
      getOrders(page);
      createPagination(page);
    })
    $(document).on('click', '#prev-btn', function(){
      page -= 1;
      if(rowNumber > 1){
        rowNumber = (page * 10) - 9;
      } 
      getOrders(page);
      createPagination(page);
    })
    $(document).on('click', '.edit-cat', function(e){
      let invoice_no = e.target.id;
      $(".print-btn").attr("id", invoice_no);

      $.ajax({
        url: "/order/invoices/details",
        method: "POST",
        data : {invoice_no : invoice_no},
        success: function(data){
          let orders = JSON.parse(data);
          $("#t_body").empty();
          $("#date").text(orders[0].order_date);
          $("#invoice_no").text(orders[0].invoice_no);
          $("#customer_name").text(orders[0].customer_name);
          $("#sub_total").text(orders[0].sub_total + " kyats");

          $("#tax").text(orders[0].tax + " kyats");
          $("#discount").text(orders[0].discount + " kyats");
          $("#due").text(orders[0].due + " kyats");
          $("#paid").text(orders[0].paid + " kyats");
          $("#net_total").text(orders[0].net_total + " kyats");
          $("#change").text(orders[0].changes + " kyats");
        orders.map((order,i) => {
          $("#t_body").append(`
          <tr>
            <td class="text-secondary"  style='font-size:15px;'>${i + 1}</td>
            <td class="text-secondary" style='font-size:15px;'>${order.product_name}</td>
            <td class="text-secondary" style='font-size:15px;'>${order.price}</td>
            <td class="text-secondary" style='font-size:15px;'>${order.qty}</td>
            <td class="text-secondary" style='font-size:15px;'>${order.price * order.qty}</td>
          </tr>
          `);
        })
        }
      })
      $("#edit-container").show();
      $("#dropdown").show();
  
    })
   

    $(".print-btn").on("click",function(e){
      e.preventDefault();
      let invoice_no = e.target.id;
      $.ajax({
          url: "/order/print",
          method: "GET",
          data : {invoice_num : invoice_no},
          success: function(data){
              window.location.href = `/order/print?invoice_num=${invoice_no}`;
              $("#submit-btn").show();
              $("#print-form").hide();
          }
      })
  })

  $("#close-btn").on("click",function(e){
    $("#edit-container").hide();
      $("#dropdown").hide();
  })
  
  });
  
  
  