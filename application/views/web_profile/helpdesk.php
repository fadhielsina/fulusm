<div class="row border-responsive">
    <div class="col-md-12 col-lg-7 mb-4 mb-lg-0 border-right">
        <div class="text-center" style="margin-top:6%;margin-bottom:6%;">
            <span class="flaticon-customer-service display-4 d-block mb-3 text-primary"></span>
            <h4>Hubungi Kami</h4>
        </div>
        <div class="text-left" style="margin:6%;">


            </p>
            Silahkan hubungi kami, kami dengan senang hati akan membantu anda.
            </p>

            <?= validation_errors(); ?>

            <form class="contact-form" role="form" method="post" action='<?= base_url('welcome/helpdesk') ?>'>

                <div class="form-group">
                    <input type="text" name="nama" class="form-control" placeholder="Nama:" />
                </div>

                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="E-mail:" />
                </div>

                <div class="form-group">
                    <textarea class="form-control" name="pesan" placeholder="Pesan:" rows="6"></textarea>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary" name="Send">Kirim</button>
                </div>

            </form>
        </div>
    </div>
    <div class="col-md-12 col-lg-5 mb-4 mb-lg-0 border-right">

        <div class="text-center" style="margin-top:6%;margin-bottom:6%;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4138143183886!2d106.8162105143628!3d-6.20902399550518!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f4029ae3c4db%3A0x26af7054c23b9142!2s1518%2C+Citylofts+Sudirman%2C+Jl.+K.H.+Mas+Mansyur+No.121%2C+RT.10%2FRW.11%2C+Karet+Tengsin%2C+Tanahabang%2C+Kota+Jakarta+Pusat%2C+Daerah+Khusus+Ibukota+Jakarta+10250!5e0!3m2!1sen!2sid!4v1553686092323" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>
</div>