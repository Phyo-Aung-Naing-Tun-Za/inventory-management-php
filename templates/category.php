<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
        <label id="main_cat" class="btn btn-outline-primary" for="btnradio1"><i class="fa fa-plus me-1"></i>Main Category</label>

        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
        <label id="sub_cat" class="btn btn-outline-primary" for="btnradio2"><i class="fa fa-plus me-1"></i>Sub Category</label>
    </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        <!-- Create Main Category-->
        <form method="POST" action="/product/category/create" id="main_cat_form">
          <div class="mb-3">
              <label for="name" class="form-label text-secondary fw-semibold">Main Category Name</label>
              <input type="hidden" name="parent_cat" value="0">
              <input type="text" class="form-control" id="name" name="category_name" >
              <small class=" text-danger" id = "e_name"></small>
          </div>
          <button type="submit" class="btn btn-primary">Create <i class="fa fa-plus-circle ms-2"></i></button>
        </form>
        <!-- Create Sub Category-->
        <form method="POST" action="/product/category/create"  id="sub_cat_form" class="d-none">
          <div class="mb-3">
              <label for="name" class="form-label text-secondary fw-semibold">Sub Category Name</label>
              <input type="text" class="form-control" id="name" name="category_name" >
              <small class=" text-danger" id = "e_name"></small>
          </div>
          <div class="mb-4">
              <label for="main_cat_id" class="form-label text-secondary fw-semibold">Select Main Category</label>
              <select id="cat_select" name="parent_cat" id="main_cat_id" class="form-select" >
                <option value="0">Root</option>
              </select>
            
          </div>
          <button type="submit" class="btn btn-primary">Create <i class="fa fa-plus-circle ms-2"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>