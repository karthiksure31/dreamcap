<div id="contact" class="esport-team-landing-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <span class="header">contact us</span>
                <span class="welcome">welcome to family</span>
                <ul class="contact-list">
                    <li class="phone"><i class="fa fa-phone" aria-hidden="true"></i><span>+91 8778207567</span></li>
                    <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:dreamcapvc@gmail.com">dreamcapvc@gmail.com</a></li>
                </ul>
                <span class="welcome">About us</span>
                <p>With our system, we can provide you with a good combination of teams to fulfill your dreams.</p>
            </div>
            <div class="col-md-6 col-sm-6">
                @if(session('status'))
                <div class="alert alert-success mb-1 mt-1">
                    {{ session('status') }}
                </div>
                @endif
                <form id="submitFeedBack" action="{{ route('customer.feedback') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <p>Name:<span class="text-danger">*</span></p>
                        <input type="text" name="name" class="form-control" placeholder="Name">

                    </div>
                    <div class="form-group">
                        <p>Email:<span class="text-danger">*</span></p>
                        <input type="email" name="email" class="form-control" placeholder="Company Email">
                    </div>
                    <div class="form-group">
                        <p>Share your experience:<span class="text-danger">*</span></p>
                        <!-- <label for="heard">Academic Year<span class="text-danger">*</span></label> -->
                        <textarea name="feedback" id="feedback" placeholder="Let we know..."></textarea>
                    </div>
                    <!-- <div>
                        <p>Share your experience</p>
                        <textarea name="exp" id="exp" placeholder="Let we know..."></textarea>
                    </div> -->
                    <button type="submit" class="btn pull-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- FOOTER LINKS BEGIN-->
<div class="esport-team-landing-footer-links">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li class="facebook">
                        <a href="https://www.facebook.com/profile.php?id=100079544871905" target="_blank">
                            <span>facebook</span>
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="twitter" >
                        <a href="https://www.instagram.com/dreamcapvc/" target="_blank">
                            <span>telegram</span>
                            <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li class="instagram">
                        <a href="https://telegram.me/dreamcapvc11" target="_blank">
                            <span>instagram</span>
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- FOOTER LINKS END-->

<script type="text/javascript" src="{{ asset('landing/js/library/jquery-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/library/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/library/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/library/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/library/fancySelect.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/header.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/slider.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/preloader.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/visible.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/anchor.js') }}"></script>
<script type="text/javascript" src="{{ asset('landing/js/main.js') }}"></script>
<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>
<script src="{{ asset('datatable-css-js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable-css-js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('datatable-css-js/jszip.min.js') }}"></script>
<script src="{{ asset('datatable-css-js/pdfmake.min.js') }}"></script>
<script src="{{ asset('datatable-css-js/vfs_fonts.js') }}"></script>
<script src="{{ asset('datatable-css-js/buttons.html5.min.js') }}"></script>
<!-- Init js -->
<script src="{{ asset('js/validation/validation.js') }}"></script>
<script src="{{ asset('landing/js/custom/team-datatable.min.js') }}"></script>
<script src="{{ asset('landing/js/custom/feedback.min.js') }}"></script>
</body>

</html>