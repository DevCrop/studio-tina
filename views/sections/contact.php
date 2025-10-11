<section class="no-contact">
    <div class="container-xl">
        <a href="/<?=app()->getLocale()?>/contact" class="contact-btn">
            <div class="txt">
                <span>
                    <?= $sub_title ?>
				</span>
                <h2 class="poppins">Let's Turn Ideas<br> into Reality</h2>
            </div>
        </a>

        <?php if ($rolling): ?>
        <div class="running-wrap left">
            <ul class="running-image marquee-wrap" id="left">
                <li><img src="/resource/images/contact-left1.jpg"></li>
                <li><img src="/resource/images/contact-left2.jpg"></li>
                <li><img src="/resource/images/contact-left3.jpg"></li>
                <li><img src="/resource/images/contact-left4.jpg"></li>
                <li><img src="/resource/images/contact-left5.jpg"></li>
            </ul>
        </div>
        
        <div class="running-wrap right">
            <ul class="running-image" id="right">
                <li><img src="/resource/images/contact-right1.jpg"></li>
                <li><img src="/resource/images/contact-right2.jpg"></li>
                <li><img src="/resource/images/contact-right3.jpg"></li>
                <li><img src="/resource/images/contact-right4.jpg"></li>
                <li><img src="/resource/images/contact-right5.jpg"></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</section>
