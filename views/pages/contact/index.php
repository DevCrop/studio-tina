<!-- contents -->
<?php section('seo_title', __('about.seo_title')) ?>
<?php section('seo_desc', __('about.seo_desc')) ?>
<?php section('seo_keywords', __('about.seo_keywords')) ?>
<?php section('main_class', 'sub-contact') ?>

<?php section('content') ?>

<script charset="UTF-8" class="daum_roughmap_loader_script"
    src="https://ssl.daumcdn.net/dmaps/map_js_init/roughmapLoader.js">
</script>

<h1 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
    <?= __('about.seo.h1') ?>
</h1>
<h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
    <?= __('about.seo.h2_1') ?>
</h2>
<h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
    <?= __('about.seo.h2_2') ?>
</h2>
<h2 style="position:absolute;overflow:hidden;width:1px;height:1px;padding:0;margin:-1px;border:0;clip:rect(0,0,0,0);">
    <?= __('about.seo.h2_3') ?>
</h2>


<div class="no-sub-contact-bg-wrap">
    <section class="no-sub-contact-visual">
        <div class="no-container-2xl">
            <h2 class="f-display-1 --semibold --tal">Contact With Me</h2>
            <h2 class="f-display-1 --semibold --tar">Have a Project?</h2>
        </div>
    </section>

    <section class="no-sub-contact-form ">
        <div class="no-container-2xl">
            <fieldset class="no-sub-contact-form-fieldset">
                <legend class="--blind">Contact Form</legend>
                <form id="contactForm" action="" method="post">
                    <div class="no-form-container">
                        <div class="no-form-control">
                            <input type="text" name="name" id="name" required>
                            <label for="name">Name</label>
                        </div>
                        <div class="no-form-control">
                            <input type="email" name="email" id="email" required>
                            <label for="email">Email</label>
                        </div>
                        <div class="no-form-control">
                            <input type="tel" name="phone" id="phone" required>
                            <label for="phone">Phone</label>
                        </div>
                        <div class="no-form-control">
                            <input type="text" name="company" id="company" required>
                            <label for="company">Company</label>
                        </div>
                        <div class="no-form-control --full">
                            <textarea name="contents" id="contents" required></textarea>
                            <label for="contents">Contents</label>
                        </div>
                    </div>
                    <div class="no-form-submit">
                        <button type="submit" class="f-heading-4 --regular">Send Message</button>
                    </div>
                </form>
                <div class="no-sub-contact-info">
                    <ul>
                        <li>
                            <span class="f-body-3">Email</span>
                            <p class="f-body-1">tina@studiotina.co.kr</p>
                        </li>
                        <li>
                            <span class="f-body-3">Phone</span>
                            <p class="f-body-1">+82 2 517 8080</p>
                        </li>
                        <li>
                            <span class="f-body-3">Fax</span>
                            <p class="f-body-1">+82 2 517 8080</p>
                        </li>
                        <li>
                            <span class="f-body-3">Address</span>
                            <p class="f-body-1">서울시 강남구 강남대로 636 두원빌딩 6층</p>
                        </li>
                    </ul>
                </div>
            </fieldset>
        </div>
    </section>
    <div class="no-sub-contact-bg">
        <img src="/resource/images/bg/gradient_bg.png" alt="">
    </div>
</div>
<section class="no-sub-contact-map ">
    <div id="daumRoughmapContainer1760408745989" class="root_daum_roughmap root_daum_roughmap_landing"
        data-lenis-prevent></div>
</section>



<?php end_section() ?>

<?php section('script') ?>



<!-- 3. 실행 스크립트 -->
<script>
new daum.roughmap.Lander({
    "timestamp": "1760408745989",
    "key": "xy4bdu6h6q8",
    "mapWidth": "640",
    "mapHeight": "360"
}).render();



document.addEventListener('DOMContentLoaded', function() {
    // 스냅샷 애니메이션 초기화
    if (typeof subSnapAnimation === 'function') {
        subSnapAnimation();
    }

    // Floating Label 인터랙션
    const formControls = document.querySelectorAll('.no-form-control');

    formControls.forEach(control => {
        const input = control.querySelector('input, textarea');

        if (input) {
            // 포커스 이벤트
            input.addEventListener('focus', function() {
                control.classList.add('--focused');
            });

            // blur 이벤트
            input.addEventListener('blur', function() {
                if (!this.value) {
                    control.classList.remove('--focused');
                }
            });

            // 페이지 로드 시 이미 값이 있으면 label 올리기
            if (input.value) {
                control.classList.add('--focused');
            }
        }
    });

    // Contact Form Submit
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;

            // 버튼 비활성화 및 로딩 표시
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sending...';

            try {
                const response = await fetch('/module/ajax/request.process.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.result === 'success') {
                    alert(data.msg);
                    // 폼 초기화
                    this.reset();
                    // Floating label 클래스 제거
                    formControls.forEach(control => {
                        control.classList.remove('--focused');
                    });
                } else {
                    alert(data.msg);
                }
            } catch (error) {
                alert('처리 중 오류가 발생했습니다. 다시 시도해주세요.');
                console.error('Error:', error);
            } finally {
                // 버튼 복구
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }
});
</script>

<?php end_section() ?>