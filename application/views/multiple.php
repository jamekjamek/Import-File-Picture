<div style="width:720px; margin:auto;">
   <h2>Codeigniter Multiple File Upload with image Resizing/thumbnail</h2>
   <div>Demo <a href="http://www.mostlikers.com/2017/03/codeigniter-multiple-file-upload-with-resize.html">Tutorial Link</a>
      - mostlikers blog
      <a href="http://www.mostlikers.com">mostlikers.com</a><br><br>
   </div>
   <div class="form_data">
      <form method="post" action="<?php echo site_url('users/upload_multiple') ?>" enctype="multipart/form-data">
         <input type="file" multiple="multiple" name="userfile[]">
         <input type="submit" value="Upload image" name="submit">
      </form>
   </div>
   <!--uploaded Image -->
   <?php if (isset($all_image)) : ?>
      <table width="50%" cellpadding="1" cellspacing="0">
         <?php foreach ($all_image as $image) : ?>
            <tr>
               <td><img class="img" src="<?= base_url() . 'uploads/gallery/' . $image->image ?>"></td>
               <td><img class="img" src="<?= base_url() . 'uploads/gallery/thumbs/' . $image->image ?>"></td>
            </tr>
         <?php endforeach; ?>
      </table>
   <?php endif; ?>
   <!-- End upload -->
</div>
<style type="text/css">
   .form_data {
      border-style: dotted;
      padding: 20px;
      margin-bottom: 50px;
   }

   .img {
      max-width: 100%;
      height: auto;
      padding: 4px;
      line-height: 1.42857143;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 4px;
      -webkit-transition: all .2s ease-in-out;
      -o-transition: all .2s ease-in-out;
      transition: all .2s ease-in-out;
   }
</style>