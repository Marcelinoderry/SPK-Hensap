<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4><?= $halaman ?></h4>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#!"><?= $halaman ?></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <!-- begin:: table -->
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success btn-sm" type="submit" name="add" id="add"><i class="fa fa-download"></i> Unduh</button>
                    <button class="btn btn-primary btn-sm" type="submit" name="add" id="add"><i class="fa fa-upload"></i> Unggah</button>
                </div>
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="datatabel">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end:: table -->
        </div>
    </div>
</div>