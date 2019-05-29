<footer id="footer" class="section section-grey">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <!-- footer logo -->
                    <div class="footer-logo">
                        <a class="logo" href="#">
                <img src="{{ asset('users/img/logo.png') }}" alt="">
              </a>
                    </div>
                    <!-- /footer logo -->

                    <p>{{ __('app.addres_company') }}</p>

                    <!-- footer social -->
                    {{-- <ul class="footer-social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                    </ul> --}}
                    <!-- /footer social -->
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer widget -->

            <div class="clearfix visible-sm visible-xs"></div>

            <!-- footer widget -->
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">{{ __('app.map') }}</h3>
                    <ul class="list-links">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.662667194022!2d105.75962551440756!3d21.046179392560454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454c3ce577141%3A0xb1a1ac92701777bc!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBUw6BpIG5ndXnDqm4gdsOgIE3DtGkgdHLGsOG7nW5nIEjDoCBO4buZaQ!5e0!3m2!1svi!2s!4v1559130475960!5m2!1svi!2s" width="500" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer subscribe -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">{{ __('app.social') }}</h3>
                    <ul class="footer-social">
                        <li><a href="https://facebook.com"><i class="fa fa-facebook fa-2x"></i></a></li>
                        <li><a href="https://facebook.com"><i class="fa fa-twitter fa-2x"></i></a></li>
                        <li><a href="https://facebook.com"><i class="fa fa-instagram fa-2x"></i></a></li>
                        <li><a href="https://facebook.com"><i class="fa fa-google-plus fa-2x"></i></a></li>
                        <li><a href="https://facebook.com"><i class="fa fa-pinterest fa-2x"></i></a></li>
                    </ul>
                </div>
            </div>
            <!-- /footer subscribe -->
        </div>
        <!-- /row -->
        <hr>
        <!-- row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <!-- footer copyright -->
                <div class="footer-copyright">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> Masha life <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Masha</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
                <!-- /footer copyright -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->


    <!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      xfbml            : true,
      version          : 'v3.3'
    });
  };

  (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=setup_tool
  page_id="1246659325501178"
  logged_in_greeting="Hi! How can we help you?"
  logged_out_greeting="Hi! How can we help you?">
</div>
</footer>