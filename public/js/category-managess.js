$(document).ready(function () {

  $("#edit-container").hide();
    $("#dropdown").hide();
  let filterCategories = [];
  let count = 0;
  let page = 1;
  let rowNumber = 1;


    //for searching invoice
    
    $("#sub-category").on('keyup',function(){
      searchGenerator('category_name','sub-category');
    });
    $("#status-search").on('change',function(){
      searchGenerator('status','status-search');
    });
    
    $("#reset-search-form").on('click',function(){
      rowNumber = (page * 10) - 9;
      $("#sub-category").val('');
      $("#status-search").val('');
      getCtgs(page);
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
      console.log($(`#${input_name}`).val());
      if($(`#${input_name}`).val() == ""){
        getCtgs(page);
        createPagination(page);
      }else{
        $.ajax({
          url: `/product/category/search?by=${column_name}`,
          method: "POST",
          data: {value : $(`#${input_name}`).val()},
          success: function(data){
            
            filterCategories = JSON.parse(data);
            console.log(filterCategories);
            generatingTableRows(filterCategories);
            $('.pagination').html(null);
          }
        })
      }   
    }




  function getCtgs(page) {
    $.ajax({
      url: `/product/category`,
      method: "POST",
      data: {page: page},
      success:  function (data) {
       let filterCategories = JSON.parse(data); 
       generatingTableRows(filterCategories);      
      },
    });
  }
  function createPagination(page){
    $.ajax({
        url:"/get_length?table=categories",
        method:"POST",
        success:  function(data){
            $('.pagination').html(null);
            if(data){
               generatingPaginations(page,data);
            }
        }
    })
  }

  function generatingTableRows(categories){
    $("#table-body").html(null);
    for (let i = 0; i < categories.length; i++) {
      let tr = `
                    <tr>
                        <td style="font-size:14px">${rowNumber}</td>
                        <td style="font-size:14px">${categories[i].category}</td>
                        <td style="font-size:14px">${categories[i].parent ? categories[i].parent : 'Root'}</td>
                        <td style="font-size:14px">${
                            categories[i].status == 1
                            ? `<button eid=${categories[i].id}  id='d-active-btn' class='btn btn-success btn-sm'>Active</button>`
                            : `<button eid=${categories[i].id} id="active-btn" class="btn btn-warning btn-sm">Suspend</button>`
                        }</td>
                        <td style="font-size:14px">
                            <button id='${
                                categories[i].id
                            }' class="btn btn-danger btn-sm delete-btn"><i class="fa-solid fa-trash"></i> </button>
                            <button eid='${categories[i].id}' cate='${categories[i].category}' id='${
                                categories[i].parent ? categories[i].parent : "Root"
                            }' class="btn btn-primary btn-sm edit-cat"><i class="fa-regular fa-pen-to-square"></i> </button>
                        </td>
                    </tr>
                `;            
      $("#table-body").append(tr);
      rowNumber++;
    };

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
  }

  if(!count){
    getCtgs(page);
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
            getCtgs(page);
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
            getCtgs(page);
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
            getCtgs(page);
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
          url: '/product/category/delete',
          method: "POST",
          data: {id: id},
          success: function(data){
            if(data == "Delete Successfully"){
              getCtgs(page);
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
$(document).on('click', `.pagi-btn`, function(e) {
    page =  parseInt(e.target.id)

    rowNumber = (page * 10) - 9;
    getCtgs(page);
    createPagination(page);
    count = 1;
  });
  $(document).on('click', '#next-btn', function(){
    page += 1;
    if(page > 1){
      rowNumber = (page * 10) - 9;
    }
    getCtgs(page);
    createPagination(page);
  })
  $(document).on('click', '#prev-btn', function(){
    page -= 1;
    if(rowNumber > 1){
      rowNumber = (page * 10) - 9;
    } 
    getCtgs(page);
    createPagination(page);
  })
  $(document).on('click', '.edit-cat', function(e){
    let parentId = e.target.id;
    $.ajax({
      url: "/product/main_category",
      metho: "POST",
      data : {parentId : parentId},
      success: function(data){
        let category = e.target.getAttribute("cate");
        let id = e.target.getAttribute("eid");
        $("#cat-id").val(id)
        $("#name").val(category);
        $("#main_cat").html(data);
      }
    })
    $("#edit-container").show();
    $("#dropdown").show();

  })
  $(document).on('click','.edit-close',function(e){
    $("#edit-container").hide();
    $("#dropdown").hide();
  })

});


