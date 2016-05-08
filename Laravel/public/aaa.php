<div class="about-banner">
    <div class="container">
        <script src="/Upload/Upload//Thuvien1/Lib/js/responsiveslides.min.js"></script>
        <script>
            // You can also use "$(window).load(function() {"
            $(function () {
              // Slideshow 4
              $("#slider3").responsiveSlides({
                auto: true,
                pager: true,
                nav: false,
                speed: 500,
                namespace: "callbacks",
                before: function () {
                  $('.events').append("<li>before event fired.</li>");
                },
                after: function () {
                  $('.events').append("<li>after event fired.</li>");
                }
              });

            });
        </script>
        <!--//End-slider-script -->
        <div  id="top" class="callbacks_container wow fadeInUp" data-wow-delay="0.5s">
            <ul class="rslides" id="slider3">
                <li>
                    <div class="about-banner-info">
                        <h3>Real Estate & Financial Experience</h3>
                        <p>sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur</p>
                    </div>
                </li>
                <li>
                    <div class="about-banner-info">
                        <h3>Real Estate & Financial Experience</h3>
                        <p>sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur</p>
                    </div>
                </li>
                <li>
                    <div class="about-banner-info">
                        <h3>Real Estate & Financial Experience</h3>
                        <p>sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>