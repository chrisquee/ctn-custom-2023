<div class="share vertical d-none d-xl-block">
        <?php
              global $wp;
              $current_url = home_url(add_query_arg(array(), $wp->request));

              $posttitle = get_the_title($post->ID);
              $posturl = home_url(add_query_arg(array(), $wp->request));
        ?>
    
        <div class="share-close">
            <span class="material-symbols-outlined">close</span>
        </div>
                
        <ul class="social-share-col">

            <li class="facebook">
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo @urlencode($posturl); ?>" title="Facebook" target="_blank">
                    <span class="icon icon-facebook-f"></span>
                </a>
            </li>

            <li class="twitter">
                <a href="https://twitter.com/intent/tweet/?text=<?php echo @urlencode($posttitle); ?>&amp;url=<?php echo @urlencode($posturl); ?>'&amp;via=avbusinessnews&hashtags=avbusinessnews" title="Twitter" target="_blank">
                    <span class="icon icon-twitter"></span>
                </a>
            </li>

            <li class="linkedin">
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo @urlencode($posturl); ?>&title=<?php echo @urlencode($posttitle); ?>" title="LinkedIn" target="_blank">
                    <span class="icon icon-linkedin"></span>
                </a>
            </li>

            <li class="whatsapp">
                <a href="https://wa.me/?text=<?php echo @urlencode('Hi, I found this on aviationbusinessnews.com, and thought you might be interested - ' . $posttitle . ' - ' . $posturl); ?>" title="Whatsapp" target="_blank">
                    <span class="icon icon-whatsapp"></span>
                </a>
            </li>

            <li class="reddit">
                <a href="https://reddit.com/submit?url=<?php echo @urlencode($posturl); ?>&title=<?php echo @urlencode($posttitle); ?>" target="_blank" title="Share on Reddit" rel="noopener" >
                    <span class="icon icon-reddit"></span>
                </a>
            </li>

            <li class="email">
                <a href="mailto:?to=&body=<?php echo 'I found this on ' . site_url() . ' and thought you would be interested: %0D%0A%0D%0A' . $posturl; ?>,&subject=<?php echo $posttitle; ?>" target="_blank" title="Share by email" rel="noopener" >
                    <span class="icon icon-mail_outline"></span>
                </a>
            </li>

            <li class="link">
                <a href="#copy-share-url" target="_blank" title="Copy Link" rel="noopener" >
                    <span class="icon icon-link"></span>
                </a>
            </li>

        </ul>
        
    </div>