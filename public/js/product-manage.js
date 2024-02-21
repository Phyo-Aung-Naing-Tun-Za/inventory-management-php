$(document).ready(function () {
  $("#edit-container").hide();
  $("#dropdown").hide();
  let count = 0;
  let page = 1;
  let rowNumber = 1;
  let filterProducts = [];

  function clearErrors(){
    $("#e_p_name").empty();
    $("#e_price").empty();
    $("#e_stock").empty();
    $("#e_category").empty();
    $("#e_brand").empty();

}
$("#name").on('keyup',function(){
  searchGenerator('product_name','name');
});
$("#category").on('keyup',function(){
  searchGenerator('c.category_name','category');
});
$("#brand-search").on('keyup',function(){
  searchGenerator('b.b_name','brand-search');
});
$("#status-search").on('change',function(){
  searchGenerator('p.status','status-search');
});

$("#reset-search-form").on('click',function(){
  $("#name").val('');
  $("#category").val('');
  $("#brand-search").val('');
  $("#status-search").val('');

  rowNumber = page * 5 - 4 ;
  getProduts(page);
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
  rowNumber = page * 5 - 4;
  if($(`#${$input_name}`).val() == ""){
    rowNumber = 1;
    getProduts(page);
    createPagination(page);
  }else{
    $.ajax({
      url: `/product/search?by=${$column_name}`,
      method: "POST",
      data: {value : $(`#${$input_name}`).val()},
      success: function(data){
        let filterProducts = JSON.parse(data);
        generatingTableRows(filterProducts);
        $('.pagination').html(null);
      }
    })
  }   
}

  function getProduts(page) {
    $.ajax({
      url: `/product`,
      method: "POST",
      data: { page: page },
      success: function (data) {
         filterProducts = JSON.parse(data);
        generatingTableRows(filterProducts);
      },
    });
  }
  function createPagination(page) {
    $.ajax({
      url: "/get_length?table=products",
      method: "POST",
      success: function (data) {
        $(".pagination").html(null);
        if (data) {
          generatingPagination(page,data);
        }
      },
    });
  }

  function generatingTableRows(products){
    $("#table-body").html(null);
    for (let i = 0; i < products.length; i++) {
      let tr = `
                      <tr>
                          <td>${rowNumber}</td>
                          <td><img style="width:70px;height:70px;object-fit:contains;" src="../../public/images/${
                            products[i].img ? products[i].img : "sample.svg"
                          }"/></td>
                          <td style="font-size:14px;">${
                            products[i].product_name
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].category_name
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].b_name
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].price
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].stock
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].created_at
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].updated_at
                              ? products[i].updated_at
                              : "----"
                          }</td>
                          <td style="font-size:14px;">${
                            products[i].status == 1
                              ? `<button eid=${products[i].id}  id='d-active-btn' class='btn btn-success btn-sm'>Active</button>`
                              : `<button eid=${products[i].id} id="active-btn" class="btn btn-warning btn-sm">Suspend</button>`
                          }</td>
                          <td style="font-size:14px;">
                              <button id='${
                                products[i].id
                              }' class="btn btn-danger btn-sm delete-btn"><i id='${
        products[i].id
      }' class="fa fa-trash-can"></i></button>

                              <button  id='${
                                products[i].id
                              }' class="btn btn-primary btn-sm ms-1 edit-product"><i id='${
        products[i].id
      }' class="fa-regular fa-pen-to-square"></i></button>
                          </td>
                      </tr>
                  `;
      $("#table-body").append(tr);
      rowNumber++;
    }
  }

  function generatingPagination(page,dataLength){
    let pages = Math.ceil(dataLength / 5);
          if (page > 1) {
            $(".pagination").append(`
                  <li class="page-item">
                  <button id="prev-btn" class="page-link"  aria-label="Previous">
                      <span aria-hidden="true">&laquo;</span>
                  </button>
                  </li>                
                  `);
          }
          for (let i = page - 4; i < page; i++) {
            if (i > 0) {
              $(".pagination").append(`
                          <li class="page-item "><button id=${i} class="pagi-btn page-link" >${i}</button></li>
                      `);
            }
          }
          $(".pagination").append(`
                      <li class="page-item"><button id=${page} class="pagi-btn page-link active" >${page}</button></li>
                  `);
          for (let j = page + 1; j <= pages; j++) {
            $(".pagination").append(`
                    <li class="page-item"><button id=${j} class="pagi-btn page-link " >${j}</button></li>
                `);
          }
          if (page < pages) {
            $(".pagination").append(`
                    <li class="page-item">
                    <button id="next-btn"  class="page-link"  aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                    </li>                
                    `);
          }
  }

  function getBrands(id = null) {
    $("#brand").empty();
    $.ajax({
        url: `/product/brand?m=true&id=${id}`,
        mehtod: "POST",
        success:function(data){
            $("#brand").html(data);
        }
    })
  }
  function getCategories(id = null) {
    $("#cate").empty();
    $.ajax({
        url: `/product/sub_category?id=${id}`,
        mehtod: "POST",
        success:function(data){
            $("#cate").html(data);
        }
    })
  }
 
  if (!count) {
    getProduts(page);
    createPagination(page);
  }

  $("#product-form").on("submit", function (e) {
    e.preventDefault();
    clearErrors();
    if ($("#product_name").val() == "") {
      $("#e_p_name").html("<span>Please enter a product name.</span>");
    }else if($("#price").val() == ""){
      $("#e_price").html("<span>Please enter a price.</span>");

    }else if($("#stock").val() == ""){
      $("#e_stock").html("<span>Please enter a stock.</span>");

    }else if($("#cate").val() == ""){
      $("#e_category").html("<span>Please enter a category.</span>");

    }else if($("#brand").val() == ""){
      $("#e_brand").html("<span>Please enter a brand.</span>");

    }else {
      $.ajax({
        url: "/product/update",
        method: "POST",
        data: $("#product-form").serialize(),
        success: function (data) {
          if (data == "Successfully updated") {
            Swal.fire({
              title: "Done!",
              text: "Successfully updated!",
              icon: "success",
            });
            getProduts(page);
            createPagination(page);
            $("#edit-container").hide();
            $("#dropdown").hide();
          } else {
            Swal.fire({
              title: "Failed!",
              text: "Failed to update!",
              icon: "error",
            });
          }
        },
      });
    }
  });



  $(document).on("click", "#d-active-btn", function (e) {
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, suspend it!",
    }).then((result) => {
      if (result.isConfirmed) {
        let id = e.target.getAttribute("eid");
        $.ajax({
          url: "/product/update",
          method: "POST",
          data: { status: 0, id: id },
          success: function (data) {
            console.log(data);
            if (data == "success") {
              getProduts(page);
              createPagination(page);
              Swal.fire({
                title: "Done!",
                text: "Suspended Successfully.",
                icon: "success",
              });
            } else {
              Swal.fire({
                title: "Failed!",
                icon: "error",
              });
            }
          },
        });
      }
    });
  });

  $(document).on("click", "#active-btn", function (e) {
    Swal.fire({
      title: "Are you sure?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, make active",
    }).then((result) => {
      if (result.isConfirmed) {
        let id = e.target.getAttribute("eid");
        $.ajax({
          url: "/product/update",
          method: "POST",
          data: { status: 1, id: id },
          success: function (data) {
            if (data == "success") {
              getProduts(page);
              createPagination(page);
              Swal.fire({
                title: "Done!",
                text: "Active Successfully.",
                icon: "success",
              });
            } else {
              Swal.fire({
                title: "Failed!",
                icon: "error",
              });
            }
          },
        });
      }
    });
  });

  $(document).on("click", `.delete-btn`, function (e) {
    let id = e.target.id;
    console.log(id);
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/product/delete",
          method: "POST",
          data: { id: id },
          success: function (data) {
            if (data == "Delete Successfully") {
              getProduts(page);
              createPagination(page);
              rowNumber = page * 5 - 5;
            } else {
              console.log(data);
            }
          },
        });
        Swal.fire({
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
        });
      }
    });
  });
  $(document).on("click", `.pagi-btn`, function (e) {
    page = parseInt(e.target.id);

    rowNumber = page * 5 - 4;
    getProduts(page);
    createPagination(page);
    count = 1;
  });
  $(document).on("click", "#next-btn", function () {
    page += 1;
    if (page > 1) {
      rowNumber = page * 5 - 4;
    }
    getProduts(page);
    createPagination(page);
  });
  $(document).on("click", "#prev-btn", function () {
    page -= 1;
    if (rowNumber > 1) {
      rowNumber = page * 5 - 4;
    }
    getProduts(page);
    createPagination(page);
  });
  $(document).on("click", ".edit-product", function (e) {
    let id = e.target.id;
    getCategories();
    getBrands();
    $.ajax({
      url: "/product/edit",
      method: "POST",
      data: { id: id },
      success: function (data) {
        let product = JSON.parse(data);
        $("#id").val(id);
        $("#product_name").val(product["product_name"]);
        console.log();
        product['img']  ? $("#current-img").attr("src",`../public/images/${product["img"]}`) :  $("#current-img").attr("src",`../public/images/sample.svg`);
        
        $("#current-img").attr("eid",id)
        $("#price").val(product["price"]);
        $("#stock").val(product["stock"]);
        $("#stock").val(product["stock"]);
      },
    });
    $("#edit-container").show();
    $("#dropdown").show();
  });
  $("#img-upload-form").on("submit",function(e){
    e.preventDefault();
    let id = $("#current-img").attr("eid");
    if($("#img").val() == ""){
      $("#e_img").html("<span>Please enter an image.</span>");
    }else{
      $("#e_img").empty();
      let formData = new FormData($("#img-upload-form")[0]);
      let img = $("#current-img").attr("src").split("/");
      let currentImg = img.slice(3).join('/');
      $.ajax({
        url: `/product/update_img?id=${id}&img=${currentImg}`,
        method: "POST",
        data: formData ,
        contentType: false, 
        processData: false,
        success: function(data){
          if(data == "success"){
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: "Successfully updated",
              showConfirmButton: false,
              timer: 1500
            });
            getProduts(page);
            createPagination(page);
            $("#e_img").empty();
            $("#img").val(""); 
            $("#edit-container").hide();
            $("#dropdown").hide();
          }else if(data == "Fail to upload Image"){
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: "Fail to upload Image",
              showConfirmButton: false,
              timer: 1500
            });
          }else{
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: "Fail to creat product",
              showConfirmButton: false,
              timer: 1500
            });
          }
        }
      })


    }
  })

  $(document).on("click", ".edit-close", function (e) {
    $("#e_img").empty();
    $("#edit-container").hide();
    $("#dropdown").hide();
  });
});
