<?php
/* @var $this SiteController */

use yii\widgets\ListView;
use yii\helpers\Url;

$this->context->title = Yii::$app->name;

?>
<div class="main_slider">
    <div class="row main_slider__wrapper" data-type="carousel" data-item="3" data-medium-count="2" data-small-count="2" data-controls="true" data-dots="false" data-infinite="true" data-slidesToScroll="1" data-centerMode="true">
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/1.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/1.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/2.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/2.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/3.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/3.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/4.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/4.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/5.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/5.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
        <div class="col-12 col-md-6 col-lg-4 main_slider__slide">
            <a href="#" class="main_slider__item" style="background-image: url('/images/banners/6.jpg');">
                <img src="/images/loader.svg" data-src="/images/banners/6.jpg" alt="" class="main_slider__img">
                <span class="main_slider__descr">
              <span class="main_slider__title">Заказывайте услуги</span>
              <span class="main_slider__subtitle">Новые услуги для продавцов</span>
            </span>
            </a>
        </div>
    </div>
</div>
    <?php if (is_array($roots)):?>
    <div class="category_slider">
        <div class="section-title">
            <h3 class="section-title__value">Выберите категорию</h3>
        </div>
        <div class="category_slider__wrapper" data-type="carousel" data-item="8" data-medium-count="6" data-small-count="4" data-mini-count="2" data-controls="true" data-dots="false">
             <?php foreach ($roots as $cat):
                 $url = Url::to(['adverts/category', 'id' => $cat->id]);
             ?>
            <div class="category_slider__slide">
                <a href="<?= $url ?>" class="category_slider__item">
                    <span class="category_slider__image"><img src="/images/loader.svg" data-src="/images/category/<?= $cat->icon ?>" alt="<?= $cat->name ?>" class="category_slider__img"></span>
                    <span class="category_slider__title"><?= $cat->name ?></span>
                </a>
            </div>
             <?php endforeach; ?>

        </div>
    </div>
    <?php endif; ?>
        <div class="row content_page__row">
            <div class="col-12 col-lg-9 content_page__content">
                <div class="section-title">
                    <h3 class="section-title__value">Все объявления</h3>
                    <div class="section-title__options">
                        <select name="sort" class="product-sort__select">
                            <option value="">По умолчанию</option>
                        </select>
                    </div>
                </div>
                <?php echo $this->render('/adverts/_list', ['dataProvider'=>$indexAdv]);?>
            </div>
            <div class="col-12 col-lg-3 content_page__sidebar">
                <div class="sidebar-social">
                    <div class="sidebar-social__title">Юла в социальных сетях</div>
                    <ul class="sidebar-social__list">
                        <li class="sidebar-social__item">
                            <a href="#" class="sidebar-social__link _vk">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path fill-rule="evenodd" d="M22.153 18.052s1.415 1.396 1.764 2.045c.01.013.015.026.018.033.142.238.175.423.105.562-.117.23-.517.343-.653.353h-2.5c-.174 0-.537-.045-.977-.348-.338-.237-.672-.625-.997-1.004-.485-.563-.905-1.05-1.328-1.05a.508.508 0 0 0-.158.025c-.32.104-.73.56-.73 1.777 0 .38-.3.598-.512.598H15.04c-.39 0-2.422-.136-4.222-2.035-2.203-2.325-4.186-6.988-4.203-7.031-.125-.302.133-.464.415-.464h2.525c.337 0 .447.205.523.387.09.212.42 1.053.962 2 .878 1.543 1.417 2.17 1.848 2.17a.5.5 0 0 0 .232-.06c.563-.313.458-2.322.433-2.738 0-.079-.001-.899-.29-1.292-.206-.285-.558-.393-.771-.433a.918.918 0 0 1 .331-.282c.387-.193 1.084-.222 1.775-.222h.385c.75.01.944.059 1.215.127.55.132.562.487.514 1.702-.015.345-.03.735-.03 1.195 0 .1-.005.206-.005.32-.017.618-.037 1.32.4 1.608a.36.36 0 0 0 .19.055c.151 0 .608 0 1.845-2.122a16.19 16.19 0 0 0 .991-2.123c.025-.043.099-.177.185-.228a.443.443 0 0 1 .207-.049h2.968c.324 0 .545.049.587.174.073.198-.013.803-1.368 2.638l-.605.798c-1.229 1.61-1.229 1.692.076 2.914z"></path></svg>
                            </a>
                        </li>
                        <li class="sidebar-social__item">
                            <a href="#" class="sidebar-social__link _ok">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path d="M15.946 16.395c-2.544-.01-4.592-2.09-4.582-4.645.01-2.557 2.074-4.658 4.623-4.686 2.567-.028 4.66 2.059 4.648 4.65-.013 2.593-2.122 4.692-4.689 4.681zm.028-6.595a1.948 1.948 0 0 0-1.922 1.94 1.912 1.912 0 0 0 1.907 1.924 1.948 1.948 0 0 0 1.932-1.94A1.908 1.908 0 0 0 15.974 9.8zm4.669 9.678a8.876 8.876 0 0 1-2.491 1.047l2.23 2.268c.493.501.49 1.303-.008 1.788a1.26 1.26 0 0 1-1.782-.03l-2.615-2.67-2.615 2.586c-.243.24-.41.279-.559.344l-.316.008a1.23 1.23 0 0 1-.87-.38 1.255 1.255 0 0 1 .005-1.762l2.193-2.182a8.766 8.766 0 0 1-2.489-1.095 1.398 1.398 0 0 1-.422-1.91 1.357 1.357 0 0 1 1.89-.424 5.98 5.98 0 0 0 6.367.027 1.403 1.403 0 1 1 1.482 2.385z" fill-rule="evenodd"></path></svg>
                            </a>
                        </li>
                        <li class="sidebar-social__item">
                            <a href="#" class="sidebar-social__link _facebook">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path fill-rule="evenodd" d="M19.79 11.057h-2.405c-.285 0-.602.375-.602.873v1.737h3.009l-.455 2.476h-2.554v7.435h-2.838v-7.435H11.37v-2.476h2.575V12.21c0-2.09 1.45-3.788 3.44-3.788h2.405v2.635z"></path></svg>
                            </a>
                        </li>
                        <li class="sidebar-social__item">
                            <a href="#" class="sidebar-social__link _twitter">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path fill-rule="evenodd" d="M22.508 13.107c.007.136.009.273.009.406 0 4.167-3.169 8.969-8.965 8.969-1.78 0-3.437-.52-4.83-1.417.245.03.496.042.751.042a6.311 6.311 0 0 0 3.914-1.349 3.158 3.158 0 0 1-2.944-2.186 3.166 3.166 0 0 0 1.422-.055 3.154 3.154 0 0 1-2.528-3.09v-.039a3.16 3.16 0 0 0 1.428.395 3.15 3.15 0 0 1-1.402-2.625c0-.576.155-1.12.427-1.585a8.96 8.96 0 0 0 6.495 3.295 3.152 3.152 0 0 1 5.37-2.875 6.33 6.33 0 0 0 2-.765 3.166 3.166 0 0 1-1.385 1.745 6.33 6.33 0 0 0 1.81-.498 6.39 6.39 0 0 1-1.572 1.632z"></path></svg>
                            </a>
                        </li>
                        <li class="sidebar-social__item">
                            <a href="#" class="sidebar-social__link _youtube">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="currentColor"><path d="M16 0c8.837 0 16 7.163 16 16s-7.163 16-16 16S0 24.837 0 16 7.163 0 16 0zm9.12 11.852a2.4 2.4 0 0 0-1.69-1.699c-1.492-.401-7.47-.401-7.47-.401s-5.98 0-7.47.401a2.4 2.4 0 0 0-1.69 1.699c-.4 1.498-.4 4.624-.4 4.624s0 3.126.4 4.624a2.4 2.4 0 0 0 1.69 1.698c1.49.402 7.47.402 7.47.402s5.978 0 7.47-.402a2.4 2.4 0 0 0 1.69-1.698c.399-1.498.399-4.624.399-4.624s0-3.126-.4-4.624z"></path><path d="M14.048 19.358l4.967-2.882-4.967-2.882v5.764"></path></svg>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebar-menu">
                    <ul class="sidebar-menu__list">
                        <li class="sidebar-menu__item"><a href="#" class="sidebar-menu__link">Лицензионное соглашение</a></li>
                        <li class="sidebar-menu__item"><a href="#" class="sidebar-menu__link">Реклама на Юле</a></li>
                        <li class="sidebar-menu__item"><a href="#" class="sidebar-menu__link">Помощь</a></li>
                    </ul>
                </div>
            </div>
        </div>

</div>






