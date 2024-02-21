$(document).ready(function () {

    $("#edit-container").hide();
    $("#dropdown").hide();
    let count = 0;
    let page = 1;
    let rowNumber = 1;
    let filterBrands = []

     //for searching invoice
    
     $("#brand-name").on('keyup',function(){
      searchGenerator('b_name','brand-name');
    });
    $("#status").on('change',function(){
      searchGenerator('status','status');
    });
    
    $("#reset-search-form").on('click',function(){
      rowNumber = (page * 10) - 9;
      $("#brand-name").val('');

      $("#status").val('');
      getBrands(page);
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

    function searchGenerator(column_name,input_name){

      rowNumber = (page * 10) - 9;
      if($(`#${input_name}`).val() == ""){
        getBrands(page);
        createPagination(page);
      }else{
        $.ajax({
          url: `/product/brand/search?by=${column_name}`,
          method: "POST",
          data: {value : $(`#${input_name}`).val()},
          success: function(data){
            
            filterBrands = JSON.parse(data);
            generatingTableRows(filterBrands);
            $('.pagination').html(null);
          }
        })
      }   
    }


    function getBrands(page) {
      $.ajax({
        url: `/product/brand`,
        method: "POST",
        data: {page: page},
        success:  function (data) {
         let filterBrands = JSON.parse(data);
         generatingTableRows(filterBrands)
          
        },
      });
    }
    function createPagination(page){
      $.ajax({
          url:"/get_length?table=brands",
          method:"POST",
          success:  function(data){
              $('.pagination').html(null);
              if(data){
                 generatingPagination(page,data);         
              }
          }
      })
    }
    function generatingTableRows(brands)
    {
      $("#table-body").html(null);
      for (let i = 0; i < brands.length; i++) {
        let tr = `
                      <tr>
                          <td style="font-size:14px">${rowNumber}</td>
                          <td style="font-size:14px">${brands[i].b_name}</td>
                          <td style="font-size:14px">${
                              brands[i].status == 1
                              ? `<button eid=${brands[i].id}  id='d-active-btn' class='btn btn-success btn-sm'>Active</button>`
                              : `<button eid=${brands[i].id} id="active-btn" class="btn btn-warning btn-sm">Suspend</button>`
                          }</td>
                          <td style="font-size:14px">
                              <button id='${
                                  brands[i].id
                              }' class="btn btn-danger btn-sm delete-btn"><i id='${
                                brands[i].id
                            }' class="fa-solid fa-trash"></i> </button>
                              <button  brand='${brands[i].b_name}' id='${brands[i].id}' class="btn btn-primary btn-sm edit-brand-btn"><i brand='${brands[i].b_name}' id='${brands[i].id}' class="fa-regular fa-pen-to-square"></i> </button>
                          </td>
                      </tr>
                  `;            
        $("#table-body").append(tr);
        rowNumber++;
      };

    }

    function generatingPagination(page, dataLength){
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
    }


    if(!count){
      getBrands(page);
      createPagination(page);
    }
  
    $("#edit-brand-form").on('submit',function(e){
      e.preventDefault();
      if($("#name").val() == ""){
        $("#e_b_name").html("<span>Please enter a brand name.</span>");
      }else{
        $.ajax({
          url: "/product/brand/update",
          method: "POST",
          data : $("#edit-brand-form").serialize(),
          success: function(data){
            if(data == "Successfully updated"){
              Swal.fire({
                title: "Done!",
                text: "Successfully updated!",
                icon: "success"
              });
              $("#e_c_name").empty();
              getBrands(page);
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
    
    $(document).on('click', `.pagi-btn`, function(e) {
      page =  parseInt(e.target.id)
  
      rowNumber = (page * 10) - 9;
      getBrands(page);
      createPagination(page);
      count = 1;
    });
    $(document).on('click', '#next-btn', function(){
      page += 1;
      if(page > 1){
        rowNumber = (page * 10) - 9;
      }
      getBrands(page);
      createPagination(page);
    })
    $(document).on('click', '#prev-btn', function(){
      page -= 1;
      if(rowNumber > 1){
        rowNumber = (page * 10) - 9;
      } 
      getBrands(page);
      createPagination(page);
    })


    $(document).on('click', '.edit-brand-btn', function(e){  
    let brand = e.target.getAttribute("brand");
    let id = e.target.id;
        $("#brand-id").val(id)
        $("#name").val(brand);
        $("#edit-container").show();
        $("#dropdown").show();
    })
    $(document).on('click','.edit-close',function(e){
      $("#edit-container").hide();
      $("#dropdown").hide();
    })
    $(document).on('click', `.delete-btn`, function(e) {
        let id = e.target.id;
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
              url: '/product/brand/delete',
              method: "POST",
              data: {id: id},
              success: function(data){
                if(data == "Delete Successfully"){
                  getBrands(page);
                  createPagination(page);
                  rowNumber = (page * 10) - 9;
                }else{
                    console.log(data);
                }
              }
            });
            Swal.fire({
              title: "Deleted!",
              text: "Your file has been deleted.",
              icon: "success"
            });
          }
        });
          
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
            url: "/product/brand/update",
            method: "POST",
            data: {status: 0, id : id},
            success: function(data){
              console.log(data);
              if(data == "success"){
                getBrands(page);
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
            url: "/product/brand/update",
            method: "POST",
            data: {status: 1, id : id},
            success: function(data){
              if(data == "success"){
                getBrands(page);
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
  });
  
  
  