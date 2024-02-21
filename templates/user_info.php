<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div id="p-alert-box"></div>
        <nav class="mb-3">
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home"
              type="button" role="tab" aria-controls="nav-home" aria-selected="true">Edit Info</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
              type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Change Password</button>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
            tabindex="0">
            <form id="user-edit" method="POST" enctype="multipart/form-data" action="/update">
              <div class="mb-3">
                <label for="name" class="form-label text-secondary fw-semibold">User Name</label>
                <input type="text" class="form-control" id="user-name" name="name">
                <small class=" text-danger" id="e_user_name"></small>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label text-secondary fw-semibold">Email</label>
                <input  type="email"  class="form-control" id="email" name="email">
                <small class=" text-danger" id="e_user_email"></small>
              </div>

              <button type="submit" class="btn btn-primary">Update <i class="fa fa-plus-circle ms-2"></i></button>
            </form>
          </div>

          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
            <form id="user-password-edit" method="POST" enctype="multipart/form-data" action="/product/create">
              <div class="mb-3">
                <label for="current-password" class="form-label text-secondary fw-semibold">Current Password</label>
                <input type="password" class="form-control" id="current-password" name="current_password">
                <small class=" text-danger" id="e_c_password"></small>
              </div>
              <div class="mb-3">
                <label for="update-passoword" class="form-label text-secondary fw-semibold">New Password</label>
                <input type="password" class="form-control" id="update-password" name="update_password">
                <small class=" text-danger" id="e_u_password"></small>
              </div>

              <button type="submit" class="btn btn-primary">Update <i class="fa fa-plus-circle ms-2"></i></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>