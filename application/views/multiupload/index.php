<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <div class="container mt-2">
        <h2 class="text-danger"><?= $this->session->flashdata('status'); ?></h2>
        <h3 class="">Upload Image</h3>
        <div class="card">
            <div class="card-header">
                Upload Image
            </div>
            <div class="card-body">
                <?= form_open_multipart('multiupload/file'); ?>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Gambar </label>
                    <div class="col-sm-8">
                        <input type="hidden" name="id" value="">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="image" name="image[]" multiple>
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <?= form_close(); ?>

            </div>
        </div>


        <div class="card mt-2">
            <div class="card-header">
                Upload Image
            </div>
            <div class="card-body">
                <div class="row">
                    <?php foreach ($group_image as $group) : ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="<?= base_url('assets/images/' . $group['image']); ?>" class="img-fluid mb-2" alt="Responsive image">
                                </div>
                                <div class="card-footer">
                                    <a href="<?= base_url('multiupload/detail/' . $group['group_image']); ?>" class="btn btn-primary">Detail</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass('selected').html(fileName);
        });
    </script>
</body>

</html>