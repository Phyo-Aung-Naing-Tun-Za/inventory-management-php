<div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Brand</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Create Brand-->
        <form method="POST" action="/product/brand/create" id="brand-form">
          <div class="mb-3">
              <label for="name" class="form-label text-secondary fw-semibold">Brand Name</label>
              <input type="text" class="form-control" id="brand_name" name="b_name" >
              <small class=" text-danger" id = "e_brand"></small>
          </div>
          <button type="submit" class="btn btn-primary">Create <i class="fa fa-plus-circle ms-2"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>