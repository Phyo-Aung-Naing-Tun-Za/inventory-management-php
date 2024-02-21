<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="p-alert-box"></div>
        <!-- Create product form -->
      <form id="product-form" method="POST" enctype="multipart/form-data" action="/product/create">
          <div class="mb-3">
              <label for="product_name" class="form-label text-secondary fw-semibold">Product Name</label>
              <input type="text" class="form-control" id="product_name" name="product_name" >
              <small class=" text-danger" id = "e_p_name"></small>
          </div>
          <div class="mb-3">
              <label for="price" class="form-label text-secondary fw-semibold">Price</label>
              <input type="number" class="form-control" id="price" name="price" >
              <small class=" text-danger" id = "e_price"></small>
          </div>
          <div class="mb-3">
              <label for="stock" class="form-label text-secondary fw-semibold">Stock</label>
              <input type="number" class="form-control" id="stock" name="stock" value="0" >
              <small class=" text-danger" id = "e_stock"></small>
          </div>
          <div class="mb-3">
              <label for="img" class="form-label text-secondary fw-semibold">Image</label>
              <input type="file" class="form-control" id="img" name="img" >
              <small class=" text-danger" id = "e_img"></small>             
          </div>
          <div class="mb-4 row">
              <div class="col">
                <label for="cate" class="form-label text-secondary fw-semibold">Select Category</label>
                <select  name="category" id="cate" class="form-select" >
                </select>
              <small class=" text-danger" id = "e_category"></small>
              </div>
              <div class="col">
                <label for="brand" class="form-label text-secondary fw-semibold">Select Brand</label>
                <select name="brand" id="brand" class="form-select" >
                </select>
               <small class=" text-danger" id = "e_brand"></small>
              </div>
          </div>
          <button type="submit" class="btn btn-primary">Create <i class="fa fa-plus-circle ms-2"></i></button>
    </form>
      </div>
    </div>
  </div>
</div>