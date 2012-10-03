        <footer>
            <hr>
            <ul id="footerContainer">
                <li class="left">&copy; 2012 videouri.com</li>
                <li class="right">
                    <ul>
                        <li>
                            <a href="" class="family-filter">
                                <?php echo ($this->input->cookie('ff') == "off" ? lang('ff_off') : lang('ff_on')); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </footer>

        <script>
            var uvOptions = {};
            (function() {
                var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
                uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'appwidget.uservoice.com/tkqfx5ehyGPj3L2I5YA.js?_nc=true';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
            })();
        </script>
        
        <script src="<?=base_url();?>assets/js/libs/jquery.prettydate.js"></script>
        <script src="<?=base_url();?>assets/js/libs/jquery.cookie.js"></script>
        <script> $.query = { spaces: false }; </script>
        <script src="<?=base_url();?>assets/js/libs/jquery.query.js"></script>
        <script src="<?=base_url();?>assets/js/libs/jquery-sticklr-1.4.min.js"></script>
        <script src="<?=base_url();?>assets/js/script.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-28752800-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        <script>
          /*var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-28752800-1']);
          _gaq.push(['_trackPageview']);
          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();*/
        </script>

    </body>
</html>