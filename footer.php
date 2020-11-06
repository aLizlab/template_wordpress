<?php
/**
 * Time Techonologyテンプレートの Footer ファイルです。
 *
 * @since Time Techonology 1.0.0
 */

?>
    <footer class="footer">
      <div class="container wide">
        <div class="content">
          <a
            href="<?php echo home_url( '/' ); ?>"
            class="link"
          >
            <h2 class="logo">
              <img
                src="<?php echo get_stylesheet_directory_uri() ?>/assets/imgs/logo-white.svg"
                alt="Time Technologies"
                class="logo"
              >
            </h2>
          </a>
          <nav class="nav">
            <ul class="pages">
              <li class="page">
                <a
                  href="<?php echo site_url('/recruit'); ?>"
                  class="link font-proxima-nova semi-bold white"
                >
                  Recruit
                </a>
              </li>
              <li class="page">
                <a
                  href="<?php echo site_url('/news'); ?>"
                  class="link font-proxima-nova semi-bold white"
                >
                  News
                </a>
              </li>
              <li class="page">
                <a
                  href="<?php echo site_url('/company'); ?>"
                  class="link font-proxima-nova semi-bold white"
                >
                  Company
                </a>
              </li>
              <li class="page">
                <a
                  href="https://form.run/@info-1592908805"
                  target="_blank"
                  rel="noopener"
                  class="link font-proxima-nova semi-bold white"
                >
                  Contact
                </a>
              </li>
              <li class="page">
                <a
                  href="<?php echo site_url('/privacypolicy'); ?>"
                  class="link font-proxima-nova semi-bold white"
                >
                  Privacy Policy
                </a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="hr"></div>
        <p class="copyright gray-light">
          ©︎︎2020 TimeTechnologies Ltd.
        </p>
      </div>
    </footer><!-- #site-footer -->

    <?php wp_footer(); ?>

  </body>
</html>
