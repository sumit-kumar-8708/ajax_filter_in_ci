<style>
    .app-main .app-main__inner {
        padding: 10px 30px 0;
    }

    .dashboard_card {
        margin-bottom: 25px;
    }

    .course_header {
        margin-bottom: 10px;
    }

    .add_btn_div {
        text-transform: capitalize;
        margin-bottom: 20px;
    }

    .save_btn {
        color: #fff !important;
    }

    .add_button {
        margin-left: 190px;
        margin-top: 15px;
    }

    .advance_filter {
        font-size: 15px;
        font-weight: bold;
    }

    .label_css {
        font-size: 14px;
    }

    .filter__Box {
        padding-top: 5px;
        border: 2px solid #17a2b8;
        border-radius: 10px;
        margin: 0px 0px;

    }
</style>
<link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css'>
<div class="col-md-10 mt-3">
    <div class=" ">
        <div class="h_text_breadcrumb">
            <section class="course_header">
                <h4><b>User List :</b></h4>
            </section>
            <section class="navigation_bar">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="https://abl.leco.live/abl/dashboard"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">User List</li>
                    </ol>
                </nav>
            </section>
        </div>

        <div class="row dashboard_card mr-1 ">
            <div class="col-md-12 card " style=" padding: 10px;">               
                <div class="btns__section">
                    <div style="display: flex;  justify-content: space-between; ">                 
                        <div class="add_btn_div">
                            <a href="<?= base_url() ?>user/add_user" class="btn btn-primary save_btn">Add user <i class="fa fa-plus" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="add_btn_div">
                            <a href="javascript:void(0)" class="btn btn-primary save_btn" data-toggle="modal" data-target="#upload_users">Upload Users via excell <i class="fa fa-upload" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>


                <!-- advance filter search box start  here -->

                <div style=" display: flex; justify-content: space-between;">                
                    <label for="" class='text-danger advance_filter'>Advance Filter : </label>
                    <label for="" class="text-danger advance_filter">
                        <a class="text-danger" href="<?= base_url() . 'user/reset_user_filter' ?>"> Reset Filter</a>
                    </label>
                </div>

                <?php $advance_search = $this->session->userdata('user_filter')  ?>
                <form action="<?php echo base_url() . 'user' ?>" method="post">
                    <div class="row mb-3 filter__Box ">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="Exam" class="label_css">Email / Phone</label>
                                <input type="text" class="form-control" name="email_phone" placeholder="Enter email or phone" value="<?= $advance_search['email_phone']  ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Section" class="label_css">User Type</label>
                                <select name="user_type" class="form-control " id="user_type">
                                    <option value="">---Select---</option>
                                    <option value="1" <?= $advance_search['user_type'] == 1 ? 'selected' : '' ?>>Admin</option>
                                    <option value="2" <?= $advance_search['user_type'] == 2 ? 'selected' : '' ?>>Staff Academic</option>
                                    <option value="3" <?= $advance_search['user_type'] == 3  ? 'selected' : '' ?>>Mentor</option>
                                    <option value="4" <?= $advance_search['user_type'] == 4  ? 'selected' : '' ?>>Student </option>
                                    <option value="5" <?= $advance_search['user_type'] == 5  ? 'selected' : '' ?>>Staff Counsellor</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="Section" class="label_css">Status </label>
                                <select name="status" class="form-control " id="status">
                                    <option value="">---Select---</option>
                                    <option value="2" <?= $advance_search['status'] == 2 ? 'selected' : '' ?>>Active</option>
                                    <option value="1" <?= $advance_search['status'] == 1 ? 'selected' : '' ?>>DeActive</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="save_btn form-control">Search</button>
                            </div>
                        </div>

                    </div>
                </form>
                <!-- advance filter search box end here -->


                <section>
                    <? if ($this->session->flashdata('message')) :  ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('message') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <? elseif ($this->session->flashdata('msg')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $this->session->flashdata('msg') ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <? endif; ?>
                    <table class="table table-striped table-hover datatable" id="table">
                        <thead class="cf">
                            <tr class="draggable">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>User Type</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>
</div>


<!-- upload user modal -->
<div class="modal fade" id="upload_users" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style=" float: right; ">
           
       
                    <a href="https://leco.live/abl/uploads/files/uplaod_users.xlsx" class="text-danger">Demo Excell File</a>
                </div>
                <form action="<?= base_url() ?>user/user_upload_using_excell" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="upload_users">Excell File <span class="text-danger">*</span> </label>
                        <input type="file" class="form-control" id="upload_users" name="file" required>
                    </div>
                    <button type="submit" class="btn save_btn">Upload</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.js" integrity="sha512-CX7sDOp7UTAq+i1FYIlf9Uo27x4os+kGeoT7rgwvY+4dmjqV0IuE/Bl5hVsjnQPQiTOhAX1O2r2j5bjsFBvv/A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> -->

<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>

<script type="text/javascript">
    <?php
    $url = base_url("user/ajax_user_list?");
    ?>
    $(document).ready(function() {

        oTable = $('#table').dataTable({

            "bFilter": true,
            "bInfo": true,
            "bSort": true,
            "bAutoWidth": false,
            "bProcessing": true,
            "bServerSide": true,
            "stateSave": true,
            "aaSorting": [
                [0, 'desc']
            ],
            "sAjaxSource": '<?= $url; ?>',
            "sServerMethod": "POST",
            'columnDefs': [{
                "targets": [0, ],
                "orderable": false
            }]

        });
    });



    // $(document).ready(function() {

    //     $(document).on('click', '.teacher_info', function(e) {
    //         var $el = $(this);
    //         var user_mentor_id = $el.data('user_mentor_id');
    //         // console.log(user_mentor_id);
    //         if (user_mentor_id) {
    //             $('#mentor_modal').modal('show');
    //             $.ajax({
    //                 url: '<?= base_url() . 'user/mentor_details' ?>',
    //                 type: 'POST',
    //                 dataType: "json",
    //                 data: 'user_mentor_id=' + user_mentor_id,
    //                 success: function(response) {
    //                     // console.log(response['charges1']); 
    //                     $('#mentor_charges').val(response['charges'])

    //                     document.getElementById("user_mentor_id").innerHTML = response['id'];
    //                     document.getElementById("mentor_name").innerHTML = response['name'];
    //                     document.getElementById("intro").innerHTML = response['intro'];
    //                     // document.getElementById("mentor_charges").innerHTML = response['charges'];

    //                 }
    //             });
    //         }
    //     });
    // });
</script>